<?php

namespace App\Http\Controllers;

use App\Repositories\DatabaseCategoryRepository;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home',[
            'rubrieken' => [
                "Auto's",
                "Baby's",
                "Computers"
            ]
        ]);
//        return view('home', [
//            'categories' => $this->categoryRepository->getAllParents()
//        ]);
    }
}
