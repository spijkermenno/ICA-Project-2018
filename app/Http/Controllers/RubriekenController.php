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
            'parents' => $this->categoryRepository->getAllParents(),
            'children' => $this->categoryRepository->getAllChildren(),
        ]);
    }
}
