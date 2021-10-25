<?php

namespace App\Http\Controllers\Api;

use Auth;
use File;
use Image;
use Session;
use Carbon\Carbon;
use App\Model\User\User;
use App\Model\Admin\Audio;
use App\Model\User\Friend;
use Illuminate\Http\Request;
use App\Model\User\WithDraw;
use App\Model\User\SharePost;
use App\Model\Admin\language;
use App\Model\User\FriendSms;
use App\Model\Admin\Narrator;
use App\Model\Admin\Categories;
use App\Model\User\UserEarning;
use App\Model\User\UserPostEarn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Model\User\FavouriteList as Fav;
use Illuminate\Support\Facades\Validator;

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
            'base_path' => base_path().'/',
            'audios' => $audios
        ]);
    }

    public function listAudioByCatagory($categ_id,$lang='')
    {
        $categories = Categories::all();
        $query = Audio::select('id','title','description','narrator','language','upload_by','category','audio_url','audio_img','view_by','show_to')
                    ->Where('category', $categ_id)->where('status',1)->orderBy('view_by','DESC');
        
        if($lang != ''){
            //search in Category
            $query->where(function ($query) use ($lang) {
                        $query->orWhere('language',$lang);
                        
                });
        }
        
        $audios = $query->get();

        $list_lang =  DB::table('audio')->where('category',$categ_id)
                        ->select('language as language_id',DB::raw('count(id) as lang_count'))
                        ->groupBy('language')->get();        

        return response()->json([            
            'status' => "success",
            'base_path' => base_path().'/',
            'audios' => $audios,
            'list_lang' => $list_lang
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
            $relavent_audio = Audio::where(['category'=> $audio->category,'status'=> 1, 'language'=>$audio->language])->where('id','!=',$audio->id)->get();
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
        // echo $request->language;exit;
        $validator = Validator::make($request->all(), [
                        'user_id' => 'required|integer',
                        'title' => 'required | string | max:255',
                        'category' => 'required|integer',
                        'language' => 'required|integer',
                        'show_to' => 'nullable',
                        'mp3_file' =>'required |mimes:mp3',
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
        $audio->show_to = 0; //$request->show_to;

        $audio->poet = $request->poet;
        $audio->narrator = $request->narrator;
        $audio->duration = $request->duration;
        $audio->released_at = $request->released_at;
        $audio->album = $request->album;

        $audio->upload_by = $user->name ;
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
        }

        if($request->hasFile('pdf_upload_text_link')){

            $originalImage= $request->file('pdf_upload_text_link');
            $thumbnailImage = Image::make($originalImage);            
            $originalPath = public_path().'/audio/pdf/';
            $categ_showto = $request->category.'_'.$request->show_to.'__';
            $thumbnailImage->save($originalPath.$categ_showto.$request->title);

            $audio->pdf_upload_text_link = 'audio/pdf/'.$categ_showto.$request->title;
        }
        // echo '<pre>';print_r($audio);exit;

        $audio->save();
        return response()->json(
            [
                'status' => 'success',
                'audio_id' => $audio->id,
                'message' => "Audio has been Added successfully, After Activation Audio will be showing in app" ]
        );
    }

    public function UpdateAudio(Request $request)
    {
        $audio = Audio::where(['id'=>$request->audio_id , 'upload_by_id'=>$request->user_id])->first();
        
        if(!count($audio) > 0 ){
            return response()->json([            
                'status' => 'error', 'audio' => '',
                'message' => "UserId or AudioId is not matched"
            ]);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'audio_id' => 'required|integer',
            'title' => 'required | string | max:255',
            'category' => 'required',
            'audio_type' => 'nullable | string',
            'language' => 'required | string',
            'show_to' => 'nullable',
            'mp3_file' =>'nullable|mimes:audio/mpeg,mpga,mp3,wav,aac',
            'img_upload_text_link' =>'nullable|mimes:jpeg,jpg,png,gif',
            'pdf_upload_text_link' =>'nullable|mimes:pdf',

            'poet' => 'nullable | string | max:255',
            'narrator' => 'nullable | string | max:255',
            'duration' => 'nullable | string | max:255',
            'released_at' => 'nullable | string | max:255'
        ]);

        if ($validator->fails()) {
            return response()->json( [ 'status' => 'error', 'error' => $validator->errors() ]);
        }        
        
        $audio->title = $request->title ;
        $audio->category = $request->category;
        $audio->type = $request->audio_type;
        $audio->language = $request->language;
        $audio->show_to = 0; //$request->show_to;

        $audio->poet = $request->poet;
        $audio->narrator = $request->narrator;
        $audio->duration = $request->duration;
        $audio->released_at = $request->released_at;
        $audio->album = $request->album;
        $audio->status = 4;


        if($request->hasFile('img_upload_text_link')){

            $img_upload_text_link = DB::table('audio')->where('id',$request->audio_id)->first();
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
           
           $audio_url = DB::table('audio')->where('id',$request->audio_id)->first();
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

        return response()->json([            
            'status' => 'success', 'message' => "Audio Udated Successfully",
            'audio' => $audio
        ]);
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

    public function getCategories(){
        $categories = DB::table('categories')->where('status',1)->get();
        $languages = language::select('id','name')->get();
        
        return response()->json(
            [
                'status' => 'success',
                'categories' => $categories,
                'languages' => $languages
            ]
        );
    }

    public function getNarrators()
    {
        $narrators = Narrator::where('status',1)->get();

        return response()->json(
            [
                'status' => 'success',
                'narrators' => $narrators
            ]
        );
    }

    public function addFavourite(Request $request)
    {
        $status = 'fail';
        $user = User::where('id', $request->user_id)->first();
        if(!$user)
        { 
            return response()->json([ 'status' => 'fail', 'message' => 'Invalid User Id' ]);
        }

        $fav = new Fav();
        $fav->user_id = $request->user_id;
        $fav->user_type = $request->user_type;
        $fav->post_id = $request->post_id;
        $fav->post_type = $request->post_type;
        // print_r($fav);
        $fav_added = $fav->save();
        if($fav_added){
            event_track_from_fx_hlpr($post_id = $fav->id, $user_id = $request->user_id, $event_type = 'added_fav');
            $status = 'success';
        }

        return response()->json([ 'status' => $status, 'message' => 'successfully added in favourite' ]);
    }

    public function removeFavourite(Request $request)
    {
        $status = 'fail';
        $message = null;        

        $remove_fav = DB::table('favourite_lists')->where([ 'id' => $request->id, 'user_id' => $request->user_id])->delete();
        if($remove_fav){            
            $status = 'success';
            $message = 'successfully removed';
        }
        $fav_list = DB::table('favourite_lists')->where([ 'user_id' => $request->user_id])->get();

        return response()->json([            
            'status' => $status,
            'message' => $message,
            'favourite_list' => $fav_list
        ]);
    }

    public function FavouriteList($user_id)
    {
        $status = 'error';
        $fav_list = DB::table('favourite_lists')->where([ 'user_id' => $user_id])->get();
        
        if(count($fav_list) > 0 ){
            $status = 'success';
        }

        return response()->json([            
            'status' => $status,
            'favourite_list' => $fav_list
        ]);
        
    }

    public function sharePost(Request $request)
    {
        $status = 'error';

        $share_post = new SharePost();
        $share_post->from_u_id  = $request->from_u_id;
        $share_post->to_u_id    = $request->to_u_id;
        $share_post->post_id    = $request->post_id;
        $share_post->post_type  = $request->post_type;

        $share_post = $share_post->save();

        if($share_post){
            $message = 'audio: '.$request->post_id .' share successfully to '. $request->to_u_id .' by '. $request->from_u_id;
            Log::info($message);
            $status = 'success';
        }

        return response()->json([ 'status' => $status, 'message' => $request->post_type .' share successfully' ]);
    }
    
} //End Controller
