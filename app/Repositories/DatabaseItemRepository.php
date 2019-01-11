<?php

namespace App\Repositories;

use App\Repositories\Contracts\ItemRepository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class DatabaseItemRepository
 * @package App\Repositories
 */
class DatabaseItemRepository extends DatabaseRepository implements ItemRepository
{
    /**
     * @return array
     */
    public function getAll()
    {
        return $this->conn->select(
            'SELECT * FROM items'
        );
    }

    public function getItemsBySearch(array $queries, $field, $columns = ['*'], $perPage = 16)
    {
        array_unshift($queries, join(' ', $queries));
        $queryValues = array_map(function ($query) {
            return "%${query}%";
        }, $queries);

        $whereLikeStatement = [];
        for ($i = 0; $i < count($queryValues); $i++) {
            $whereLikeStatement[] = "items.${field} LIKE ? AND auction_closed = 0";
        }

        $whereClause = 'WHERE ' . join(' OR ', $whereLikeStatement);

        $total = $this->conn->select(
            sprintf(
                'SELECT
                    COUNT(*) as count
                FROM items
                    %s
                AND auction_closed = 0
            ',
                $whereClause
            ),
            $queryValues
        )[0]->count;

        $items = $this->conn->select(sprintf('
            SELECT
                ' . implode(',', array_map(function ($column) {
            return 'items.' . $column;
        }, $columns)) . '
            FROM items
                %s
            ORDER BY items.[end] ASC
             OFFSET ' . ($perPage * (request()->get('page', 1) - 1)) . ' ROWS
            FETCH NEXT ' . $perPage . ' ROWS ONLY
        ', $whereClause), $queryValues);

        return new LengthAwarePaginator($items, $total, $perPage, null, [
            'path' => request()->url()
        ]);
    }

    public function saveImages($item_id)
    {
        $errors = [];
        $filenames = [];

        foreach ($_FILES['files']['name'] as $key => $value) {
            $file_name = $_FILES['files']['name'][$key];
            $temp = explode('.', $file_name);
            $extention = end($temp);
            $new_file_name = $item_id . '_' . $key . '.' . $extention;
            $file_target = 'images' . '/' . $new_file_name;

            $file_tmp = $_FILES['files']['tmp_name'][$key];

            if (move_uploaded_file($file_tmp, $file_target)) {
                array_push($filenames, '/' . $file_target);
            } else {
                array_push($errors, $file_name);
            }
        }

        // when the file saving returned errors all the files are deleted.
        if (count($errors) > 0) {
            foreach ($filenames as $filename) {
                unlink('images/' . $filename);
            }
        } else {
            $this->createImageRecords($filenames, $item_id);
        }
        return $errors;
    }

    public function createImageRecords($filenames, $item_id)
    {
        foreach ($filenames as $filename) {
            $this->conn->insert('insert into images (filename, item_id) values (:filename, :item_id)', ['filename' => $filename, 'item_id' => $item_id]);
        }
    }

    public function getLastId()
    {
        return $this->conn->select('SELECT * FROM items WHERE id = (SELECT MAX(id) FROM items)')[0];
    }

    public function create($insert)
    {
        return $this->conn->insert(
            'insert into items (
                            title,
                            description,
                            start_price,
                            selling_price,
                            payment_instruction,
                            category_id,
                            shipping_cost,
                            seller)
                            OUTPUT INSERTED.ID
                    values (:title,
                            :description,
                            :start_price,
                            :selling_price,
                            :payment_instruction,
                            :category_id,
                            :shipping_cost,
                            :seller)',
            [
                'title' => $insert['title'],
                'description' => $insert['description'],
                'start_price' => $insert['start_price'],
                'selling_price' => $insert['start_price'],
                'payment_instruction' => $insert['payment_instruction'],
                'category_id' => $insert['category_id'],
                'shipping_cost' => $insert['shipping_cost'],
                'seller' => auth()->user()->name
            ]
        );
    }

    /**
     * @return array
     */
    public function getAllBetween(int $from, int $to)
    {
        return $this->conn->select(
            '
            SELECT
                *
            FROM items
            WHERE id BETWEEN ? AND ?',
            [
                $from, $to
            ]
        );
    }

    /**
     * @param int $id
     * @return mixed|null
     */
    public function getById(int $id)
    {
        // TODO: Implement getById() method.

        return $this->conn->select(
            'SELECT * FROM items WHERE id = ?',
            [$id]
        );
    }

    public function getMultipleByIds(array $ids)
    {
        return $this->conn->select('
            SELECT top 16 *
            FROM items
            WHERE category_id IN (
                ' . str_replace_last(',', '', str_repeat('?,', count($ids))) .
            ') and auction_closed = 0
            order by end ASC
        ', $ids);
    }

    public function getMultipleByCategoryIds(array $ids, $columns = ['*'], $perPage = 16)
    {
        $total = $this->conn->select('
            SELECT
                COUNT(*) as count
            FROM items
            WHERE category_id IN (
                ' . str_replace_last(',', '', str_repeat('?,', count($ids))) .
            ')
                and auction_closed = 0
        ', $ids)[0]->count;

        $items = $this->conn->select('
            SELECT
                ' . implode(',', $columns) . '
            FROM items
            WHERE category_id IN (
                ' . str_replace_last(',', '', str_repeat('?,', count($ids))) .
            ')
                AND auction_closed = 0
            ORDER BY [end] ASC
             OFFSET ' . ($perPage * (request()->get('page', 1) - 1)) . ' ROWS
            FETCH NEXT ' . $perPage . ' ROWS ONLY
        ', $ids);

        return new LengthAwarePaginator(
            $this->attachImagesToItems($items),
            $total,
            $perPage,
            null,
            [
                'path' => request()->url()
            ]
        );
    }

    public function getMultipleImages(array $ids)
    {
        return $this->conn->select('
            SELECT
                MIN(filename) as filename,
                item_id
            FROM images
            WHERE item_id IN (
                ' . str_replace_last(',', '', str_repeat('?,', count($ids))) .
            ') group by item_id
        ', $ids);
    }

    public function attachImagesToItems($items)
    {
        if (count($items) < 1) {
            return $items;
        }

        $images = $this->getMultipleImages(array_pluck($items, 'id'));

        $images = collect($images)->keyBy('item_id');

        $collection = collect($items);
        if ($items instanceof LengthAwarePaginator) {
            $collection = $items->getCollection();
        }

        $collection->map(function ($item) use ($images) {
            $item->filename = optional($images->get($item->id))->filename;
            return $item;
        });

        if ($items instanceof LengthAwarePaginator) {
            $items->setCollection($collection);
            $collection = $items;
        }

        return $collection;
    }

    public function getDescriptionById(int $id)
    {
        // TODO: Implement getById() method.

        return $this->conn->select(
            'SELECT description FROM items WHERE id = ?',
            [$id]
        );
    }

    public function getByIdWithImage(int $id)
    {
        // TODO: Implement getById() method.

        return $this->conn->select(
            'SELECT top 1 i.*, im.filename FROM items as i inner join images as im on i.id = im.item_id WHERE i.id = ?',
            [$id]
        );
    }

    public function getImagesForItemId(int $product_id)
    {
        return $this->conn->select(
            'SELECT filename FROM images where item_id = ?',
            [$product_id]
        );
    }

    public function getbyCategoryId(int $category_id)
    {
        return $this->conn->select(
            'SELECT * FROM items where category_id = ? and auction_closed = 0',
            [$category_id]
        );
    }

    public function getbyCategoryIdWithImage(int $category_id)
    {
        return $this->conn->select(
            'select i.*, im.filename FROM items as i inner join images as im on i.id = im.item_id WHERE i.category_id = ? and auction_closed = 0',
            [$category_id]
        );
    }

    public function getBySellerName($username, $closed, $amountMonths = null)
    {
        if ($amountMonths == null) {
            return $this->conn->select('select * from items where seller = :username and auction_closed = :closed', ['username' => $username, 'closed' => $closed]);
        } else {
            return $this->conn->select('select * from items where seller = :username and auction_closed = :closed and datediff(month, [end], current_timestamp) <= :months ', ['username' => $username, 'closed' => $closed, 'months' => $amountMonths]);
        }
    }

    /**
     * @param int $amout
     * @return mixed|null
     */
    public function getMostPopularItems(int $amount, $columns = ['*'])
    {
        return $this->attachImagesToItems(
            $this->conn->select(
                '
                SELECT
                    ' . implode(',', $columns) . '
                FROM items
                WHERE items.id IN (
                    SELECT TOP ' . $amount . '
                        items.id
                    FROM items
                    LEFT JOIN bids ON items.id = bids.item_id
                    WHERE items.auction_closed = 0
                    GROUP BY items.id
                    HAVING COUNT(bids.id) > 0
                    ORDER BY COUNT(bids.id) desc, MAX(bids.date) desc
                )
                '
            )
        );
    }

    public function getSoonEndingItems(int $amount, $columns = ['items.title', 'items.id', 'items.selling_price', 'items.[end]', 'items.start'])
    {
        return $this->attachImagesToItems(
                $this->conn->select(
                '
                SELECT TOP ' . $amount . '
                    ' . implode(',', $columns) . '
                FROM items
                WHERE items.auction_closed = 0
                ORDER BY [end]'
            )
        );
    }

    /**
     * @param int $id
     * @param float $newPrice
     * @return int
     */
    public function updateSellingPrice(int $id, float $newPrice)
    {
        return $this->conn->update('
            UPDATE
                items
            SET
                selling_price = ?
            WHERE id = ?
        ', [$newPrice, $id]);
    }

    /**
     * @param int $id
     * @param float $newPrice
     * @return int
     */
    public function updateBuyer(int $id, string $newBuyer)
    {
        return $this->conn->update('
            UPDATE
                items
            SET
                buyer = ?
            WHERE id = ?
        ', [$newBuyer, $id]);
    }
}
