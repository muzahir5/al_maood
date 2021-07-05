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
use App\Model\Dashboard\CustomPostTracking as PostTracking;
use App\Model\User\FavouriteList as Fav;
use App\Model\User\Friend;
use App\Model\User\FriendSms;
use App\Model\User\UserPostEarn;
use App\Model\User\UserEarning;
use Carbon\Carbon;
use File;
use Image;
use App\Model\User\WithDraw;

class UserController extends Controller
{

	public function userRegister(Request $request){
		// echo $request->name;

		$validator = Validator::make($request->all(), [
                        'email' => 'required|email|unique:users',
                        'password' => 'required|string',
                        'name' => 'required|string',
                        'mobile_number' => ['required','numeric']
                    ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'error' => $validator->errors()
                ], 200);
        }

        $user = User::create(request(['name', 'email', 'password']));
        if($user){
            $user->mobile_number = $request->mobile_number;
            $user->update();
            event_track_from_fx_hlpr($post_id = null, $user_id = $user->id, $event_type = 'u_registered_'.$user->id);

            return response()->json([            
                'status' => "success",
                'data' => $user
            ]);
        }else{
            return response()->json([            
                'status' => "error",
                'msg' => 'something went wrong'
            ]);
        }
	}

    public function userLogin(Request $request)
    {
        echo 5;exit;
        $validator = Validator::make($request->all(), [
                        'email' => 'required|email',
                        'password' => 'required|string'
                        // ,'mobile_number' => ['required','numeric']
                    ]);
        if ($validator->fails()) {
            return response()->json( [ 'status' => 'error', 'error' => $validator->errors() ], 200);
        }

        $user = User::where('email', $request->email)->first(); //->where('status', "1")
        if($user)
        {
            if($user->status == 0){
                return response()->json([ 'status' => "fail", 'message' => 'please activate your Account' ]);
            }elseif($user->status == 3){
                return response()->json([ 'status' => 'fail', 'message' => "You Have been Block" ]);
            }
            elseif(Hash::check($request->password, $user->password))
            {                
                $user->count_login = $user->count_login + 1;
                $user->is_loged_in = 1;
                $user->logged_token = bin2hex(random_bytes(36));
                $user->update();                

                event_track_from_fx_hlpr($post_id = null, $user_id = $user->id, $event_type = 'u_login');

                return response()->json([
                    'status' => 'success',
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'full_name' => $user->name,
                    'mobile_number' => $user->mobile_number,
                    'logged_token' => $user->logged_token,
                ]);
            }
            else
            {
                return response()->json([ 'status' => "error", 'error' => 'Invalid Password' ]);
            }
        }
        else
        {
            return response()->json([ 'status' => "error", 'error' => 'Invalid E-mail' ]);
        }
    }

    public function userLogout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            // 'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json( [ 'status' => 'error', 'error' => $validator->errors() ], 200);
        }
        $status = 'fail'; $message = null;
        $user = User::where('id', $request->id)->first(); //->where('status', "1")
        if($user)
        {
            $user->is_loged_in = 0;
            $user->logged_token = NULL;
            $user->update();
            event_track_from_fx_hlpr($post_id = null, $user_id = $user->id, $event_type = 'u_logout');
            $status = 'success'; $message = 'successfully logout';
        }
        return response()->json([ 'status' => $status, 'message' => $message ]);
    }

    public function userUpdate(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        if(!$user)
        {
            return response()->json([ 'status' => "fail", 'message' => 'user not found' ]);
        }
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'name' => 'required|string|alpha_num',
            'mobile_number' => ['required','numeric'],
            'country' => 'required|string',
            'city' => 'required|string',
            'village' => 'required|string',
            'mobile_network' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json( [ 'status' => 'error', 'error' => $validator->errors() ], 200);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->village = $request->village;
        $user->mobile_number = $request->mobile_number;
        $user->mobile_network = $request->mobile_network;        
        $user->update();
        event_track_from_fx_hlpr($post_id = null, $user_id = $user->id, $event_type = 'u_updated');
        // print_r($user);exit;

        return response()->json([            
            'status' => "success",
            'data' => $user
        ]);
    }

    public function password_forgot(Request $request){
        $validator = Validator::make($request->all(), [
                        'email' => 'required|email'
                    ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'error' => $validator->errors()
                ], 200);
        }

        $email = strtolower($request->email);

        $user = User::where('email',$email)->first();
        if(!empty($user) && $user->email == $email){
            
            $id = $user->id;
            $code = $id.date("is");
            $name = $user->name;

            // $user = User::where('email',$email)->update( ['pass_forgot_code'=>$code] );

            // Mail::to($email)->send(new RiderForgotPasswordCode($code,$name));

            return response()->json([
                    'status' => "success",
                    'data' => $code
                ]);
        }else{
            return response()->json([
                    'error' => 'user no exist',
                    'status' => 'error'
                ]);
        }
    }

    public function getUserById(Request $request){
        
        $status = 'fail';
        $user = User::where('id', $request->user_id)->first(); //->where('status', "1")
        if($user)
        {
            $status = 'success';
        }
        return response()->json([            
            'status' => $status,
            'user' => $user
        ]);
    }

    public function getUserBySearch(Request $request){
        
        $status = 'fail';
        $user = User::select('id','name','email','mobile_number')->where('name', 'LIKE', "%$request->search%")->orWhere('email', 'like', '%' . $request->search . '%')
                            ->orWhere('mobile_number', 'like', '%' . $request->search . '%')
                        // ->where('status', "1")
                        ->get();
        if($user)
        {
            $status = 'success';
        }
        return response()->json([            
            'status' => $status,
            'user' => $user
        ]);
    }

    // other controller fx below

    public function getProducts(){
    	$products = DB::table('products as prod')->select('prod.id','prod.name','prod.price','prod.sale_price','prod_imgs.image_url')
                        ->join('product_images as prod_imgs', 'prod.id','prod_imgs.product_id')->get();

        // echo "<pre>".print_r($products);

        return response()->json([            
            'status' => "success",
            'data' => $products
        ]);
    }

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

            $audio->img_upload_text_link = 'audio/images/'.$categ_showto.$request->title;
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

    public function postTracking(Request $request)
    {
        // $user_id = $request->user_id ? $request->user_id : NULL;

        $post_tracking = new PostTracking();
        $post_tracking->post_id = $request->post_id;
        $post_tracking->user_id = $request->user_id;
        $post_tracking->language = $request->language ;
        $post_tracking->device_type = $request->device_type ;
        $post_tracking->event_type = $request->event_type ;     //list,view/play,download,gift,add/rm fav 
        // print_r($post_tracking);
        
        $post_tracking->save();
        
        return response()->json([ 'status' => 'success', 'message' => "$request->event_type tracked successfully" ]);
    }

    public function addFavourite(Request $request){

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
            event_track_from_fx_hlpr($post_id = $request->id,$user_id = $request->user_id,$event_type = 'remove_fav');
            $status = 'success';
            $message = 'successfully removed';
        }

        return response()->json([            
            'status' => $status,
            'message' => $message
        ]);
    }

    public function addFriend(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_user_id' => ['required','numeric'],
            'response_user_id' => ['required','numeric']
        ]);
        if($request->status == 13)
        { // status = 3 == >> block
            $validator = Validator::make($request->all(), [ 'reporter_id' => ['required','numeric','gt:0'] ]);
        }

        if ($validator->fails()) {
            return response()->json( [ 'status' => 'error', 'error' => $validator->errors() ]);
        }

        $status = $request->status ? $request->status : 0;
        $friend = new Friend();
        $friend->request_user_id = $request->request_user_id;
        $friend->response_user_id = $request->response_user_id;
        $friend->reporter_id = $request->reporter_id;
        $friend->status = $status;
        $frnd = $friend->save();

        $statuss = 'fail'; $message = null;
        if($friend)
        {
            event_track_from_fx_hlpr($post_id = $friend->id, $user_id = $request->request_user_id, $event_type = 'friend_request_status_' . $status);
            $statuss = 'success';
            $message = $request->status == 13 ? 'user block succesfully' : 'friend request send successfully';
        }
        return response()->json([ 'status' => $statuss, 'message' => $message ]);
    }

    // accept,block,unfriend will handle here
    public function modifyFriendStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_id' => ['required','numeric'],
            'user_id' => ['required','numeric'],
            'user_to_id' => ['required','numeric'],
            'status' => ['required','numeric'],
        ]);
        if($request->status == 3)
        { // status = 3 == >> block
            $validator = Validator::make($request->all(), [ 'reporter_id' => ['required','numeric','gt:0'] ]);
        }

        if ($validator->fails()) {
            return response()->json( [ 'status' => 'error', 'error' => $validator->errors() ]);
        }
        $status = 'fail'; $message = null;
        $friend = Friend::where(['request_user_id' => $request->user_id, 'response_user_id' => $request->user_to_id])->first();
        if(!$friend)
        {
            return response()->json([ 'status' => "fail", 'message' => 'no record found' ]);
        }

        if($friend->status == 3 && $friend->reporter_id != $request->login_id){
            return response()->json([ 'status' => "fail", 'message' => "you don't have the permissaion" ]);
        }
        // echo 44;exit;
        $status = $request->status;                

        $friend->status= $status;
        $friend->reporter_id= $request->reporter_id;
        $modifyfiend = $friend->update();
        if($modifyfiend)
        {
            event_track_from_fx_hlpr($post_id = $request->login_id, $user_id = $request->user_id, $event_type = 'modifyfiend_status_'.$status);
            
            if($status == 1){ $message = 'friend request accepted'; }
            if($status == 3){ $message = 'user successfully blocked'; }
            if($status == 4){ $message = 'user successfully unfriend';}
            if($status == 5){ $message = 'user successfully unblock';}
            $status = 'success';
            $message = $message;
        }
        return response()->json([ 'status' => $status, 'message' => $message ]);
    }
    
    public function listFriends(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required','numeric']
        ]);
        if ($validator->fails()) {
            return response()->json( [ 'status' => 'error', 'error' => $validator->errors() ]);
        }

        $friends=DB::table('friends as f')->select('f.response_user_id as user_id','f.status as f_status','u.name')
                                        ->where('f.request_user_id' , $request->user_id)->whereNotIn('f.status' , [2,3,4,13])
                                        ->join('users as u', 'u.id', 'f.response_user_id')                            
                                        ->get();
        $count = count($friends);        
        if($count < 1)
        {
            return response()->json([ 'status' => "fail", 'message' => 'no record found' ]);
        }else{
            event_track_from_fx_hlpr($post_id = $request->user_id, $user_id = $request->user_id, $event_type = 'listFriends_for_'.$request->user_id);

            return response()->json([ 'status' => "success", 'data' => $friends ]);
        }
    }

    public function sendSms(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender_id' => ['required','numeric','gt:0'],
            'receiver_id' => ['required','numeric','gt:0'],
            'message' => ['required','string'],
        ]);
        if ($validator->fails()) {
            return response()->json( [ 'status' => 'error', 'error' => $validator->errors() ]);
        }

        $sender   = Friend::where( ['id' => $request->sender_id ])->first();
        $receiver = Friend::where(['id' => $request->receiver_id])->first();
        if(empty($sender) || empty($receiver))
        {
            return response()->json([ 'status' => 'fail', 'message' => 'sender or receiver ID not exist' ]);
        }

        $status = 'fail'; $message = null;

        $message = new FriendSms();
        $message->sender_id = $request->sender_id;
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;
        $msg = $message->save();
        if($msg){
            event_track_from_fx_hlpr($post_id = $message->id, $user_id = $request->sender_id, $event_type = 'msg_sent_to_'.$request->receiver_id);
            $status = 'success'; $message = 'message send successfully';
        }
        return response()->json([ 'status' => $status, 'message' => $message ]);
        
    }

    public function showSms(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender_id' => ['required','numeric','gt:0'],
            'receiver_id' => ['required','numeric','gt:0']
        ]);
        if ($validator->fails()) {
            return response()->json( [ 'status' => 'error', 'error' => $validator->errors() ]);
        }
        $messages = FriendSms::WhereIn('sender_id',[$request->sender_id, $request->receiver_id])
                                ->WhereIn('receiver_id',[$request->sender_id, $request->receiver_id])->get();
        $count = count($messages);
        if($count < 1)
        {
            return response()->json([ 'status' => "fail", 'message' => 'no record found' ]);
        }else{
            // event_track_from_fx_hlpr($post_id = null, $user_id = $request->sender_id, $event_type = 'showSms_to_'.$request->sender_id);
            return response()->json([ 'status' => "success", 'data' => $messages ]);
        }
    }

    public function userPaidByPost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required','numeric','gt:0'],
            'post_id' => ['required','numeric','gt:0'],
            'paid' => ['required','numeric']
        ]);
        if ($validator->fails()) {
            return response()->json( [ 'status' => 'error', 'error' => $validator->errors() ]);
        }
        $statuss = 'fail'; $message = null;
        // print_r($request->paid);

        $userPostEarn = new UserPostEarn();
        $userPostEarn->user_id = $request->user_id;
        $userPostEarn->user_type = $request->user_type;
        $userPostEarn->post_id = $request->post_id;
        $userPostEarn->post_type = $request->post_type;
        $userPostEarn->paid = $request->paid;
        $userPostEarn->device_type = $request->device_type;
        $userPostEarn->device_os = $request->device_os;
        $upe = $userPostEarn->save();
        // echo $userPostEarn->paid;exit;
        if($upe)
        {
            user_earning_hlpr($user_id=$request->user_id,$transaction=$request->paid,$device=$request->device_type);
            event_track_from_fx_hlpr($post_id = $userPostEarn->id, $user_id = $request->user_id, $event_type = 'user_earn_Rs_'.$userPostEarn->paid, $device_type = $request->device_type);
            $status = 'success'; $message = "User earn Rs $request->paid ";
        }
        return response()->json([ 'status' => "success", 'data' => $message ]);
    }

    public function userEarning(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required','numeric','gt:0'],
            'transaction' => ['required','numeric'],   //current_transaction
            
        ]);
        if ($validator->fails()) {
            return response()->json( [ 'status' => 'error', 'error' => $validator->errors() ]);
        }
        $statuss = 'fail'; $message = null;

        $def_val = '';
        $userearn = UserEarning::where('user_id', $request->user_id)->first();
        if(!$userearn){
            $def_val = 3;
        }        
       
        // $userearn->last_transaction;exit;

        $userEarnig = UserEarning::updateorCreate(
            [
                'user_id' => $request->user_id,
            ],
            [
                'current_transaction' => $request->transaction,
                'current_amount' => $def_val == 3 ? $request->transaction : $userearn->current_amount + $request->transaction,
                'previous_amount' => $def_val == 3 ? $request->transaction : $userearn->current_amount,
                'last_transaction' => $def_val == 3 ? 0 : $userearn->current_transaction
            ]
        );
        if($userEarnig)
        {
            event_track_from_fx_hlpr($post_id = $userEarnig->id, $user_id = $request->user_id, $event_type = 'user_earn_Rs_'.$request->transaction, $device_type = 'app');
            $status = 'success'; $message = "User Transaction done $request->transaction ";
        }
        return response()->json([ 'status' => "success", 'data' => $message ]);

    }

    public function showWallet($user_id)
    {
        $show_wallet = UserEarning::where('user_id',$user_id)->get();

        return response()->json([ 'status' => "success", 'amount' => $show_wallet ]);
    }

    //statue = 2 is by default , 1 for pending && 0 for clear
    public function withDrawRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required','numeric','gt:0'],
            'request_amount' => ['required','numeric','gt:0'],   //current_transaction
            'withDrawBy' => ['required'],
            
        ]);
        if ($validator->fails()) {
            return response()->json( [ 'status' => 'error', 'error' => $validator->errors() ]);
        }

        $user_id = $request->user_id;
        $request_amount = $request->request_amount;
        $withDrawBy = $request->withDrawBy; // by load,EPaisy , to game account

        $show_wallet = UserEarning::where('user_id',$user_id)->first();
        $current_amount = $show_wallet->current_amount;

        if($request_amount > $current_amount)
        {
         return response()->json( [ 'status' => 'fail', 'message' => 'withDraw Amount Must be less than Current Amount' ]);   
        }        
        $old_with_draw_amount = 0;
        $with_draw = $with_draw_check = WithDraw::where(['user_id' => $user_id , 'status' => '2'])->first();        
        
        if(empty($with_draw_check)){
           $old_with_draw_amount = 0;
            $with_draw = new WithDraw();
        }else{
            $old_with_draw_amount = $with_draw->with_draw_amount;
        }
        // echo $old_with_draw_amount;
        // exit;
        $with_draw->user_id = $user_id;
        $with_draw->with_draw_amount = $request->request_amount + $old_with_draw_amount;
        $with_draw->with_draw_by = $request->withDrawBy;

        //update userEarning
        $show_wallet->current_amount = $current_amount - $request->request_amount;
        $show_wallet->previous_amount = $current_amount;                
        $show_wallet->current_transaction = '-' . $request_amount;
        $show_wallet->last_transaction = $show_wallet->current_transaction;
        $show_wallet->save();

        $with_draw->save();
        event_track_from_fx_hlpr($post_id = $with_draw->id, $user_id = $user_id, $event_type = 'withDraw_request_amount_is_'.$request->request_amount, $device_type = 'app');

        return response()->json([ 'status' => "success", 'message' => 'WithDraw Request Submited succesfully' ]);

    }




}
