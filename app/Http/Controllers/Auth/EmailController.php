<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\EmailVerification;
use App\Repositories\DatabaseCategoryRepository;
use App\Repositories\Contracts\PasswordResetRepository;

class EmailController extends Controller
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
        DatabaseCategoryRepository $categoryRepository,
        PasswordResetRepository $passwordResetRepository
    ) {
        parent::__construct($categoryRepository);

        $this->passwordResetRepository = $passwordResetRepository;

        $this->middleware(['guest', 'not.verified']);
    }

    public function showEmailForm()
    {
        return view('auth.email');
    }

    public function sendVerificationEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users'
        ]);

        (new User([
            'email' => $request->get('email')
        ]))->notify(
            new EmailVerification(
                $this->passwordResetRepository->createTokenForUserEmail($request->get('email'))
            )
        );

        return redirect()
            ->route('email.verify')
            ->with('email', $request->get('email'))
            ->with('status', 'Er is een verificatie code naar uw E-mailadres verstuurd');
    }

    public function showVerifyForm($token = null)
    {
        return view('auth.verify-email', [
            'token' => $token
        ]);
    }

    public function verifyEmail(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users',
            'token' => 'required'
        ]);

        $reset = $this->passwordResetRepository->getByUserEmail($request->get('email'));

        if (!$reset || $reset->expired) {
            return redirect()
                ->route('email.verification')
                ->with('status', 'Uw verificatie code is niet meer geldig.');
        }

        if (!$this->passwordResetRepository->validateCredentials(
            $reset,
            $request->only('token')
        )) {
            return back()
                ->with('email', $request->get('email'))
                ->with('status', 'Uw verificatie code is niet correct.');
        }

        $this->passwordResetRepository->removeByUserEmail($request->get('email'));

        $request->session()->put('email.verification', [
            'verified' => true,
            'email' => $request->get('email'),
            'expires_at' => Carbon::now()->addHours(4)
        ]);

        $request->session()->save();

        return redirect()
            ->route('register')
            ->with('email', $request->get('email'));
    }
}
