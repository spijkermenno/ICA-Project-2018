<?php

namespace App\Http\Controllers\User\Seller\Verification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DatabaseSellerRepository;
use App\Repositories\Contracts\SellerRepository;
use App\Repositories\DatabaseCategoryRepository;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\SellerVerificationMethodRepository;

class CreditCardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    protected $passwordResetRepository;

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

        $this->middleware(['not.seller']);
    }

    public function showVerificationForm()
    {
        return view('user.seller.verify.credit-card');
    }

    public function sendVerification(Request $request)
    {
        $this->validate($request, [
            'creditcard' => 'required|string|creditcard',
        ]);


        return redirect()->route('seller.verification.creditcard');
    }
}
