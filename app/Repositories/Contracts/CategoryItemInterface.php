<?php

namespace App\Repositories\Contracts;

interface CategoryItemInterface
{
    public function getAll();

    public function getById(int $id);

    public function getMostPopularItems(int $amount);
}
