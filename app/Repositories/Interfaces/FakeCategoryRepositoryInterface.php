<?php
/**
 * Author: Ivo Breukers
 * Date: 21-Nov-18
 * Time: 14:05
 */

namespace App\Repositories\Interfaces;


interface FakeCategoryRepositoryInterface
{
    public function getCategoryById(int $id);

    public function getAllCategories();
}