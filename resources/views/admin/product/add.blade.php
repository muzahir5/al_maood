@extends('layouts.default')

@section('content')

    <h2>Add Product</h2>

    <form method="POST" action="{{ url('/admin/addProduct')}} " enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}">
             {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="sku">SKU:</label>
            <input type="text" class="form-control" id="sku" name="sku" value="{{ old('sku')}}">
             {!! $errors->first('sku', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" class="form-control" id="description" name="description" value="{{ old('description')}}">
             {!! $errors->first('description', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="text" class="form-control" id="quantity" name="quantity" value="{{ old('quantity')}}">
             {!! $errors->first('quantity', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <select class="form-select" name="category[]" id="category" multiple aria-label="multiple select example">
            <option value="">Select Category</option>
            @foreach($categories as $category)                  
                  <option value="{{$category->id}} "> {{$category->name}} </option>                              
            @endforeach            
        </select>
        {!! $errors->first('category', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="Available-at">Available At :  </label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="available" name="available[]" value="breakfast">
              <label class="form-check-label" for="inlineCheckbox1">Breakfast</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="available" name="available[]" value="lunch">
              <label class="form-check-label" for="inlineCheckbox2">Lunch</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="available" name="available[]" value="dinner">
              <label class="form-check-label" for="inlineCheckbox1">Dinner</label>
            </div>
            {!! $errors->first('available', '<p class="text-danger">:message</p>') !!}
        </div>
        
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price" name="price" value="{{ old('price')}}">
             {!! $errors->first('price', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="sale_price">Sale Price:</label>
            <input type="text" class="form-control" id="sale_price" name="sale_price" value="{{ old('sale_price')}}">
             {!! $errors->first('sale_price', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="product_image">Product Image:</label>
            <input type="file" class="form-control" id="product_image" name="product_image" value="{{ old('product_image')}}">
             {!! $errors->first('product_image', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="mp3_file">mp3 file:</label>
            <input type="file" class="form-control" id="mp3_file" name="mp3_file" value="{{ old('mp3_file')}}">
             {!! $errors->first('mp3_file', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group" style="display: -webkit-inline-box;">
            <label for="status">Status:</label>            
            <input type="radio" class="form-control" name="status" value="1" checked>
            <input type="radio" class="form-control" name="status" value="0">
        </div> <br>

        <div class="form-group" style="display: -webkit-inline-box;">
            <label for="isFeature">Is Feature:</label>            
            <input type="radio" class="form-control" name="isfeature" value="1" checked>
  			<input type="radio" class="form-control" name="isfeature" value="0">
        </div> <br>
        
        <div class="form-group" style="display: -webkit-inline-box;">
            <label for="isFeature">Post Type:</label>            
                Post <input type="radio" class="form-control" name="product_type" value="1">
                Link <input type="radio" class="form-control" name="product_type" value="2">
                MP3 <input type="radio" class="form-control" name="product_type" value="3">
                <span> {!! $errors->first('product_type', '<p class="text-danger">:message</p>') !!} </span>
        </div>

        <div class="form-group">
            <button style="cursor:pointer" type="submit" class="btn btn-primary">Add Product</button>
        </div>
    </form>


@endsection 
 
 
