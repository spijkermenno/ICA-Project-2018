<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class DatabaseCategoryRepository extends DatabaseRepository implements CategoryRepositoryInterface
{
    public function getAll()
    {
        return DB::select('SELECT * FROM categories');
    }

    public function getAllByParentId(int $id)
    {
        return DB::select(
          'SELECT * FROM categories WHERE parent_id = ?',
          [$id]
      );
    }

    public function getById(int $id)
    {
        return DB::select(
          'SELECT * FROM categories WHERE id = ?',
          [$id]
      );
    }
}
