<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Dashboard\CustomPostTracking as PostTracking;
use Auth;

class CustomPostTracking extends Controller
{
    public function __construct() {
        // $this->middleware('auth:admin');
    }
    
    public function postTracking(Request $request){
//      echo '<pre>';print_r($request->event_type);

        $user_id = NULL;
        if($request->user_id > 0){
            $user_id = $request->user_id;
        }else{
            $user_id = Auth::guard('user')->id();
        }
                
        $post_tracking = new PostTracking();
        
        $post_tracking->post_id = $request->post_id ;
        $post_tracking->user_id = $user_id ;
        $post_tracking->language = $request->language ;
        $post_tracking->device_type = $request->device_type ;
        $post_tracking->event_type = $request->event_type ;
        
        $post_tracking->save();        
        
        return response()->json([
            'status' => '200',
            'message' => 'post tracked successfully'
        ]);

    }
}
