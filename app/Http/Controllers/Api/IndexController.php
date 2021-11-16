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

class IndexController extends Controller
{
    public function listAudioByNarrator($narrator_id='')
    {
        $categories = Categories::all();
        $query = Audio::select('id','title','description','narrator','language','upload_by','category','audio_url','audio_img','view_by','show_to')
                    ->Where('narrator', $narrator_id)->where('status',1)->orderBy('view_by','DESC');
        
        $audios = $query->get();

        $list_narrator = DB::table('narrators')
                ->join('audio', 'narrators.id', '=', 'audio.narrator')            
                ->select('narrators.id','narrators.name')->distinct()->where('narrators.status',1)
                ->get();

        return response()->json([            
            'status' => "success",
            'base_path' => base_path().'/',
            'audios' => $audios,
            'list_narrator' => $list_narrator
        ]);
    }
}
