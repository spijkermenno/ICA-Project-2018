<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseCategoryRepository;

class RubriekenController extends Controller
{
    /**
     * @var DatabaseCategoryRepository
     */
    private $categoryRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     * @param DatabaseCategoryRepository $categoryRepository
     */
    public function __construct(DatabaseCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rubrieken.rubrieken', [
            'categories' => dd($this->getCategories())
        ]);
    }

    public function getCategories()
    {
        $categories = [];
        $remaining = [];
        $data = $this->categoryRepository->getAll();

        foreach ($data as $category)
        {
            if ($category->parent_id == -1 && $category->id >= 0)
            {
                $categories[$category->id] =
                [
                    'id' => $category->id,
                    'category_name' => $category->category_name,
                    'parent_id' => $category->parent_id
                ];
            }
            else
            {
                $remaining[] =
                [
                    'id' => $category->id,
                    'category_name' => $category->category_name,
                    'parent_id' => $category->parent_id
                ];
            }
        }

        return $categories;

    }
}
