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
                sprintf('select top %d i.title, i.id, i.selling_price, i.[end], im.filename from items as i inner join images as im on i.id = im.item_id where DATEDIFF(d, getdate(), i.[end]) !< 0 order by [end]', $amount)
            );
        }
        $result = $this->conn->select(
            sprintf('select top %d i.title, i.id, i.selling_price, i.[end], im.filename from items as i inner join images as im on i.id = im.item_id where DATEDIFF(d, getdate(), i.[end]) !< 0 and i.category_id = %d order by [end]', $amount, $rubriek_id)
        );

        if (count($result) > 0) {
            return $result;
        } else {
            return $this->getSoonEndingItems($amount, ($period + 1));
        }
    }
}
