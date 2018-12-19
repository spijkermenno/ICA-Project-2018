<?php

namespace App\Http\Controllers\User\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller {

    public function showRegisterForm()
    {
        return view('user.seller.register');
    }

    public function create(Request $request) {


        return ;
    }
}
