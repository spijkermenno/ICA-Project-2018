<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Repositories\DatabaseItemRepository;
use App\Repositories\DatabaseCategoryRepository;

class HomeController extends Controller
{
    /**
     * @var DatabaseItemRepository
     */
    private $itemRepository;

    /**
     * Create a new controller instance.
     *
     * @param DatabaseItemRepository $itemRepository
     * @param DatabaseCategoryRepository $categoryRepository
     */
    public function __construct(DatabaseItemRepository $itemRepository, DatabaseCategoryRepository $categoryRepository)
    {
        parent::__construct($categoryRepository);
        $this->itemRepository = $itemRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', [
            'popular_products' => $this->itemRepository->getMostPopularItems(3),
            'fast_ending_products' => $this->itemRepository->getSoonEndingItems(12)
        ]);
    }
}
