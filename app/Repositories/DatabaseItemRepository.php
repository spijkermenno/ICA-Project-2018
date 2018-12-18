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

    public function getItemsBySearch($query, $field, $amount = 16)
    {
        return $this->conn->select('
            SELECT
                top ' . $amount . ' i.*,
                im.filename
            FROM items i
                inner join images im on i.id = im.item_id
            where i.'.$field.' like :query
            and auction_closed = 0
        ', [
            'query' => '%'. $query .'%'
        ]);
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

    public function getMultipleByCategoryIds(array $ids, $columns = ['*'], $perPage = 16) {
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

        return new LengthAwarePaginator($items, $total, $perPage, null, [
            'path' => request()->url()
        ]);
    }

    public function getMultipleImages(array $ids)
    {
        return $this->conn->select('
            SELECT max (filename) as filename, item_id
            FROM images
            WHERE item_id IN (
                ' . str_replace_last(',', '', str_repeat('?,', count($ids))) .
            ') group by item_id
        ', $ids);
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
            'SELECT i.*, im.filename FROM items as i inner join images as im on i.id = im.item_id WHERE i.id = ?',
            [$id]
        );
    }

    public function getAllImages(int $product_id)
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

    /**
     * @param int $amout
     * @return mixed|null
     */
    public function getMostPopularItems(int $amount, $rubriek_id = null)
    {
        $items = [];
        if ($rubriek_id == null) {
            $item_ids = $this->conn->select(
                sprintf('select top %d b.item_id, count(b.id) as bids from items i inner join bids b on i.id = b.item_id where i.auction_closed = 0 group by b.item_id order by bids desc', $amount)
            );
        } else {
            $item_ids = $this->conn->select(
                sprintf('select top %d b.item_id, count(b.id) as bids from items i inner join bids b on i.id = b.item_id where i.auction_closed = 0 and i.category_id = %d group by b.item_id order by bids desc', $amount, $rubriek_id)
            );
        }

        foreach ($item_ids as $item_id) {
            array_push($items, $this->getByIdWithImage($item_id->item_id)[0]);
        }

        return $items;
    }

    public function getSoonEndingItems(int $amount, $rubriek_id = null)
    {
        if ($rubriek_id == null) {
            $result = $this->conn->select(
                sprintf('select top %d i.title, i.id, i.selling_price, i.[end], im.filename from items as i inner join images as im on i.id = im.item_id where i.auction_closed = 0 order by [end]', $amount)
            );
        } else {
            $result = $this->conn->select(
                sprintf('select top %d i.title, i.id, i.selling_price, i.[end], im.filename from items as i inner join images as im on i.id = im.item_id where i.auction_closed = 0 and i.category_id = %d order by [end]', $amount, $rubriek_id)
            );
        };

        if (count($result) > 0) {
            return $result;
        } else {
            //return $this->getSoonEndingItems($amount, $rubriek_id);
        }
    }

    /**
     * @param int $id
     * @param float $newPrice
     * @return int
     */
    public function update_selling_price(int $id, float $newPrice)
    {
        return $this->conn->update('
            UPDATE
                items
            SET
                selling_price = ?
            WHERE id = ?
        ', [$newPrice, $id]);
    }
}
