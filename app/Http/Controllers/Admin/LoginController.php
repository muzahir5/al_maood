<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function create()
    {
        return view('sessions.create');
    }
    
    public function login(Request $request)
    {
    	$this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            // If successfull, redirect to their intended location
            return redirect()->to('/admin/dashboard');
        }
        
        return back()->withInput($request->only('email', 'remember'));
        
    }
    
    public function logout()
    {
        
        Auth::guard('admin')->logout();
        
        return redirect()->to('/admin/login');
    }
}
