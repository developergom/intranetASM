<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
	/**
    * Handle an authentication attempt
    *
    * @return Response
    */
    public function authenticate(Request $request)
    {
    	//var_dump($request->all());die;

    	$this->validate($request, [
    		'user_name' => 'required|min:6|max:100',
    		'user_password' => 'required'
    	]);

        if(Auth::attempt(['user_name' => $request->user_name, 'user_password' => bcrypt($request->user_password), 'active' => '1', 'user_status' => 'ACTIVE'])) {
            //Authentication passed..
            echo 'masuk';die;
            return redirect()->intended('dashboard');
        }else{
            echo 'gagal';die;
        	return redirect('login');
        }
    }

    public function login()
    {
    	return view('auth.login');
    }
}