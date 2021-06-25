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

    Public function index(){  

        // $products = Product::all();
        // echo Auth::guard('user')->id();exit;

        $products = DB::table('products as prod')->select('prod.id','prod.name','prod.price','prod.sale_price','prod_imgs.image_url')
                        ->join('product_images as prod_imgs', 'prod.id','prod_imgs.product_id')->get();
         
//        echo '<pre>'; print_r($products); http://dev2.koboniq.com/adminer/?username=root&db=kobon
//        exit;

    	return view('dashboard.index', compact('products'));
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