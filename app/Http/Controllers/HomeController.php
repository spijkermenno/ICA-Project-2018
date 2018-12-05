<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseCategoryRepository;
use App\Repositories\DatabaseItemRepository;

class HomeController extends Controller
{
    /**
    * @var DatabaseItemRepository
    */
    private $itemRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     * @param DatabaseItemRepository $itemRepository
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
            'popularProducts' => $this->itemRepository->getMostPopularItems(3)
        ]);
    }
}
