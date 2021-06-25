@extends('layouts.default')

@section('title', 'Audios')

@section('content')

    <h2>Audio
    	<span style="float: right;"><a href="{{ url('admin/addAudio') }}">Add Audio</a>  </span>
    </h2>
    
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Id#</th>
                  <th scope="col">Title</th>
                  <th scope="col">Status</th>
                  <th scope="col">Uploaded by</th>                  
                  <th scope="col">Category</th>
                  <th scope="col">View By</th>
                  <th scope="col">Action</th>
                  <th scope="col">Item</th>
                </tr>
              </thead>
              <tbody>
              @if($audios)
              @foreach($audios as $audio)
                <tr>
                  <th scope="row">{{$audio->id}}</th>
                  <td>{{$audio->title}}</td>
                  <td>{{$audio->status}}</td>
                  <td>{{$audio->upload_by}}</td>                  
                  <td>
                    @foreach($categories as $cat)
                      @if($cat->id == $audio->category)
                        {{$cat->name}}
                      @endif
                    @endforeach
                  </td>
                  <td>{{$audio->view_by}}</td>                  
                  <td><a href="{{url('admin/editAudio' ,$audio->id )}} ">Edit</a> |Delete</td>
                  <td>
                    <!-- {{$audio->audio_url}} -->
                    <audio controls="" style="vertical-align: middle" src="{{ asset($audio->audio_url) }} " type="audio/mp3" controlslist="nodownload">
                  </td>
                </tr>  
                
        @endforeach
    @endif              
              </tbody>
            </table>
   

@endsection 
 
 

