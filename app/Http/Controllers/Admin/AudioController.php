<?php

namespace App\Http\Controllers\Admin;

use File;
use Auth;
use Image;
use Carbon\Carbon;
use App\Model\Location;
use App\Model\Admin\Audio;
use Illuminate\Http\Request;
use App\Model\Admin\Narrator;
use App\Model\Admin\Language;
use App\Model\Admin\Categories;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

class AudioController extends Controller
{
	public function __construct(){
        // phpinfo();exit;
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
        $categories = Categories::where('category_type','audio')->get();
        $languages = language::all();
        $locations = Location::all();
        $narrators = Narrator::all();
        // echo '<pre>';print_r($locations);exit;
    	return view('admin.audio.add',compact('categories','languages','locations','narrators'));
    }
    public function save(Request $request){
        // echo '<pre>'; print_r($request->language);exit;
        $this->validate($request, [
            'title' => 'required | string | max:255',
            'category' => 'required',
            'audio_type' => 'required | string',
            'show_to' => 'required',
            'language' => 'required | string',
            // 'mp3_file' =>'required|mimes:audio/mpeg,mpga,mp3,wav,aac',
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
        $audio->location = $request->location;
        $audio->poet = $request->poet;
        $audio->narrator = $request->narrator;
        $audio->duration = $request->duration;
        $audio->released_at = $request->released_at;
        $audio->album = $request->album;
        $audio->video_url = $request->video_url;

        $audio->upload_by = 'admin' ;
        $audio->upload_by_id = $admin_id;
        // echo 55;exit;

        $title_r = str_replace(' ', '-', $request->title); //replece ' ' with -
            
        if($request->hasFile('mp3_file')){
           $music_file = $request->file('mp3_file');           
           $categ_showto = '_'.date('d_m_Y_h_i_s');
           $filename = $title_r.''.$categ_showto.'.'.$music_file->getClientOriginalExtension();
           $location = public_path('audio/mp3/');
           $music_file->move($location,$filename);

           $audio_url = 'audio/mp3/'.$filename;
           $audio->audio_url = $audio_url;
        }

        if($request->hasFile('img_upload_text_link')){
            $originalImage= $request->file('img_upload_text_link');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/audio/images/';
            $categ_showto = '_'.date('d_m_Y_h_i_s').'.'.$originalImage->getClientOriginalExtension();
            $thumbnailImage->save($originalPath.$title_r.$categ_showto);

            $audio->audio_img = 'audio/images/'.$title_r.$categ_showto;
        }

        if($request->hasFile('pdf_upload_text_link')){

            $originalImage= $request->file('pdf_upload_text_link');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/audio/pdf/';
            $categ_showto = $request->category.'_'.$request->show_to.'__';
            $thumbnailImage->save($originalPath.$categ_showto.$title_r);

            $audio->pdf_link = 'audio/pdf/'.$categ_showto.$title_r;
        }

        $audio->save();
        return redirect()->to('/admin/audio');
    }
    public function edit($id)
    {
        $categories = Categories::all();
        $narrators = Narrator::all();
        $audio = Audio::where('id', $id)->first();
        $locations = Location::all();
        // print_r($audio);exit;

        return view('admin.audio.edit',compact('audio','categories','narrators','locations'));
    }
    public function update(Request $request){
        $this->validate($request, [
            'title' => 'required | string | max:255',
            'category' => 'required',
            'audio_type' => 'required | string',
            'language' => 'required | string',
            'show_to' => 'required',
            // 'mp3_file' =>'nullable|mimes:audio/mpeg,mpga,mp3,wav,aac',
            'img_upload_text_link' =>'nullable|mimes:jpeg,jpg,png,gif',
            'pdf_upload_text_link' =>'nullable|mimes:pdf',

            'poet' => 'nullable | string | max:255',
            'narrator' => 'nullable | string | max:255',
            'duration' => 'nullable | string | max:255',
            'released_at' => 'nullable | string | max:255'
        ]);

        if($request->location < 1){
            $locations = Location::all();
            foreach ($locations as $loc) {
                if($loc['name'] == 'Others'){
                    $location = $loc['id'];
                }
            }
        }else{
            $location = $request->location;
        }

        $audio = Audio::find($request->id);

        $audio->title = $request->title ;
        $audio->category = $request->category;
        $audio->type = $request->audio_type;
        $audio->language = $request->language;
        $audio->location = $location;
        $audio->show_to = $request->show_to;

        $audio->poet = $request->poet;
        $audio->narrator = $request->narrator;
        $audio->duration = $request->duration;
        $audio->released_at = $request->released_at;
        $audio->description = $request->description;
        $audio->album = $request->album;
        $audio->video_url = $request->video_url;

        $title_r = str_replace(' ', '-', $request->title); //replece ' ' with -
        
        if($request->hasFile('mp3_file')){   
           
           $audio_url = DB::table('audio')->where('id',$request->id)->first();
           $audio_url = $audio_url->audio_url;
           //$audio_url = substr($audio_url, strrpos($audio_url, '/') + 1); // get text after last slash
           $audio_url = '/audio/mp3/'.$audio_url;
          
           @unlink(public_path().'/'.$audio_url);
        
           $music_file = $request->file('mp3_file');
           $categ_showto = '_'.date('d_m_Y_h_i_s');
           $filename = $title_r.''.$categ_showto.'.'.$music_file->getClientOriginalExtension();
           $location = public_path('audio/mp3/');
           $music_file->move($location,$filename);

            $audio_url = 'audio/mp3/'.$filename;
            $audio->audio_url = $audio_url;
        }

        if($request->hasFile('img_upload_text_link')){

            $img_upload_text_link = DB::table('audio')->where('id',$request->id)->first();
            $img_upload_text_link = '/audio/images/'.$img_upload_text_link->audio_img;
            @unlink(public_path().'/'.$img_upload_text_link);

            $originalImage= $request->file('img_upload_text_link');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/audio/images/';            
            $categ_showto = '_'.date('d_m_Y_h_i_s').'.'.$originalImage->getClientOriginalExtension();
            $thumbnailImage->save($originalPath.$title_r.$categ_showto);

            $audio->audio_img = 'audio/images/'.$title_r.$categ_showto;
        }
        
        if($request->hasFile('pdf_upload_text_link')){
            
            $pdf_links = DB::table('audio')->where('id',$request->id)->first();
            $pdf_link = $pdf_links->pdf_link;
            @unlink(public_path().'/'.$pdf_link);

            $file = $request->file('pdf_upload_text_link');
            $filename = '/audio/pdf/'.$title_r .'_'. date('d_m_Y_h_i_s').'.'. $request->file('pdf_upload_text_link')->extension();
            $filePath = public_path() . '/audio/pdf/';
            $file->move($filePath, $filename);
            $audio->pdf_link = "$filename";
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