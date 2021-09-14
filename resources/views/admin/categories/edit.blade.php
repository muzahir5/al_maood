@extends('layouts.default')

@section('content')

    <h2>Edit Category</h2>

    <form method="POST" action="{{ url('/admin/updateCategory')}} " enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" class="form-control" id="id" name="id" value="{{ $category->id }}">
        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
             {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group" style="display: -webkit-inline-box;">
            <label for="status">Status:</label>            
            Active<input type="radio" class="form-control" name="status" value="1" {{ ($category->status=="1")? "checked" : "" }}>
            DeActive<input type="radio" class="form-control" name="status" value="0" {{ ($category->status=="0")? "checked" : "" }}>
        </div>

        <div class="" style="border: 1px dotted orange;padding: 5px;border-radius: 23px;">
            <div class="form-group col-6">
                <label for="category_img">Image:</label>
                <input type="file" class="form-control" id="category_img" name="category_img" value="{{ old('category_img')}}">
                {!! $errors->first('category_img', '<p class="text-danger">:message</p>') !!}
            </div>
            <div class="form-group col-6">            
            <img src="{{ asset('public/categories/'.$category->category_img) }} " alt="Product_image_url" style="max-width: 150px;">                
            </div>
        </div>

        <div class="form-group">
            <button style="cursor:pointer" type="submit" class="btn btn-primary">Update Category</button>
        </div>
    </form>


@endsection
 
 
