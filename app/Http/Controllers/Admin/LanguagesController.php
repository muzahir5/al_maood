<?php

namespace App\Http\Controllers\Admin;

use File;
use Auth;
use Image;
use Carbon\Carbon;
use App\Model\Admin\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LanguagesController extends Controller
{
    public function __construct(){
    	$this->middleware('auth:admin');
    }

    public function index()
    {
    	$languages = DB::table('languages')->get();
    	// echo '<pre>';print_r($languages);exit;
    	return view('admin.languages.index', compact('languages'));
    }

    public function create(){
    	return view('admin.languages.add');
    }

    public function save(Request $request){
        $this->validate($request, [
            'name'          => 'required | string | max:255',
        ]);

        $language = new language();

        $language->name     = $request->name;
        $language->status   = $request->status;

        $language->save();

        return redirect()->to('/admin/languages');
    }

    public function edit($id){
        $language = language::find($id);
        // echo $language->name;
        return view('admin.languages.edit')->with('language',$language);
    }

    public function update(Request $request){
        $this->validate($request, [
            'name' => 'required | string | max:255',
        ]);

        $category = DB::table('languages')->where('id',$request->id)->
                    update([
                        'name'          => $request->name,
                        'status'        => $request->status,
                        'updated_at'    => date('y-m-d h-i-s') ]
                    );
        return redirect()->to('/admin/languages');
    }
}
