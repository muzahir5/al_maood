<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product\Product;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\Model\Product\Product_Images;
use Illuminate\Support\Facades\DB;
use Image;
use App\Model\Admin\Categories;
use App\Model\Product\ProductCategories;
use App\Model\Product\ProductAvailable;
use File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use App\Model\Admin\ProductMediaFiles;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function __construct(){
    	$this->middleware('auth:admin');
    }

    public function index(){

    	// $products = Product::all();
        
        $categories = Categories::all();
        $products = DB::table('products as prod')->select('prod.id','prod.name','prod.price','prod.sale_price','prod_imgs.image_url','prod_categ.category_id')
                        ->join('product_images as prod_imgs', 'prod.id','prod_imgs.product_id')
                        ->join('product_categories as prod_categ', 'prod.id','prod_categ.product_id')->get();
//         echo '<pre>'; print_r($products);
//         exit;

    	return view('admin.product.index', compact('products','categories'));
    }

    public function create(){
        $categories = Categories::all();
        
    	return view('admin.product.add',compact('categories'));
    }

    public function save(Request $request){

        // print_r($request->available);exit;
            	// 
    	$this->validate($request, [
            'name' => 'required | string | max:255',
            'sku' => 'required | string | max:255',
            'price' => 'required | Integer | max:1000',
            'sale_price' => 'required | Integer | max:1000',
            'product_image' => 'required|mimes:jpg,jpeg,png',
            'category' => 'required',
            'available' => 'required',
            'product_type' => 'required',
            'mp3_file' =>'nullable|mimes:audio/mpeg,mpga,mp3,wav,aac'
        ]);
        
        $admin_id = Auth::user()->id;
        
        $product_type = $request->product_type;
        if($product_type == 1){
            $product_type = 'post';
        }elseif($product_type == 2){
            $product_type = 'link';
        }elseif ($product_type == 3){
            $product_type = 'mp3';
        }

        $product = new Product();
        $product->name = $request->name ;
        $product->sku = $request->sku ;
        $product->price = $request->price ;
        $product->slug = $request->slug ;
        $product->description = $request->description ;
        $product->quantity = $request->quantity ;
        $product->sale_price = $request->sale_price ;
        $product->status = $request->status ;
        $product->featured = $request->isfeature ;
        $product->post_type = $product_type;
        $product->created_by = 'admin' ;
        $product->created_by_id = $admin_id;
        $product->save();

        $category = $request->category;

        foreach ($category as $cateId) {
            // echo $cateId;exit;
            $category = new ProductCategories();
            $category->category_id = $cateId;
            $category->product_id = $product->id;
            $category->save();
        }

        $available = $request->available;

        foreach ($available as $available) {
            // echo $cateId;exit;
            $category = new ProductAvailable();
            $category->available_at = $available;
            $category->product_id = $product->id;
            $category->save();
        }

        
        if($request->hasFile('product_image')){

            $originalImage= $request->file('product_image');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path().'/uploads/products/thumbnail/';
            $originalPath = public_path().'/uploads/products/images/';
            $thumbnailImage->save($originalPath.time().$originalImage->getClientOriginalName());
            $thumbnailImage->resize(150,150);
            $thumbnailImage->save($thumbnailPath.time().$originalImage->getClientOriginalName()); 

            $product_image = new Product_Images();
            $product_image->product_id = $product->id;
            $product_image->image_url = time().$originalImage->getClientOriginalName();
            $product_image->image_compress_type = 1;
            $product_image->save();

        }
        
        if($request->hasFile('mp3_file')){          
           $music_file = $request->file('mp3_file');
           $uniqueid= uniqid();
           $filename = Carbon::now()->format('Ymd').'_'.$request->name.'_'.$music_file->getClientOriginalExtension();
           $location = public_path('audio/mp3/');
           $music_file->move($location,$filename);            

           $ProductMediaFiles = new ProductMediaFiles();
           $ProductMediaFiles->post_id = $product->id;
           $ProductMediaFiles->metia_type ='mp3';
           $ProductMediaFiles->media_file_url = 'public/audio/mp3/'.$filename;
           $ProductMediaFiles->file_name = $filename;
           $ProductMediaFiles->save();
        }

        return redirect()->to('/admin/product');
    }

    public function edit($id)
    {
        $product = DB::table('products as prod')->where('prod.id',$id)->get();
        $product_categories = DB::table('product_categories')->select('category_id')->where('product_id',$id)->get();
        $product_availables = DB::table('product_availables')->where('product_id',$id)->get();
        $product_images = DB::table('product_images')->where('product_id',$id)->get();
        $categories = Categories::all();

        // echo '<pre>';print_r($product);
        // exit;

        return view('admin.product.edit',compact('product','product_categories','product_availables','product_images','categories'));
    }

    public function update(Request $request){
        
        $this->validate($request, [
            'name' => 'required | string | max:255',
            'sku' => 'required | string | max:255',
            'price' => 'required | Numeric | max:1000',
            'sale_price' => 'required | Numeric | max:1000',
//            'product_image' => 'required|mimes:jpg,jpeg,png',
            'category' => 'required',
            'available' => 'required'
        ]);
              
        $product = Product::find($request->id);
        
        $product_type = $request->product_type;
        if($product_type == 1){
            $product_type = 'post';
        }elseif($product_type == 2){
            $product_type = 'link';
        }elseif ($product_type == 3){
            $product_type = 'mp3';
        }

        $product->name = $request->name ;
        $product->sku = $request->sku ;
        $product->price = $request->price ;
        $product->slug = $request->slug ;
        $product->description = $request->description ;
        $product->quantity = $request->quantity ;
        $product->sale_price = $request->sale_price ;
        $product->status = $request->status ;
        $product->featured = $request->isfeature ;
        $product->post_type = $product_type;
        // $product->created_by = 'admin' ;
        // $product->created_by_id = $admin_id;
        $product->save();

        if($request->hasFile('product_image')){

            $product_img_name = DB::table('product_images')->select('image_url')->where('product_id',$request->id)->get();
            // echo $product_img_name;exit;
            // @unlink(public_path().'/uploads/products/thumbnail/'.$product_img_name);
            File::delete(public_path('/uploads/products/thumbnail/'.$product_img_name));

            $delete_img_record = DB::table('product_images')->where('product_id',$request->id)->delete();

            $originalImage= $request->file('product_image');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path().'/uploads/products/thumbnail/';
            $originalPath = public_path().'/uploads/products/images/';
            $thumbnailImage->save($originalPath.time().$originalImage->getClientOriginalName());
            $thumbnailImage->resize(150,150);
            $thumbnailImage->save($thumbnailPath.time().$originalImage->getClientOriginalName()); 

            $product_image = new Product_Images();
            $product_image->product_id = $product->id;
            $product_image->image_url = time().$originalImage->getClientOriginalName();
            $product_image->image_compress_type = '/uploads/products/thumbnail/';
            $product_image->save();
        }
        
        if($request->hasFile('mp3_file')){   
           $productMediaFiles = DB::table('product_media_files')->where('post_id',$request->id)->first();
           if($productMediaFiles){
               File::delete(public_path('/audio/mp3/'.$productMediaFiles->file_name));
           }
           
           $productMediaFiles = DB::table('product_media_files')->where('post_id',$request->id)->delete();
        
           $music_file = $request->file('mp3_file');
           $uniqueid= uniqid();           
           $filename = Carbon::now()->format('Ymd').'_'.$request->name.'_'.$music_file->getClientOriginalExtension();
           $location = public_path('audio/mp3/');
           $music_file->move($location,$filename);            

           $ProductMediaFiles = new ProductMediaFiles();
           $ProductMediaFiles->post_id = $product->id;
           $ProductMediaFiles->metia_type ='mp3';
           $ProductMediaFiles->media_file_url = 'public/audio/mp3/'.$filename;
           $ProductMediaFiles->file_name = $filename;
           $ProductMediaFiles->save();
        }

        return redirect()->to('/admin/product');
    }
}