<?php

namespace App\Http\Controllers\Admin;

use Auth;
use File;
use Image;
use Session;
use Carbon\Carbon;
use App\Model\Admin\Audio;
use Illuminate\Http\Request;
use App\Model\Admin\Language;
use App\Model\Admin\Categories;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
	public function __construct() {
        $this->middleware('auth:admin');
    }

	Public function index(){  

		$admin_id = Auth::user()->id;

		$categories = Categories::all();
        $audios = Audio::all();
        $activeAudioCount = Audio::where('status',1)->count();
        $unActiveAudioCount = Audio::where('status',0)->count();
        $deletedAudioCount = Audio::where('status',3)->count();

		return view('admin.dashboard', compact('audios','categories','activeAudioCount','unActiveAudioCount','deletedAudioCount'));
    }
}
