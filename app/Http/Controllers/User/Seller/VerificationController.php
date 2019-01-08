<?php

namespace App\Http\Controllers\User\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\SellerRepository;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\PostalValidationsRepository;
use App\Repositories\Contracts\SellerVerificationMethodRepository;

class VerificationController extends Controller
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

        $this->sellerRepository = $sellerRepository;
        $this->postalValidationsRepository = $postalValidationsRepository;
        $this->sellerValidationMethodRepository = $sellerValidationMethodRepository;
    }

    public function showVerificationForm()
    {
        return view('user.seller.verify', [
            'verification_methods' => array_map(
                'ucfirst',
                array_pluck(
                    $this->sellerValidationMethodRepository->getAll(),
                    'name'
                )
            )
        ]);
    }

    public function sendVerification(Request $request)
    {
        $this->validate($request, [
            'verification_method' => 'required'
        ]);

        if ($request->get('verification_method') == 'creditcard') {
            return redirect()->route('seller.verify.creditcard');
        }

        if ($request->get('verification_method') == 'mail') {
            if (!$this->postalValidationsRepository->getByUser(auth()->user())) {
                $this->postalValidationsRepository->createTokenForUser(auth()->user());
            }

            return redirect()->route('seller.verify.mail');
        }

        return back()->withErrors([
            'verification_method' => [
                'De opgegeven methode word niet ondersteund'
            ]
        ]);
    }
}
