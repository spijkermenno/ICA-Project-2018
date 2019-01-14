<?php

namespace App\Repositories\Contracts;

interface BidsRepository
{
    public function getAll();

    public function getById(int $id);

    public function getAllByUser(string $user, int $amountMonths);

    public function getMostPopularItems(int $amount);

    public function getAllBetweenId(int $from, int $to);

    public function createBid(array $bid);
}
