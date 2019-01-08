<?php

namespace App\Http\Controllers\User\Seller\Verification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\SellerRepository;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\SellerVerificationMethodRepository;

class MailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        SellerRepository $sellerRepository,
        SellerVerificationMethodRepository $sellerValidationMethodRepository,
        CategoryRepository $categoryRepository
    ) {
        parent::__construct($categoryRepository);

        $this->sellerRepository = $sellerRepository;
        $this->sellerValidationMethodRepository = $sellerValidationMethodRepository;
    }

    public function showVerificationForm()
    {
        return view('user.seller.verify.post');
    }

    public function sendVerification(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string'
        ]);

        $request->session()->put('seller.verification', [
            'method' => 'post',
            'verified' => true
        ]);

        $request->session()->save();

        return redirect()->route('seller.register');
    }
}
