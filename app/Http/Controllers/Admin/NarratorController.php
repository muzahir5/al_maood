<?php

namespace App\Http\Controllers\Admin;

use File;
use Auth;
use Image;
use Carbon\Carbon;
use App\Model\Admin\Audio;
use Illuminate\Http\Request;
use App\Model\Admin\Language;
use App\Model\Admin\Narrator;
use App\Model\Admin\Categories;
use App\Http\Controllers\Controller;

class NarratorController extends Controller
{
    public function __construct(){
    	$this->middleware('auth:admin');
    }

    public function index()
    {
        $narrators = Narrator::all();

        return view('admin.narrator.index', compact('narrators'));
    }

    public function create()
    {
        return view('admin.narrator.create');
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required | string | max:255',
            'email' => 'required | string | max:255',
            'profile_pic' =>'nullable | mimes:jpeg,jpg,png,gif',
        ]);
         
        $narrator = new Narrator();

        $narrator->name = $request->name;
        $narrator->email = $request->email;
        $narrator->password = $request->name;
        $narrator->mobile_number = $request->mobile_number;

        if($request->hasFile('profile_pic')){
            $originalImage= $request->file('profile_pic');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/narrators/';
            $categ_showto = '_'.date('d_m_Y_h_i_s').'.'.$originalImage->getClientOriginalExtension();
            $thumbnailImage->save($originalPath.$request->name.$categ_showto);

            $narrator->profile_pic = $request->name.$categ_showto;
        }
        

        $narrator->save();

        return redirect()->to('/admin/narrators');
    }
}
