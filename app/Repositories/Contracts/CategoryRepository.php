<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface
{
    public function getAll();

    public function getAllParents();

    public function getAllChildren();

    public function getAllByParentId(int $id);

    public function getById(int $id);
}
