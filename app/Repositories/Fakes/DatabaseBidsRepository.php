<?php

namespace App\Repositories\Fakes;

use App\Repositories\DatabaseRepository;
use App\Repositories\Contracts\BidsRepository;

class DatabaseBidsRepository extends DatabaseRepository implements BidsRepository
{
    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function getById(int $id)
    {
        // TODO: Implement getById() method.
    }

    public function getMostPopularItems(int $amount)
    {
        // TODO: Implement getMostPopularItems() method.
    }

    public function getAllBetweenId(int $from, int $to)
    {
        // TODO: Implement getAllBetweenId() method.
    }

    public function createBid(array $bid)
    {
        // TODO: Implement createBid() method.
    }
}
