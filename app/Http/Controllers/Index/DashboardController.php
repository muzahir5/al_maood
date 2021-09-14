<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Illuminate\Support\Facades\DB;
use Redirect;

class DashboardController extends Controller
{
    public function __construct() {
        // $this->middleware('auth:user');
    }

    Public function index()
    {
        $categories = DB::table('categories')->where('status',1)->get();
    	// echo '<pre>';print_r($categories);exit;
        return view('user.index', compact('categories'));
    }
    
    public function productDetail($id){
        $product = DB::table('products')->where('id',$id)->first();
        if(!$product){
             return Redirect::back();
      }
        $product = DB::table('products as prod')->select('prod.id','prod.name','prod.weight','prod.quantity','prod.price','prod.sale_price','prod_imgs.image_url','prod_med_fil_mp3.media_file_url')
                        ->join('product_images as prod_imgs', 'prod.id','prod_imgs.product_id')
                        ->join('product_media_files as prod_med_fil_mp3', 'prod.id','prod_med_fil_mp3.post_id')
                        ->where('prod.id',$id)->get();
        
       // echo '<pre>'; print_r($product);exit;
        
        return view('dashboard.productDetail', compact('product'));
        
    }
}