@extends('layouts.default')

@section('content')

    <h2>Update User</h2>

    <form method="POST" action="{{ url('/admin/updateUser')}} " enctype="multipart/form-data">        
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="hidden" class="form-control" id="id" name="id" value="{{ $user->id }}">
            <input type="text" class="form-control" id="name" name="name" value="{{ (old('name'))? old('name') : $user->name}}">
             {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="text" readonly class="form-control" id="email" name="email" value="{{ (old('poet'))? old('email') : $user->email}}">
             {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="mobile_number">Mobile Number:</label>
            <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{ (old('narramobile_numbertor'))? old('mobile_number') : $user->mobile_number}}">
             {!! $errors->first('mobile_number', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" class="form-control" id="country" name="country" value="{{ (old('country'))? old('country') : $user->country}}">
             {!! $errors->first('country', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" id="city" name="city" value="{{ (old('city'))? old('city') : $user->city}}">
             {!! $errors->first('city', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="village">Village</label>
            <input type="text" class="form-control" id="village" name="village" value="{{ (old('village'))? old('village') : $user->village}}">
             {!! $errors->first('village', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="mobile_network">Mobile Network</label>
            <input type="text" class="form-control" id="mobile_network" name="mobile_network" value="{{ (old('mobile_network'))? old('mobile_network') : $user->mobile_network}}">
             {!! $errors->first('mobile_network', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="mp3_file">mp3 file:</label>
            <input type="file" class="form-control" id="mp3_file" name="mp3_file" value="{{ old('mp3_file')}}">
             {!! $errors->first('mp3_file', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="row" style="border: 1px dotted orange;padding: 5px;border-radius: 23px;">
            <div class="form-group col-6">
                <label for="img_upload_text_link">Image:</label>
                <input type="file" class="form-control" id="img_upload_text_link" name="img_upload_text_link" value="{{ old('img_upload_text_link')}}">
                {!! $errors->first('img_upload_text_link', '<p class="text-danger">:message</p>') !!}
            </div>
            <div class="form-group col-6">            
            <img src="{{ asset('public/audio/images/'.$user->audio_img) }} " alt="Product_image_url" style="max-width: 150px;">                
            </div>
        </div>

        <div class="form-group">
            <label for="pdf_upload_text_link">pdf_upload_text_link:</label>
            <input type="file" class="form-control" id="pdf_upload_text_link" name="pdf_upload_text_link" value="{{ old('pdf_upload_text_link')}}">
             {!! $errors->first('pdf_upload_text_link', '<p class="text-danger">:message</p>') !!}
        </div>

        
        <div class="form-group">
            <button style="cursor:pointer" type="submit" class="btn btn-primary">Update Audio</button>
        </div>
    </form>
@endsection 