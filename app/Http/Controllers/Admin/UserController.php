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
		$users = User::orderBy('id','DESC')->get();

		return view('admin.user.index', compact('users'));
	}

	public function edit($id)
	{
		$user = User::findOrFail($id);
		
		return view('admin.user.edit', compact('user'));
	}

	public function updateUser(Request $request)
	{
		$this->validate($request, [
            'id' => 'required|integer',
			// 'email' => 'required|email|unique:users,email,'.$user->id,
            'fname' => 'required|string|alpha_num',
			// 'lname' => 'required|string|alpha_num',
            'mobile_number' => ['required','numeric'],
            'country' => 'required|string',
            'city' => 'required|string',
            'village' => 'required|string',
            'mobile_network' => 'required|string',
        ]);

		$user = User::where('id', $request->id)->first();
		$name = $request->fname ;// .' '. $request->lname;
		$user->name = $name;
        // $user->email = $request->email;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->village = $request->village;
        $user->mobile_number = $request->mobile_number;
        $user->mobile_network = $request->mobile_network;
		// echo '<pre>';print_r($user);exit;
        $user->update();

		return redirect()->to('/admin/users')->withSuccess('Successfully Updated!');
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