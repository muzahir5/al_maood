<?php

namespace App\Http\Controllers\Editor;

use File;
use Auth;
use Image;
use Session;
use Carbon\Carbon;
use App\Model\Admin\Audio;
use Illuminate\Http\Request;
use App\Model\Admin\Language;
use App\Model\Admin\Categories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AudioController extends Controller
{
    public function __construct() {
        $this->middleware('auth:editor');
    }

	Public function index($status = '')
    {
        $categories = Categories::all();
        if( $status != ''){
            $audios = Audio::where('status',$status)->get();
        }else{
            $audios = Audio::all();
        }
        // return $audios;
		return view('editor.audio.index', compact('categories','audios','status'));
    }

    public function create()
    {
        $categories = Categories::all();
        $languages = language::all();

        return view('editor.audio.create',compact('categories','languages'));
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
        
        $editor_id = Auth::user()->id;
        
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

        $audio->upload_by = 'editor' ;
        $audio->upload_by_id = $editor_id;
        
            
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
        return redirect()->to('/editor/audios/')->with('success', 'Audio Created Successfully');
    }

    public function edit($id)
    {
        $categories = Categories::all();
        $audio = Audio::find($id);

        // return $audio;
        return view('editor.audio.edit', compact('categories','audio'));
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

        $editor_id = Auth::user()->id;
        // Log::info($message);

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

        return redirect()->to('/editor/audios/'. $audio->status)->with('success', 'Audio # ' . $request->id . ' Update Successfully');
    }

    public function updateAudioStatus($id)
    {
        $audio_id = $id;
        $audio = Audio::where('id', $id)->first();
        $status = $audio->status ? 0 : 1;

        $audio->status = $status;
        $audio->save();
        return redirect()->back()->with('success', 'Audio # ' . $id . ' Status Change Successfully');
    }
}