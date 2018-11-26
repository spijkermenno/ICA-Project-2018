<?php

namespace App\Http\Controllers;

class RubriekenController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rubrieken.rubrieken', ['test' => true]);
    }
}
