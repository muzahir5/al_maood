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
    public function renderIndexScreen(Request $request)
    {
        $today  = $request->today;
        $country= $request->country;
        $user_id  = $request->user_id;
        $device_id = $request->device_id;
        $device_os = $request->device_os;

        $categories = DB::table('categories')->distinct()
                ->join('audio', 'categories.id', '=', 'audio.category')->where('categories.status',1)
                ->select('categories.id','categories.name','categories.category_img')->get();
        // $languages = language::select('id','name')->get();
        $languages = DB::table('languages')->select('id','name')->get();

        $narrators = DB::table('narrators')
            ->join('audio', 'narrators.id', '=', 'audio.narrator')
            ->select('narrators.id','narrators.name','narrators.profile_pic','narrators.user_type', DB::raw('count(*) as total_audio'))
            ->where('narrators.status',1)->groupBy('narrators.id')->get();
        
        $today_dua = DB::table('audio')->select('id','title','audio_url','audio_img')
                            ->where(['status' => 1 , 'type' => 'dua' , 'category' => 2])->get();
        $public_path = public_path();
        
        return response()->json(
            [
                'status' => 'success',
                // 'public_path' => $public_path,
                'today_duas' => $today_dua,
                'categories' => $categories,
                'narrators' => $narrators,
                'languages' => $languages,
                'recently' => null,
                'most_played' => null,
                'videos_catagories' => null
            ]
        );
    }

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
