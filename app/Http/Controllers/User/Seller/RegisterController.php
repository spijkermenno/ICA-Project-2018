<?php

namespace App\Http\Controllers\User\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\SellerRepository;
use App\Repositories\Contracts\CategoryRepository;

class RegisterController extends Controller
{
    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct(
        SellerRepository $sellerRepository,
        CategoryRepository $categoryRepository
    ) {
        parent::__construct($categoryRepository);

        $this->sellerRepository = $sellerRepository;

        $this->middleware(function ($request, $next) {
            if (session('seller.verification.verified')) {
                return $next($request);
            }
            return redirect()->route('seller.verify');
        });
    }

    public function showRegisterForm()
    {
        return view('user.seller.register');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'bank' => 'required|string',
            'account_number' => [
                'required',
                'string',
                'iban'
            ]
        ]);

        $seller = $this->sellerRepository->create(
            collect(
                session('seller.verification.' . session('seller.verification.method'), [])
            )
                ->pipe(function ($collection) {
                    if ($collection->has('number')) {
                        return collect([
                            'creditcard' => str_replace(' ', '', $collection->get('number'))
                        ]);
                    }
                    return collect([]);
                })
                ->merge([
                    $this->sellerRepository->getIdentifierName() => auth()->user()->getAuthIdentifier(),
                    'bank' => $request->input('bank'),
                    'iban' => $request->input('account_number'),
                    'verification_method' => session('seller.verification.method')
                ])
                ->toArray()
        );

        return $seller;
    }
}
