@extends('layouts.default')

@section('content')

    <h2>Add Category</h2>

    <form method="POST" action="{{ url('/admin/addCategory')}} " enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}">
             {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group" style="display: -webkit-inline-box;">
            <label for="status">Status:</label>            
            Active<input type="radio" class="form-control" name="status" value="1" checked>
            DeActive<input type="radio" class="form-control" name="status" value="0">
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" class="form-control" id="category_img" name="category_img" value="{{ old('category_img')}}">
             {!! $errors->first('category_img', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <button style="cursor:pointer" type="submit" class="btn btn-primary">Add Category</button>
        </div>
    </form>


@endsection 
 
 
