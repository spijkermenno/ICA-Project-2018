<?php

namespace App\Repositories;

use App\Repositories\Contracts\ItemRepository;

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

    public function getItemsBySearch($item, $field, $amount = 16)
    {
        return $this->conn->select(
            'SELECT top ' . $amount . ' i.*, im.filename FROM items i inner join images im on i.id = im.item_id where i.'.$field." like '%" . $item . "%' and auction_closed = 0"
        );
    }

    /**
     * @return array
     */
    public function getAllBetween(int $from, int $to)
    {
        return $this->conn->select(
            sprintf('SELECT * FROM items WHERE id BETWEEN %d AND %d', $from, $to)
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
            order by [end] ASC
        ', $ids);
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
        if ($rubriek_id == null) {
            return $this->conn->select(
                sprintf('select top %d i.title, i.id, i.selling_price, i.[end], im.filename from items as i inner join images as im on i.id = im.item_id', $amount)
            );
        }
        return $this->conn->select(
            sprintf('select top %d i.title, i.id, i.selling_price, i.[end], im.filename from items as i inner join images as im on i.id = im.item_id where i.category_id = %d', $amount, $rubriek_id)
        );
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
}
