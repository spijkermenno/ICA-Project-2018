<?php

namespace App\Repositories\Contracts;

interface ItemRepository
{
    public function getAll();

    public function getById(int $id);

    public function getAllBetween(int $from, int $to);

    public function getSoonEndingItems(int $amount);

    public function updateBuyer(int $id, string $newBuyer);
}
