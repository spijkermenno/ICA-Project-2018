<?php

namespace App\Http\Controllers\User\Seller\Verification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\SellerRepository;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\PostalValidationsRepository;
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
        PostalValidationsRepository $postalValidationsRepository,
        CategoryRepository $categoryRepository
    ) {
        parent::__construct($categoryRepository);

        $this->postalValidationsRepository = $postalValidationsRepository;
        $this->sellerRepository = $sellerRepository;
        $this->sellerValidationMethodRepository = $sellerValidationMethodRepository;
    }

    public function showVerificationForm()
    {
        return view('user.seller.verify.mail', [
            'validation' => $this->postalValidationsRepository->getByUser(auth()->user())
        ]);
    }

    public function sendVerification(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string'
        ]);

        if (!$this->postalValidationsRepository->validateCredentials(
            $this->postalValidationsRepository->getByUser(auth()->user()),
            $request->only('token')
        )) {
            return redirect()->back()->withErrors([
                'token' => [
                    'De opgegeven code is niet just'
                ]
            ]);
        }

        $request->session()->put('seller.verification', [
            'method' => 'mail',
            'verified' => true
        ]);

        $request->session()->save();

        $this->postalValidationsRepository->removeByUser(auth()->user());

        return redirect()->route('seller.register');
    }
}
