<?php
/**
 * Author: Ivo Breukers
 * Date: 26-Nov-18
 * Time: 13:08
 */

namespace App\Repositories;


use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryInterface
{
  public function getAll()
  {
      return DB::select('SELECT * FROM categories');
  }

  public function getAllByParentId(int $id)
  {
      return DB::select(
          "SELECT * FROM categories WHERE parent_id = ?", [$id]
      );
  }

  public function getById(int $id)
  {
      return DB::select(
          "SELECT * FROM categories WHERE id = ?", [$id]
      );
  }
}
