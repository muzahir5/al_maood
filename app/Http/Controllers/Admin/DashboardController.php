<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;

class DashboardController extends Controller
{
	public function __construct() {
        $this->middleware('auth:admin');
    }

	Public function index(){  

		$client_id = Auth::user()->id; 

		return view('admin.dashboard');
    }
}
