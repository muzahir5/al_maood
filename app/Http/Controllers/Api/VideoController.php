<?php

namespace App\Http\Controllers\Api;

use File;
use Image;
use Carbon\Carbon;
use App\Model\Video;
use Illuminate\Http\Request;
use App\Model\Admin\Categories;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function videoCreate(Request $request)
    {
		$validator = Validator::make($request->all(), [
                        'title' 	=> 'required|string',
                        'video_url' => 'required|string',
                        'category' 	=> ['required','numeric'],
                        'language' 	=> ['required','numeric'],          
            			'user_id' 	=> ['required','numeric','gt:0'],
            			'video_img' => 'nullable | string | max:255',
                    ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'error' => $validator->errors()
                ], 200);
        }

        $video = new Video();
        $video->upload_by_id    = $request->user_id;
        $video->title           = $request->title;
        $video->description     = $request->description;
        $video->category        = $request->category;
        $video->language        = $request->language;
        $video->location        = $request->location;
        $video->narrator        = $request->narrator;
        $video->video_url       = $request->video_url;
        $video->video_img           = $request->video_img;
        $video->upload_by       = 'admin';

        $video = $video->save();

        return response()->json([ 'status' => true, 'message' => 'Video Added Successfully' ]);

    }
}