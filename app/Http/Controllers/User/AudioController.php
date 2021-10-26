<?php

namespace App\Http\Controllers\User;

use File;
use Auth;
use Image;
use Carbon\Carbon;
use App\Model\Admin\Audio;
use Illuminate\Http\Request;
use App\Model\Admin\Language;
use App\Model\Admin\Narrator;
use App\Model\Admin\Categories;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;



class AudioController extends Controller
{
    public function __construct(){
    	$this->middleware('auth:user');
    }

    Public function index($status = '')
    {
        $categories = Categories::all();
        if( $status != ''){
            $audios = Audio::where(['status'=>$status,'upload_by'=> 'user','upload_by_id'=> Auth::user()->id])->get();
        }else{
            $audios = Audio::where(['upload_by'=> 'user','upload_by_id'=> Auth::user()->id])->get();
        }
        // return $audios;
		return view('user.audio.index', compact('categories','audios','status'));
    }

    public function create(){
        $categories = Categories::all();
        $languages = language::all();
        $narrators = Narrator::all();
        
    	return view('user.audio.add',compact('categories','languages','narrators'));
    }

    public function store(Request $request)
    {
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
        
        $user_id = Auth::user()->id;
        
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

        $audio->upload_by = 'user' ;
        $audio->upload_by_id = $user_id;
        
            
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
        return redirect()->to('/user/audios/')->with('success', 'Audio Created Successfully');
    }

    public function edit($id)
    {
        $categories = Categories::all();
        $narrators = Narrator::all();
        $audio = Audio::find($id);

        // return $audio;
        return view('user.audio.edit', compact('categories','audio','narrators'));
    }

    public function update(Request $request)
    {
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

        $user_id = Auth::user()->id;
        $upload_by_id = $audio->upload_by_id;

        if($user_id != $upload_by_id){
            return redirect()->back()->with('danger', 'Your are not allowed to update this audio.');
        }        

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

        return redirect()->to('/user/audios/'. $audio->status)->with('success', 'Audio # ' . $request->id . ' Update Successfully');
    }
}
