<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:editor')->except('logout');
    }

    public function create()
    {
        return view('editor.auth.login');
    }
    
    public function login(Request $request)
    {
    	$this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);                                             // echo '<pre>';print_r($request->email);exit;
        if (Auth::guard('editor')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {            
            return redirect()->to('/editor/dashboard');
        }
        
        return back()->withInput($request->only('email', 'remember'));
    }
    
    public function logout()
    {
        Auth::guard('editor')->logout();
        
        return redirect()->to('/editor');
    }
}
