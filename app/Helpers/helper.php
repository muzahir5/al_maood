<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Model\Dashboard\CustomPostTracking as PostTracking;
use App\Model\User\UserEarning;

function event_track_from_fx_hlpr($post_id=null, $user_id=null, $event_type=null, $device_type = null)
    {
        // print_r($post_type);exit; 
        $post_tracking = new PostTracking();        
        $post_tracking->post_id = $post_id;
        $post_tracking->user_id = $user_id;
        $post_tracking->device_type = $device_type;
        $post_tracking->event_type = $event_type ;     //list,view/play,download,gift,add/rm fav ,friend_request_to_              
        $post_tracking->save();
    }

function user_earning_hlpr($user_id=null,$transaction=null,$device=null)
    {
        $status = 'fail'; $message = null;
        $def_val = '';
        $userearn = UserEarning::where('user_id', $user_id)->first();
        if(!$userearn){
            $def_val = 3;
        }       
        // $userearn->last_transaction;exit;

        $userEarnig = UserEarning::updateorCreate(
            [
                'user_id' => $user_id,
            ],
            [
                'current_transaction' => $transaction,
                'current_amount' => $def_val == 3 ? $transaction : $userearn->current_amount + $transaction,
                'previous_amount' => $def_val == 3 ? $transaction : $userearn->current_amount,
                'last_transaction' => $def_val == 3 ? 0 : $userearn->current_transaction
            ]
        );
        if($userEarnig)
        {
            event_track_from_fx_hlpr($post_id = $userEarnig->id, $user_id = $user_id, $event_type = 'user_earn_Rs_'.$transaction, $device_type = 'app');
            $status = 'success'; $message = "User Transaction ";
        }
        return response()->json([ 'status' => "success", 'data' => $message ]);

    }