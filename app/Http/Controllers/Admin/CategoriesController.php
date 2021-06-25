<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Categories;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
	public function __construct(){
    	$this->middleware('auth:admin');
    }

    public function index(){

    	$categories = DB::table('categories')->get();
    	// print_r($categories);
    	return view('admin.categories.index', compact('categories'));
    }

    public function create(){
    	return view('admin.categories.add');
    }

    public function save(Request $request){
    	
    	$this->validate($request, [
            'name' => 'required | string | max:255',
        ]);

        $categories = new Categories();

        $categories->name = $request->name;
        $categories->status = $request->status;
        $categories->category_type = 'test';

        $categories->save();

        return redirect()->to('/admin/categories');
    }

    public function edit($id){

    	$category = Categories::find($id);
    	// echo $category->name;

    	return view('admin.categories.edit')->with('category',$category);

    }

    public function update(Request $request){
    	$this->validate($request, [
            'name' => 'required | string | max:255',
        ]);

        $category = DB::table('categories')->where('id',$request->id)->
        			update([
        				'name' => $request->name,
        				'status' => $request->status,
        				'updated_at' => date('y-m-d h-i-s') ]
        			);
        return redirect()->to('/admin/categories');
    }
}