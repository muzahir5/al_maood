<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Categories;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use Redirect;
use App\Model\Admin\Audio;

class DashboardController extends Controller
{
    public function __construct(){
    	// $this->middleware('auth:user');
    }

    public function index()
    {
        $categories = DB::table('categories')->where('status',1)->get();
    	// echo '<pre>';print_r($categories);exit;
        return view('user.index', compact('categories'));
    }

    public function listAudioByCatagory($cat_id)
    {
        $category = Categories::where('id',$cat_id)->first();
        $audios = Audio::select('id','title','description','narrator','upload_by','category','audio_url','audio_img','view_by','show_to')
                    ->where('status',1)->Where('category', $cat_id)->get();        

        // echo '<pre>';print_r($category);exit;
        $cat_id = $cat_id;
        return view('user.audio.renderAudio', compact('audios','category','cat_id'));
    }

    public function listAudioByCatagoryId($cate_id)
    {
        $category = Categories::where('id',$cate_id)->first();
        $audios = Audio::select('id','title','description','narrator','upload_by','category','audio_url','audio_img','view_by','show_to')
                    ->where('status',1)->Where('category', $cate_id)->get();        

        // echo '<pre>';print_r($category);exit;
        $cat_id = $cate_id;

        return response()->json([            
            'status' => "success",
            'base_path' => base_path().'/',
            'audios' => $audios
        ]);
    }

    //can apply on General search  || search in category
	public function listAudio($searching_word, $cat_id = '')
	{		
        $searchInAll = $searching_word ? $searching_word : '';
        $cat_id = $cat_id ? $cat_id : '';

        $categories = Categories::all();
        $query = Audio::where('status',1);
        if($searchInAll != ''){
            //general search
            $query->where(function ($query) use ($searchInAll) {
                        $query->orWhere('title', 'like', "%{$searchInAll}%");
                        $query->orWhere('category', 'like', "%{$searchInAll}%");
                        $query->orWhere('poet', 'like', "%{$searchInAll}%");
                        $query->orWhere('narrator', 'like', "%{$searchInAll}%"); //singer
                        
                });
        }
        if($cat_id != ''){
            //search in Category
            $query->where(function ($query) use ($cat_id) {
                        $query->orWhere('category', 'like', "%{$cat_id}%");
                        
                });
        }
        $audios = $query->get();

        return response()->json([            
            'status' => "success",
            'base_path' => base_path().'/',
            'audios' => $audios
        ]);
    }

}
