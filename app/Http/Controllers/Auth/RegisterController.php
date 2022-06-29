<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'personal_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'work_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'personal_phone' => ['required', 'string', 'max:16', 'unique:users'],
            'work_phone' => ['required', 'string', 'max:16', 'unique:users'],
            'position_id' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new users instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data[''],
            'last_name' => $data[''],
            'username' => $data['username'],
            'personal_email' => $data[''],
            'work_email' => $data[''],
            'personal_phone' => $data[''],
            'work_phone' => $data[''],
            'position_id' => $data[''],
            'department_id' => $data[''],
            'password' => Hash::make($data['password']),
        ]);
    }
}
