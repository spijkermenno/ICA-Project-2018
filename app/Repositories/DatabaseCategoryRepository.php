<?php

namespace App\Repositories;

use App\Repositories\Contracts\CategoryRepositoryInterface;

class DatabaseCategoryRepository extends DatabaseRepository implements CategoryRepositoryInterface
{
    public function getAll()
    {
        return $this->conn->select('SELECT id, name, parent FROM categories');
    }

    public function getAllParents()
    {
        return $this->conn->select('SELECT id, name, parent FROM categories WHERE parent = -1 AND id >= 0');
    }

    public function getAllByParentId(int $id)
    {
        return $this->conn->select(
          'SELECT id, name, parent FROM categories WHERE parent = ?',
          [$id]
      );
    }

    public function getById(int $id)
    {
        return $this->conn->select(
          'SELECT id, name, parent FROM categories WHERE id = ?',
          [$id]
      );
    }
}
