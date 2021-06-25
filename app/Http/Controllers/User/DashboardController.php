<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Categories;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use Redirect;

class DashboardController extends Controller
{
    public function __construct(){
    	$this->middleware('auth:user');
    }

    public function index()
    {
        $products = DB::table('products as prod')->select('prod.id','prod.name','prod.price','prod.sale_price','prod_imgs.image_url')
                        ->join('product_images as prod_imgs', 'prod.id','prod_imgs.product_id')->get();
         
//        echo '<pre>'; print_r($products);exit;

    	return view('user.index', compact('products'));        
    }
}
