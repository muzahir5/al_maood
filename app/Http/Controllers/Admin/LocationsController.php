<?php

namespace App\Http\Controllers\Admin;

use Image;
use File;
use Illuminate\Http\Request;
use App\Model\Location;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LocationsController extends Controller
{
	public function __construct(){
    	$this->middleware('auth:admin');
    }

    public function index()
    {
    	$locations = DB::table('locations')->get();
    	// echo '<pre>';print_r($locations);exit;
    	return view('admin.locations.index', compact('locations'));
    }

    public function create(){
    	return view('admin.locations.add');
    }

    public function save(Request $request){
        
        $this->validate($request, [
            'name'          => 'required | string | max:255',
        ]);

        $Location = new Location();

        $Location->name     = $request->name;
        $Location->status   = $request->status;

        $Location->save();

        return redirect()->to('/admin/locations');
    }

    public function edit($id){
        $location = location::find($id);
        // echo $location->name;
        return view('admin.locations.edit')->with('location',$location);
    }

    public function update(Request $request){
        $this->validate($request, [
            'name' => 'required | string | max:255',
        ]);

        $category = DB::table('locations')->where('id',$request->id)->
                    update([
                        'name'          => $request->name,
                        'status'        => $request->status,
                        'updated_at'    => date('y-m-d h-i-s') ]
                    );
        return redirect()->to('/admin/locations');
    }

}
