<?php

namespace App\Repositories;

use App\Repositories\Contracts\BidsRepository;

class DatabaseBidsRepository extends DatabaseRepository implements BidsRepository
{
    /**
     * @return array
     */
    public function getAll()
    {
        return $this->conn->select(
            'SELECT * FROM bids'
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
            'SELECT * FROM bids WHERE id = ?',
            [$id]
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
     * @param int $amout
     * @return mixed|null
     */
    public function getMostPopularItems(int $amount)
    {
        return $this->conn->select(
            sprintf('SELECT TOP %d * FROM items', $amount)
        );
    }
    public function createBid(array $data){
        $keys = collect(array_keys($data));

        return $this->conn->statement('
            INSERT INTO bids
                (' . $keys->implode(', ') . ')
            VALUES
                (' . $keys->map(function ($key) { return ':' . $key; })->implode(', ') . ')
        ', $data);        
    }
}
