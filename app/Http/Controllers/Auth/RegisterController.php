<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Contracts\UserRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repositories\Contracts\CategoryRepository;
use App\Repositories\Contracts\SecretQuestionRepository;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $secretQuestionRepository;
    protected $userRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        SecretQuestionRepository $secretQuestionRepository,
        UserRepository $userRepository,
        CategoryRepository $categoryRepository
    ) {
        parent::__construct($categoryRepository);

        $this->middleware(['guest', 'verified']);

        $this->secretQuestionRepository = $secretQuestionRepository;
        $this->userRepository = $userRepository;
    }

    public function showRegistrationForm()
    {
        return view('auth.register', [
            'questions' => $this->secretQuestionRepository->getAll([
                'id', 'question'
            ])
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:20|unique:users',
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',

            'secret_question_id' => 'required|integer',
            'secret_question_answer' => 'required|min:6',

            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:7|max:72|confirmed',

            'birthday' => 'required|before:now',

            'adress_line_1' => 'required|string|max:120',
            'adress_line_2' => 'max:120',

            'postalcode' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:40'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = $this->userRepository->create(
            array_except(
                $data,
                ['_token', 'password_confirmation']
            )
        );

        return $user;
    }

    /**
     * Get the broker to be used during user creation
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
}
