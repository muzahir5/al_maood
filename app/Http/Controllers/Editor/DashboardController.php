<?php

namespace App\Http\Controllers\Editor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth:editor');
    }

	Public function index(){
		return view('editor.index');
    }
}