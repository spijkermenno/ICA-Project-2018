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

    public function getById(int $id)
    {
        return $this->conn->select(
          'SELECT id, name, parent FROM categories WHERE id = ?',
          [$id]
      );
    }
}
