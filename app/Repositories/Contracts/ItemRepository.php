<?php

namespace App\Repositories\Contracts;

interface ItemRepository
{
    public function getAll();

    public function getById(int $id);

    public function getMostPopularItems(int $amount);
}
