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
     * @param string $user Name of the user
     * @return array
     */
    public function getAllByUser(string $user, int $amountMonths = 3)
    {
        return $this->conn->select(
            'SELECT * FROM bids full outer join items i on bids.item_id = i.id WHERE bids.user_name = :user AND datediff(month, [end], current_timestamp) <= :months',
            ['user' => $user, 
            'months' => $amountMonths]
        );
    }

    /**
     * @param int $id
     * @return mixed|null
     */
    public function getById(int $id)
    {
        return $this->conn->select(
            'SELECT * FROM bids WHERE id = ?',
            [$id]
        );
    }

    /**
     * @param int $from
     * @param int $to
     * @return array
     */
    public function getAllBetweenId(int $from, int $to)
    {
        return $this->conn->select(
            'SELECT * FROM bids WHERE id BETWEEN ? AND ?',
            [$from, $to]
        );
    }

    /**
     * @TODO functionality not implemented yet
     *
     * @param int $amount
     * @return mixed|null
     */
    public function getMostPopularItems(int $amount)
    {
        return $this->conn->select(
            sprintf('SELECT TOP %d * FROM bids', $amount)
        );
    }

    public function createBid(array $data)
    {
        $keys = collect(array_keys($data));

        return $this->conn->statement('
            INSERT INTO bids
                (' . $keys->implode(', ') . ')
            VALUES
                (' . $keys->map(function ($key) {
            return ':' . $key;
        })->implode(', ') . ')
        ', $data);
    }

    /**
     * @param int $amount
     * @param int $itemId
     * @return array
     */
    public function getTopBids(int $amount, int $itemId)
    {
        return $this->conn->select('
            select
                top '.$amount.' user_name, date, price as highest_bid
            from
                bids
            where
                item_id = :item_id
            order by
                highest_bid desc
        ', [
            'item_id' => $itemId
        ]);
    }
}
