<?php

namespace App\Http\Controllers\Api;

use Auth;
use File;
use Image;
use Session;
use Carbon\Carbon;
use App\Model\Video;
use App\Model\User\User;
use App\Model\Admin\Audio;
use App\Model\Admin\Surah;
use App\Model\User\Friend;
use Illuminate\Http\Request;
use App\Model\User\WithDraw;
use App\Model\User\SharePost;
use App\Model\Admin\language;
use App\Model\User\FriendSms;
use App\Model\Admin\Narrator;
use App\Model\RequestTracking;
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
    public function get_quarani_surah($surah_id)
    {
        echo 'All Surah Are Already Saved, Please Contact to Team :- Al-Maood, Thanks';
        exit;
        for ($i=1; $i < 115 ; $i++) {
            $url = 'https://quranenc.com/api/v1/translation/sura/english_saheeh/'.$i; //$surah_id;
            // phpinfo();exit; 
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response_json = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response_json, true);
            foreach ($response as $surah) {
                foreach ($surah as $sur) {

                    $surah = new Surah();
                    $surah->surah_number = $sur['sura'];
                    $surah->aya_number = $sur['aya'];
                    $surah->arabic_text = $sur['arabic_text'];
                    $surah->translation = $sur['translation'];
                    $surah->footnotes = $sur['footnotes'];
                    $surah->status = 1;

                    $surah->save();
                }
            }
        }

        return response()->json(
            [
                'status' => 'success', //'surah_id' => $surah->id,
                'message' => "Surah has been Added successfully," ]
            );
    }
    public function renderIndexScreen(Request $request)
    {
        $today      = $request->today;
        $country    = $request->country;
        $user_id    = $request->user_id;
        $device_id  = $request->device_id;
        $device_os  = $request->device_os;

        if($user_id || $country){
            $request_tracking = new RequestTracking();
            
            $request_tracking->day          = $today;
            $request_tracking->country      = $country;
            $request_tracking->user_id      = $user_id;
            $request_tracking->device_os    = $device_os;
            $request_tracking->device_id    = $device_id;
            $request_tracking->created_at   = date('Y-m-d h:i:s');
            $request_tracking->action       = 'app_loaded';

            $request_tracking->save();
        }


        $today_dua = DB::table('audio')->select('id','title','audio_url','audio_img') //,'dod'
                            ->where(['status' => 1, 'category' => 2])->where('dod', 'like', '%'.$today.'%')->get();

        $languages = DB::table('languages')->select('id','name')->get();
        $locations = DB::table('locations')->select('id','name')->get();
        // $languages = language::select('id','name')->get();

        $narrators = DB::table('narrators')
            ->join('audio', 'narrators.id', '=', 'audio.narrator')
            ->select('narrators.id','narrators.name','narrators.profile_pic','narrators.user_type', DB::raw('count(*) as total_audio'))
            ->where('narrators.status',1)->groupBy('narrators.id')->get();

        $audio_categories = DB::table('categories')//->distinct()
                ->join('audio', 'categories.id', '=', 'audio.category')
                ->select('categories.id','categories.name','categories.list_switcher','categories.category_img', DB::raw('count(audio.id) as total_audio'))
                ->where('categories.status',1)->where('categories.category_type','audio')->where('audio.status',1)
                ->groupBy('categories.id')->get();

        $video_categories = DB::table('categories')
                ->join('videos', 'categories.id', '=', 'videos.category')
                ->select('categories.id','categories.name','categories.list_switcher','categories.category_img', DB::raw('count(videos.id) as count'))
                ->where('categories.status',1)->where('categories.category_type','video')
                ->groupBy('categories.id')->get();
        $public_path = public_path();
        
        $settings = DB::table('settings')->select('id','name','value')
                            ->where(['status' => 1 , 'type' => 'app'])->get();
        return response()->json(
            [
                'status'            => 'success',
                'settings'          => $settings,
                'today_duas'        => $today_dua,
                'narrators'         => $narrators,
                'languages'         => $languages,
                'locations'         => $locations,
                'audio_categories'  => $audio_categories,
                'videos_catagories' => $video_categories,
                'recently'          => null,
                'most_played'       => null,
                'files_path'        => 'http://139.59.33.123:8000/',
                'downloadable_files_catagories' => null
            ]
        );
    }
    public function getSurah($surah_number)
    {
        $status = 'success';
        $surah  = null;
        $bismillah = Surah::where('id',1)->first();

        $surah = Surah::where('surah_number',$surah_number)->where('status',1)->where('id','!=',1)->get();

        if(count($surah) < 1){
            $status = 'fail';
            $surah  = null;
        }

        return response()->json([            
            'status' => $status,
            'bismillah' => $bismillah->arabic_text,
            'data' => $surah
        ]);
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
    public function listVideoByCatagory($categ_id,$lang='')
    {
        $categories = Categories::all();
        $query = Video::select('id','title','language','location','category','video_url','video_img','view_by','narrator','pdf_upload_text_link as pdf_link')
                    ->Where('category', $categ_id)->where('status',1)->orderBy('view_by','DESC');
        
        if($lang != ''){
            //search in Category
            $query->where(function ($query) use ($lang) {
                        $query->orWhere('language',$lang);
                });
        }
        $videos = $query->get();

        if ($categ_id == 8) { //only for JamaY
                $switcher =DB::table('videos as v')->leftJoin('locations as loc', 'v.location', '=', 'loc.id')
                            ->where('v.category',$categ_id)
                            ->select('v.location as id','loc.name',DB::raw('count(v.id) as count'))
                            ->groupBy('v.location')->get();
                $switcher_type = 'location';
        }else{
                $switcher =  DB::table('videos as v')->leftJoin('languages as l', 'v.language', '=', 'l.id')
                            ->where('v.category',$categ_id)
                            ->select('v.language as id','l.name',DB::raw('count(v.id) as count')) //,DB::raw('"flat" as str')
                            ->groupBy('v.language')->get();
                $switcher_type = 'language';
        }

        return response()->json([
            'status' => "success",
            'files_path' => 'http://139.59.33.123:8000/',
            'videos' => $videos,
            'switcher' => $switcher,
            'switcher_type' => $switcher_type
        ]);
    }
}
