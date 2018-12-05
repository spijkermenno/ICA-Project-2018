<?php

namespace App\Repositories\Contracts;

interface BidsRepository
{
    public function getAll();

    public function getById(int $id);

    public function getAllBetween(int $from, int $to);

    public function createNewBid(string $bid);
}