<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Image;
use App\Model\Admin\Categories;
use App\Model\Admin\Audio;
use File;
use Auth;
use Carbon\Carbon;


class AudioController extends Controller
{
	public function __construct(){
    	$this->middleware('auth:admin');
    }

    public function index(){
        
        $categories = Categories::all();
        $audios = Audio::all();

        // echo '<pre>';print_r($audios);exit;

    	return view('admin.audio.index', compact('audios','categories'));
    }

    public function create(){
        $categories = Categories::all();
        
    	return view('admin.audio.add',compact('categories'));
    }

    public function save(Request $request){

        // echo '<pre>'; print_r($request->album);exit;
                // 
        $this->validate($request, [
            'title' => 'required | string | max:255',
            'category' => 'required',
            'show_to' => 'required',
            'mp3_file' =>'nullable|mimes:audio/mpeg,mpga,mp3,wav,aac',
            'img_upload_text_link' =>'nullable|mimes:jpeg,jpg,png,gif',
            'pdf_upload_text_link' =>'nullable|mimes:pdf',

            'poet' => 'nullable|required | string | max:255',
            'narrator' => 'nullable|required | string | max:255',
            'duration' => 'nullable|required | string | max:255',
            'released_at' => 'nullable|required | string | max:255'
        ]);
        
        $admin_id = Auth::user()->id;
        
        $audio = new Audio();
        $audio->title = $request->title ;
        $audio->category = $request->category;
        $audio->show_to = $request->show_to;

        $audio->poet = $request->poet;
        $audio->narrator = $request->narrator;
        $audio->duration = $request->duration;
        $audio->released_at = $request->released_at;
        $audio->album = $request->album;

        $audio->upload_by = 'admin' ;
        $audio->upload_by_id = $admin_id;
        
            
        if($request->hasFile('mp3_file')){          
           $music_file = $request->file('mp3_file');
           $uniqueid= uniqid();
           $categ_showto = $request->category.'_'.$request->show_to.'__';
           $filename = $categ_showto.Carbon::now()->format('Ymd').'_'.$request->title.'_'.$music_file->getClientOriginalExtension();
           $location = public_path('audio/mp3/');
           $music_file->move($location,$filename);

           $audio_url = 'public/audio/mp3/'.$filename;
           $audio->audio_url = $audio_url;
        }

        if($request->hasFile('img_upload_text_link')){

            $originalImage= $request->file('img_upload_text_link');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/audio/images/';
            $categ_showto = $request->category.'_'.$request->show_to.'__';
            $thumbnailImage->save($originalPath.$categ_showto.$request->title);

            $audio->img_upload_text_link = 'audio/images/'.$categ_showto.$request->title;
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
        $audio = Audio::where('id', $id)->first();
        // print_r($audio);exit;

        return view('admin.audio.edit',compact('audio','categories'));
    }

    public function update(Request $request){
                
        $this->validate($request, [
            'title' => 'required | string | max:255',
            'category' => 'required',
            'show_to' => 'required',
            'mp3_file' =>'nullable|mimes:audio/mpeg,mpga,mp3,wav,aac',
            'img_upload_text_link' =>'nullable|mimes:jpeg,jpg,png,gif',
            'pdf_upload_text_link' =>'nullable|mimes:pdf',

            'poet' => 'nullable|required | string | max:255',
            'narrator' => 'nullable|required | string | max:255',
            'duration' => 'nullable|required | string | max:255',
            'released_at' => 'nullable|required | string | max:255'
        ]);
        $audio = Audio::find($request->id);

        $audio->title = $request->title ;
        $audio->category = $request->category;
        $audio->show_to = $request->show_to;

        $audio->poet = $request->poet;
        $audio->narrator = $request->narrator;
        $audio->duration = $request->duration;
        $audio->released_at = $request->released_at;
        $audio->album = $request->album;


        if($request->hasFile('img_upload_text_link')){

            $img_upload_text_link = DB::table('audio')->where('id',$request->id)->first();
            $img_upload_text_link = $img_upload_text_link->img_upload_text_link;
            @unlink(public_path().'/'.$img_upload_text_link);

            $originalImage= $request->file('img_upload_text_link');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/audio/images/';
            $categ_showto = $request->category.'_'.$request->show_to.'__';
            $thumbnailImage->save($originalPath.$categ_showto.$request->title);

            $audio->img_upload_text_link = 'audio/images/'.$categ_showto.$request->title;            
        }
        
        if($request->hasFile('mp3_file')){   
           
           $audio_url = DB::table('audio')->where('id',$request->id)->first();
           $audio_url = $audio_url->audio_url;
           $audio_url = substr($audio_url, strrpos($audio_url, '/') + 1); // get text after last slash
           $audio_url = public_path().'/audio/mp3/'.$audio_url;
          
           @unlink(public_path().'/'.$audio_url);
        
           $music_file = $request->file('mp3_file');

           $categ_showto = $request->category.'_'.$request->show_to.'__';
           $filename = $categ_showto.Carbon::now()->format('Ymd').'_'.$request->title.'_'.$music_file->getClientOriginalExtension();
           $location = public_path('audio/mp3/');
           $music_file->move($location,$filename);

            $audio_url = 'public/audio/mp3/'.$filename;
           $audio->audio_url = $audio_url;
        }

        $audio->save();

        return redirect()->to('/admin/audio');
    }

}