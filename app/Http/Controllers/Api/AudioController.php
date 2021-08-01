<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Illuminate\Support\Facades\DB;
use App\Model\User\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Model\Admin\Audio;
use App\Model\Admin\Categories;
use App\Model\User\FavouriteList as Fav;
use App\Model\User\Friend;
use App\Model\User\FriendSms;
use App\Model\User\UserPostEarn;
use App\Model\User\UserEarning;
use Carbon\Carbon;
use File;
use Image;
use App\Model\User\WithDraw;

class AudioController extends Controller
{
    //can apply on General search  || search in category
	public function listAudio(Request $request){
        $searchInAll = $request->searchInAll ? $request->searchInAll : '';
        $searchInCat = $request->searchInCat ? $request->searchInCat : '';

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
        }elseif($searchInCat != ''){
            //search in Category
            $query->where(function ($query) use ($searchInCat) {
                        $query->orWhere('category', 'like', "%{$searchInCat}%");
                        
                });
        }
        $audios = $query->get();        

        return response()->json([            
            'status' => "success",
            'audios' => $audios
        ]);
    }

    public function listAudioByCatagory($cat_id)
    {
        $categories = Categories::all();
        $audios = Audio::select('id','title','description','narrator','upload_by','category','audio_url','audio_img','view_by','show_to')->where('status',1)->Where('category', 'like', "%{$cat_id}%")->get();        

        return response()->json([            
            'status' => "success",
            'audios' => $audios
        ]);
    }

    public function listAudioBYUser(Request $request)
    {
        $user_id = $request->user_id;
        $audios = Audio::where('upload_by_id',$user_id)->where('status','!=',3)->get();

        return response()->json([            
            'status' => "success",
            'audios' => $audios
        ]);

    }

    public function showAudio(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'id' => ['required','numeric','gt:0']
        ]);
        if ($validator->fails()) {
            return response()->json( [ 'status' => 'error', 'error' => $validator->errors() ]);
        }

        $status = 'fail';
        $relavent_audio = null;

        $id = $request->id;
        $categories = Categories::all();
        $audio = Audio::where( [ 'id'=> $id, 'status'=> 1 ])->first();
                
        if($audio){
            event_track_from_fx_hlpr($post_id = $id, $user_id = null, $event_type = 'show_audio');
            $status = 'success';
            $relavent_audio = Audio::where(['category'=> $audio->category, 'show_to'=>$audio->show_to])->where('id','!=',$audio->id)->get();
        }
        // if (!$relavent_audio) { $relavent_audio = null; }       

        // echo $audio->show_to;exit;
        // echo print_r($relavent_audio);exit;

        return response()->json([            
            'status' => $status,
            'audio' => $audio,
            'base_path' => base_path().'/',
            'relavent_audio' => $relavent_audio,            
        ]);
    }

    public function addAudio(Request $request)
    {
        // echo 33;exit;
        $validator = Validator::make($request->all(), [
                        'user_id' => 'required|integer',
                        'title' => 'required | string | max:255',
                        'category' => 'required|integer',
                        'show_to' => 'nullable',
                        'mp3_file' =>'required ',//|mimes:audio/mpeg,mpga,mp3,wav,aac',
                        'img_upload_text_link' =>'nullable|mimes:jpeg,jpg,png,gif',
                        'pdf_upload_text_link' =>'nullable|mimes:pdf',

                        'poet' => 'nullable| string | max:255',
                        'narrator' => 'nullable | string | max:255',
                        'duration' => 'nullable | string | max:255',
                        'released_at' => 'nullable | string | max:255'
                    ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'error' => $validator->errors()
                ], 200);
        }

        $user_id = $request->user_id;
        $user = User::where('id', $request->user_id)->first();
        
        $audio = new Audio();
        $audio->title = $request->title ;
        $audio->category = $request->category;
        $audio->show_to = $request->show_to;

        $audio->poet = $request->poet;
        $audio->narrator = $request->narrator;
        $audio->duration = $request->duration;
        $audio->released_at = $request->released_at;
        $audio->album = $request->album;

        $audio->upload_by = $user->name ;
        $audio->upload_by_id = $user_id;
        
/*            
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

            $audio->audio_img = 'audio/images/'.$categ_showto.$request->title;
        }

        if($request->hasFile('pdf_upload_text_link')){

            $originalImage= $request->file('pdf_upload_text_link');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/audio/pdf/';
            $categ_showto = $request->category.'_'.$request->show_to.'__';
            $thumbnailImage->save($originalPath.$categ_showto.$request->title);

            $audio->pdf_upload_text_link = 'audio/pdf/'.$categ_showto.$request->title;
        }*/

        $audio->audio_url = 'test';
        // echo '<pre>';print_r($audio);exit;

        $audio->save();
        return response()->json(
            [ 'status' => 'success', 'message' => "Audio has been Added successfully, After Activation Audio will be showing in app" ]
        );
    }

    public function updateAudioStatus(Request $request)
    {        
        $user_id = $request->user_id;        

        $audio_id = $request->id;
        $status = $request->status;
        $audio = Audio::where('id', $audio_id)->first();
        // $status = $audio->status ? 0 : 1;
        $msg = $status == 3 ? 'deleted' : 'updated';
        event_track_from_fx_hlpr($post_id = $audio_id,$user_id = $user_id,$event_type = 'audio_status_'.$status);
        $audio->status = $status;
        $audio->save();
        $audios = Audio::where('upload_by_id',$user_id)->where('status','!=',3)->get();
        return response()->json(
            [ 
                'status' => 'success',
                'message'=> "Audio has been $msg successfully",
                'audios' => $audios
            ]
        );
    }

    public function updateAudioPlayeCount(Request $request)
    {        
        $audio_id = $request->audio_id;
        $user_id = $request->user_id ? $request->user_id : 0;
        // exit($audio_id);
        $audio = Audio::where('id', $audio_id)->first();
        $audio->view_by = $audio->view_by + 1;        
        event_track_from_fx_hlpr($post_id = $audio_id,$user_id = $user_id,$event_type = 'audio_played_'.date('Y_m_d_h_i_s'), $device_type = 'app');
        $audio->save();        
        return response()->json(
            [ 
                'status' => 'success',
                'message'=> "Audio has been played successfully"
            ]
        );
    }
    
} //End Controller
