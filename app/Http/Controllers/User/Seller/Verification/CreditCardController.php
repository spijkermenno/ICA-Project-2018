<?php

namespace App\Http\Controllers\User\Seller\Verification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LVR\CreditCard\CardExpirationDate;
use App\Repositories\Contracts\SellerRepository;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\SellerVerificationMethodRepository;

class CreditCardController extends Controller
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

        $this->middleware(['not.seller']);

        $this->middleware(function ($request, $next) {
            if (
                !session('seller.verification.verified')
                    || session('seller.verification.verified') != 'creditcard'
            ) {
                return $next($request);
            }
            return redirect()->route('seller.register');
        });
    }

    public function showVerificationForm()
    {
        return view('user.seller.verify.credit-card');
    }

    public function sendVerification(Request $request)
    {
        $this->validate($request, [
            'number' => 'required|string|creditcard',
            'expiry' => ['required', new CardExpirationDate('m / Y')]
        ]);

        $request->session()->put('seller.verification', [
            'creditcard' => $request->only(['number', 'expiry']),
            'method' => 'creditcard',
            'verified' => true
        ]);

        $request->session()->save();

        return redirect()->route('seller.register');
    }
}
