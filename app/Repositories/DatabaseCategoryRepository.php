<?php

namespace App\Repositories;

use App\Repositories\Contracts\CategoryRepository;

class DatabaseCategoryRepository extends DatabaseRepository implements CategoryRepository
{
    public function getAll()
    {
        return $this->conn->select('
            SELECT id, name, parent, order_number, inactive 
            FROM categories 
            ORDER BY name ASC');
    }

    public function getAllByParentId($id)
    {
        return $this->conn->select('
            SELECT id, name, parent, order_number, inactive 
            FROM categories 
            WHERE parent = ?  
            ORDER BY order_number ASC, name ASC',
            [$id]
        );
    }

    public function getChildrenFor(array $ids)
    {
        return $this->conn->select('
            SELECT id, name, parent, order_number, inactive
            FROM categories
            WHERE parent IN (
                ' . str_replace_last(',', '', str_repeat('?,', count($ids))) .
            ')
            ORDER BY order_number ASC, name ASC
        ', $ids);
    }

    public function getById($id)
    {
        return $this->conn->select('
            SELECT id, name, parent, order_number, inactive
            FROM categories
            WHERE id = ?',
            [$id]
        );
    }

    public function getAllParents($id)
    {
        return $this->conn->select('
            WITH tblParent AS
            (
                SELECT *
                    FROM categories WHERE id = ?
                UNION ALL
                SELECT categories.*
                    FROM categories  JOIN tblParent  ON categories.id = tblParent.parent
            )
            SELECT * FROM  tblParent
                WHERE id <> ? AND id > 0
            ORDER BY id ASC
            OPTION(MAXRECURSION 64)',
            [$id, $id]
        );
    }

    public function getLevelWithChildren($parent_id)
    {
        $parents = $this->getAllByParentId($parent_id);
        if (count($parents)) {
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
        return [];
    }
}
