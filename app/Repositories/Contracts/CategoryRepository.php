<?php

namespace App\Repositories\Contracts;

interface CategoryRepository
{
    public function getAll();

    public function getAllByParentId($id);

    public function getChildrenFor(array $ids);

    public function getById($id);

    public function getAllParentsById($id);

    public function getAllByParentIdOrdered($id);

    public function getLevelWithChildren($parent_id);
}
