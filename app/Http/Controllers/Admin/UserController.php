<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User\User;

class UserController extends Controller
{
	public function __construct(){
    	$this->middleware('auth:admin');
    }

	public function index($value='')
	{
		$users = User::get();

		return view('admin.user.index', compact('users'));
	}

	public function edit($id)
	{
		echo "user is is $id";
	}

	public function updateUserStatus($id,$status)
	{
		// echo "id is $id , status is $status";

		$user = User::find($id);
		$user->status = $status;
		$user->save();

		return redirect()->to('/admin/users');
	}
}
