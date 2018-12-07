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

    public function createCategory($id, $name, $parent, $order_number);

    public function disableCategoryById($id);

    public function updateCategoryNameById($id, $name);

    public function updateCategoryOrderNumberById($id, $current_order_number, $new_order_number);
}
