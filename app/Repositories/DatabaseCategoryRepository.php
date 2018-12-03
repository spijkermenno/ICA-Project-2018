<?php

namespace App\Repositories;

use App\Repositories\Contracts\CategoryRepository;

class DatabaseCategoryRepository extends DatabaseRepository implements CategoryRepository
{
    public function getAll()
    {
        return $this->conn->select('SELECT id, name, parent FROM categories ORDER BY name ASC');
    }

    public function getAllParents()
    {
        return $this->conn->select('SELECT id, name, parent FROM categories WHERE parent = -1 ORDER BY name ASC');
    }

    public function getAllChildren()
    {
        return $this->conn->select('SELECT id, name, parent FROM categories WHERE NOT parent = -1 ORDER BY name ASC');
    }

    public function getAllByParentId(int $id)
    {
        return $this->conn->select(
            'SELECT id, name, parent FROM categories WHERE parent = ?',
            [$id]
        );
    }

    public function getChildrenFor(array $ids)
    {
        return $this->conn->select('
            SELECT
                id, name, parent
            FROM categories
            WHERE parent IN (
                ' . str_replace_last(',', '', str_repeat('?,', count($ids))) .
            ')
        ', $ids);
    }

    public function getById(int $id)
    {
        return $this->conn->select(
            'SELECT id, name, parent FROM categories WHERE id = ?',
            [$id]
        );
    }

    public function getLevelWithChildren($parent_id)
    {
        $parents = $this->getAllByParentId($parent_id);

        return collect($parents)
            ->pipe(function ($parents) {
                $children = collect($this->getChildrenFor($parents->pluck('id')->toArray()))
                    ->groupBy('parent');

                return $parents->map(function ($parent) use ($children) {
                    $parent->children = $children[$parent->id] ?? [];

                    return $parent;
                });
            })
            ->toArray();
    }
}
