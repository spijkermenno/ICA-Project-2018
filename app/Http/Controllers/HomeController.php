<?php

namespace App\Http\Controllers;

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
    public function __construct(DatabaseItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view();
//        return view('home', [
//            'categories' => $this->categoryRepository->getAllParents()
//        ]);
    }
}
