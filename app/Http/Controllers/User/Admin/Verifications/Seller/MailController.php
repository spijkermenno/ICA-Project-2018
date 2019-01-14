<?php

namespace App\Http\Controllers\User\Admin\Verifications\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\SellerRepository;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\PostalValidationsRepository;

class MailController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        SellerRepository $sellerRepository,
        PostalValidationsRepository $postalValidationsRepository,
        CategoryRepository $categoryRepository,
        UserRepository $userRepository
    ) {
        parent::__construct($categoryRepository);

        $this->postalValidationsRepository = $postalValidationsRepository;
        $this->sellerRepository = $sellerRepository;
        $this->userRepository = $userRepository;
    }

    public function showVerificationLetter(Request $request)
    {
        $pagination = $this->postalValidationsRepository->getPaginated(1);

        if ($request->get('page') > $pagination->total()) {
            return redirect()->to($request->getPathInfo());
        }

        return view('user.admin.verification.seller.mail', [
            'verification' => $pagination->first(),
            'pagination' => $pagination,
            'user' => $pagination->first() ? $this->userRepository->retrieveById($pagination->first()->{$this->postalValidationsRepository->getIdentifierName()}) : null
        ]);
    }

    public function markLetterSent(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required|exists:users,name'
        ]);

        $this->postalValidationsRepository->markSentByUser(
            $this->userRepository->retrieveById($request->get('user_name'))
        );

        return back();
    }
}
