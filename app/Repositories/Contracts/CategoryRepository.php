<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface
{
    public function getAll();

    public function getAllByParentId(int $id);

    public function getById(int $id);
}
