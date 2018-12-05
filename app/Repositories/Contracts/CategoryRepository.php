<?php

namespace App\Repositories\Contracts;

interface CategoryRepository
{
    public function getAll();

    public function getAllParents();

    public function getAllChildren();

    public function getAllByParentId(int $id);

    public function getChildrenFor(array $ids);

    public function getById(int $id);

    public function getLevelWithChildren($parent_id);
}
