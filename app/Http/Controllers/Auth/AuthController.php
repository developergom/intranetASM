<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $username = 'user_name';
    protected $loginView = 'vendor.material.auth.login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
            'user_name' => 'required|max:255',
            'user_email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'user_firstname' => 'required|min:1|max:100',
            'user_lastname' => 'max:100',
            'user_phone' => 'max:15|unique:users',
            'user_gender' => 'required',
            'religion_id' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'user_name' => $data['user_name'],
            'user_email' => $data['user_email'],
            'password' => bcrypt($data['password']),
            'user_firstname' => $data['user_firstname'],
            'user_lastname' => $data['user_lastname'],
            'user_phone' => $data['user_phone'],
            'user_gender' => $data['user_gender'],
            'religion_id' => $data['religion_id'],
            'user_birthdate' => Carbon::parse($data['user_birthdate']),
            'user_avatar' => 'avatar.jpg',
            'user_status' => 'ACTIVE',
            'active' => '1',
            'created_by' => Auth::user()->user_id,
        ]);
    }

    /*public function login(Request $request) {
        //dd($request->all());

        $user_name = $request->input('user_name');
        $password = $request->input('password');
        if (Auth::attempt(['user_name' => $user_name, 'password' => $password])) {
            // Authentication passed...
            //dd($request->all());
            //dd(Auth::guard('web')->guest());
            //dd(Auth::guard('web'));

            return redirect()->intended('home');
        }
    }*/

    public function authenticate()
    {
        dd('masuk');
    }
}
