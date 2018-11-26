<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;

class HomeController extends Controller
{
  /**
   * @var CategoryRepository
   */
  private $categoryRepository;

    /**
     * Create a new controller instance.
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;

//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd($this->categoryRepository->getById(1));
        return view('home');
    }
}
