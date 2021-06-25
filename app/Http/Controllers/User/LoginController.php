<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:user')->except('logout');
    }

    public function create()
    {
        return view('user.auth.login');
    }
    
    public function login(Request $request)
    {
    	$this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
//echo 4;
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
//echo 5;exit;
            // If successfull, redirect to their intended location
            return redirect()->to('/user/dashboard');
        }
        
        return back()->withInput($request->only('email', 'remember'));
        
    }
    
    public function logout()
    {
        Auth::guard('user')->logout();
        
        return redirect()->to('/user');
    }
}