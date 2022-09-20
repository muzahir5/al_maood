<?php

namespace App\Http\Controllers\Admin;

use File;
use Auth;
use Image;
use Carbon\Carbon;
use App\Model\Admin\Video;
use Illuminate\Http\Request;
use App\Model\Admin\Narrator;
use App\Model\Admin\Language;
use App\Model\Admin\Categories;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function __construct(){
        // phpinfo();exit;
        $this->middleware('auth:admin');
    }

    public function index($status = ''){
        
        $categories = Categories::all();

        if( $status != ''){
            $videos = Video::where('status',$status)->get();
        }else{
            $videos = Video::all();
        }
        // $audios = Video::all();
        

        // echo '<pre>';print_r($audios);exit;        

        return view('admin.videos.index', compact('videos','categories'));
    }

    public function create(){
        $categories = Categories::all();
        $languages = language::all();
        
        return view('admin.videos.add',compact('categories','languages'));
    }

    public function save(Request $request){

        // echo '<pre>'; print_r($request->language);exit;

        $this->validate($request, [
            'title' => 'required | string | max:255',
            'category' => 'required',
            'video_url' => 'required',
            'video_type' => 'required | string',
            'language' => 'required | string',
            'img_upload_text_link' =>'nullable|mimes:jpeg,jpg,png,gif',
            'pdf_upload_text_link' =>'nullable|mimes:pdf',

            'poet' => 'nullable| string | max:255',
            'narrator' => 'nullable | string | max:255',
            'duration' => 'nullable | string | max:255',
            'released_at' => 'nullable | string | max:255'
        ]);
        
        $admin_id = Auth::user()->id;
        
        $video = new Video();
        $video->title = $request->title ;
        $video->category = $request->category;
        $video->type = $request->video_type;
        $video->language = $request->language;
        $video->poet = $request->poet;
        $video->narrator = $request->narrator;
        $video->duration = $request->duration;
        $video->released_at = $request->released_at;
        $video->album = $request->album;
        $video->video_url = $request->video_url;

        $video->upload_by = 'admin' ;
        $video->upload_by_id = $admin_id;

        if($request->hasFile('img_upload_text_link'))
        {
            $originalImage= $request->file('img_upload_text_link');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/video/images/';
            $categ_showto = '_'.date('d_m_Y_h_i_s').'.'.$originalImage->getClientOriginalExtension();
            $thumbnailImage->save($originalPath.$request->title.$categ_showto);
            $video->audio_img = $request->title.$categ_showto;
        }

        if($request->hasFile('pdf_upload_text_link')){

            $originalImage= $request->file('pdf_upload_text_link');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/video/pdf/';
            $categ_showto = $request->category.'_'.$request->show_to.'__';
            $thumbnailImage->save($originalPath.$categ_showto.$request->title);
            $video->pdf_upload_text_link = 'video/pdf/'.$categ_showto.$request->title;
        }

        $video->save();
        return redirect()->to('/admin/video');
    }
}
