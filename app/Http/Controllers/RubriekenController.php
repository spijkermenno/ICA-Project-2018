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
            if ($category->parent == -1 && $category->id != NULL)
            {
                $categories[$category->id] =
                [
                    'id' => $category->id,
                    'name' => $category->name,
                    'parent' => $category->parent
                ];
            }
            else
            {
                $remaining[] =
                [
                    'id' => $category->id,
                    'name' => $category->name,
                    'parent' => $category->parent
                ];
            }
        }

        return $categories;

    }
}
