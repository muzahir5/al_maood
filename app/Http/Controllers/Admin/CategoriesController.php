<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Categories;
use Illuminate\Support\Facades\DB;
use Image;
use File;

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
            'category_img' =>'required | mimes:jpeg,jpg,png,gif',
        ]);

        $categories = new Categories();

        $categories->name = $request->name;
        $categories->status = $request->status;
        $categories->category_type = 'test';

        $originalImage= $request->file('category_img');
        $thumbnailImage = Image::make($originalImage);            
        $originalPath = public_path().'/categories/';
        $categ_showto = '_'.date('d_m_Y_h_i_s').'.'.$originalImage->getClientOriginalExtension();
        $thumbnailImage->save($originalPath.$request->name.$categ_showto);

        $categories->category_img = $request->name.$categ_showto;

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

        $category_image = '';
        $category_img = DB::table('categories')->where('id',$request->id)->first();
        $category_imagee = $category_img->category_img;

        if($request->hasFile('category_img'))
        {            
            $category_img = '/categories/'.$category_img->category_img;
            @unlink(public_path().'/'.$category_img);

            $originalImage= $request->file('category_img');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/categories/';            
            $categ_showto = '_'.date('d_m_Y_h_i_s').'.'.$originalImage->getClientOriginalExtension();
            $thumbnailImage->save($originalPath.$request->name.$categ_showto);

            $category_image = $request->name.$categ_showto;            
        }    

        $category = DB::table('categories')->where('id',$request->id)->
        			update([
        				'name' => $request->name,
                        'category_img' => $category_image ? $category_image : $category_imagee,
        				'status' => $request->status,
        				'updated_at' => date('y-m-d h-i-s') ]
        			);
        return redirect()->to('/admin/categories');
    }

    public function delete($id)
    {
        $category = DB::table('categories')->where('id',$id)->first();

        if($category){
            // deleting image
            $category_img = '/categories/'.$category->category_img;
            @unlink(public_path().'/'.$category_img);

            DB::table('categories')->where('id', $id)->delete();

            return response()->json( [ 
            'status' => 'success',
            'message' => 'category deleted successfully' ]);        // return redirect()->to('/admin/categories');            
        }else{
            return response()->json( [ 
            'status' => 'fail',
            'message' => 'No record found against id']);;
        }
    }
}