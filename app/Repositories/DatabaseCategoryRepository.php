<?php

namespace App\Repositories;

use App\Repositories\Contracts\CategoryRepository;

class DatabaseCategoryRepository extends DatabaseRepository implements CategoryRepository
{
    public function getAll()
    {
        return $this->conn->select('SELECT * FROM categories');
    }

    public function getAllByParentId(int $id)
    {
        return $this->conn->select(
            'SELECT * FROM categories WHERE parent_id = ?',
            [$id]
        );
    }

    public function getById(int $id)
    {
        return $this->conn->select(
            'SELECT * FROM categories WHERE id = ?',
            [$id]
        );
    }
}
