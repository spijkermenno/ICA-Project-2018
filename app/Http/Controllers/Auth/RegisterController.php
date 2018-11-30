<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
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
    protected $redirectTo = '/home';

    protected $secretQuestionRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SecretQuestionRepository $secretQuestionRepository)
    {
        $this->middleware('guest');

        $this->secretQuestionRepository = $secretQuestionRepository;
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

            'reset_question_id' => 'required|integer',
            'reset_question_answer' => 'required|min:6',

            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',

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
        dd($data);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
