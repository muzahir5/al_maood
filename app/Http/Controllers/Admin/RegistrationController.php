<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Admin;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('pages.create');
    }

        public function store()
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required'
        ]);
        
        $user = Admin::create(request(['name', 'email', 'password']));
        
//        auth()->login($user);
        
        return redirect()->to('/admin/login');
    }
} 
 
 
 
