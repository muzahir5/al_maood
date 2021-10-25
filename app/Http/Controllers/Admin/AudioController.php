<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Image;
use App\Model\Admin\Categories;
use App\Model\Admin\Narrator;
use App\Model\Admin\Language;
use App\Model\Admin\Audio;
use File;
use Auth;
use Carbon\Carbon;


class AudioController extends Controller
{
	public function __construct(){
    	$this->middleware('auth:admin');
    }

    public function index($status = ''){
        
        $categories = Categories::all();

        if( $status != ''){
            $audios = Audio::where('status',$status)->get();
        }else{
            $audios = Audio::all();
        }
        // $audios = Audio::all();
        

        // echo '<pre>';print_r($audios);exit;        

    	return view('admin.audio.index', compact('audios','categories'));
    }

    public function create(){
        $categories = Categories::all();
        $languages = language::all();
        
    	return view('admin.audio.add',compact('categories','languages'));
    }

    public function save(Request $request){

        // echo '<pre>'; print_r($request->album);exit;
                //         
        $this->validate($request, [
            'title' => 'required | string | max:255',
            'category' => 'required',
            'audio_type' => 'required | string',
            'show_to' => 'required',
            'language' => 'required | string',
            'mp3_file' =>'required|mimes:audio/mpeg,mpga,mp3,wav,aac',
            'img_upload_text_link' =>'nullable|mimes:jpeg,jpg,png,gif',
            'pdf_upload_text_link' =>'nullable|mimes:pdf',

            'poet' => 'nullable| string | max:255',
            'narrator' => 'nullable | string | max:255',
            'duration' => 'nullable | string | max:255',
            'released_at' => 'nullable | string | max:255'
        ]);
        
        $admin_id = Auth::user()->id;
        
        $audio = new Audio();
        $audio->title = $request->title ;
        $audio->category = $request->category;
        $audio->type = $request->audio_type;
        $audio->show_to = $request->show_to;
        $audio->language = $request->language;
        $audio->poet = $request->poet;
        $audio->narrator = $request->narrator;
        $audio->duration = $request->duration;
        $audio->released_at = $request->released_at;
        $audio->album = $request->album;

        $audio->upload_by = 'admin' ;
        $audio->upload_by_id = $admin_id;
        
            
        if($request->hasFile('mp3_file')){          
           $music_file = $request->file('mp3_file');           
           $categ_showto = '_'.date('d_m_Y_h_i_s');
           $filename = $request->title.''.$categ_showto.'.'.$music_file->getClientOriginalExtension();
           $location = public_path('audio/mp3/');
           $music_file->move($location,$filename);

           $audio_url = $filename;
           $audio->audio_url = $audio_url;
        }

        if($request->hasFile('img_upload_text_link')){

            $originalImage= $request->file('img_upload_text_link');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/audio/images/';
            $categ_showto = '_'.date('d_m_Y_h_i_s').'.'.$originalImage->getClientOriginalExtension();
            $thumbnailImage->save($originalPath.$request->title.$categ_showto);

            $audio->audio_img = $request->title.$categ_showto;

            $audio->audio_img;
        }

        if($request->hasFile('pdf_upload_text_link')){

            $originalImage= $request->file('pdf_upload_text_link');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/audio/pdf/';
            $categ_showto = $request->category.'_'.$request->show_to.'__';
            $thumbnailImage->save($originalPath.$categ_showto.$request->title);

            $audio->pdf_upload_text_link = 'audio/pdf/'.$categ_showto.$request->title;
        }

        $audio->save();
        return redirect()->to('/admin/audio');
    }

    public function edit($id)
    {
        $categories = Categories::all();
        $narrators = Narrator::all();
        $audio = Audio::where('id', $id)->first();
        // print_r($audio);exit;

        return view('admin.audio.edit',compact('audio','categories','narrators'));
    }

    public function update(Request $request){
                
        $this->validate($request, [
            'title' => 'required | string | max:255',
            'category' => 'required',
            'audio_type' => 'required | string',
            'language' => 'required | string',
            'show_to' => 'required',
            'mp3_file' =>'nullable|mimes:audio/mpeg,mpga,mp3,wav,aac',
            'img_upload_text_link' =>'nullable|mimes:jpeg,jpg,png,gif',
            'pdf_upload_text_link' =>'nullable|mimes:pdf',

            'poet' => 'nullable | string | max:255',
            'narrator' => 'nullable | string | max:255',
            'duration' => 'nullable | string | max:255',
            'released_at' => 'nullable | string | max:255'
        ]);
        $audio = Audio::find($request->id);

        $audio->title = $request->title ;
        $audio->category = $request->category;
        $audio->type = $request->audio_type;
        $audio->language = $request->language;
        $audio->show_to = $request->show_to;

        $audio->poet = $request->poet;
        $audio->narrator = $request->narrator;
        $audio->duration = $request->duration;
        $audio->released_at = $request->released_at;
        $audio->album = $request->album;


        if($request->hasFile('img_upload_text_link')){

            $img_upload_text_link = DB::table('audio')->where('id',$request->id)->first();
            $img_upload_text_link = '/audio/images/'.$img_upload_text_link->audio_img;
            @unlink(public_path().'/'.$img_upload_text_link);

            $originalImage= $request->file('img_upload_text_link');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/audio/images/';            
            $categ_showto = '_'.date('d_m_Y_h_i_s').'.'.$originalImage->getClientOriginalExtension();
            $thumbnailImage->save($originalPath.$request->title.$categ_showto);

            $audio->audio_img = $request->title.$categ_showto;            
        }
        
        if($request->hasFile('mp3_file')){   
           
           $audio_url = DB::table('audio')->where('id',$request->id)->first();
           $audio_url = $audio_url->audio_url;
           //$audio_url = substr($audio_url, strrpos($audio_url, '/') + 1); // get text after last slash
           $audio_url = '/audio/mp3/'.$audio_url;
          
           @unlink(public_path().'/'.$audio_url);
        
           $music_file = $request->file('mp3_file');
           $categ_showto = '_'.date('d_m_Y_h_i_s');
           $filename = $request->title.''.$categ_showto.'.'.$music_file->getClientOriginalExtension();
           $location = public_path('audio/mp3/');
           $music_file->move($location,$filename);

            $audio_url = $filename;
           $audio->audio_url = $audio_url;
        }

        $audio->save();

        return redirect()->to('/admin/audio');
    }

    public function updateAudioStatus($id)
    {
        $audio_id = $id;
        $audio = Audio::where('id', $id)->first();
        $status = $audio->status ? 0 : 1;

        $audio->status = $status;
        $audio->save();
        return redirect()->to('/admin/audio');
    }
}