@extends('layouts.default')

@section('content')

    <h2>Edit Product</h2>

    <form method="POST" action="{{ url('/admin/updateProduct')}} " enctype="multipart/form-data">
      @foreach($product as $product)
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="hidden" class="form-control" id="id" name="id" value="{{ $product->id }}">
            <input type="text" class="form-control" id="name" name="name" value="{{ (old('name'))? old('name') : $product->name }}">
             {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="sku">SKU:</label>
            <input type="text" class="form-control" id="sku" name="sku" value="{{ (old('sku'))? old('sku') : $product->sku}}">
             {!! $errors->first('sku', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text"class="form-control"id="description"name="description"value="{{(old('description'))?old('description'): $product->description}}">
             {!! $errors->first('description', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="text" class="form-control" id="quantity" name="quantity" value="{{ (old('quantity')) ? old('quantity') : $product->quantity}}">
             {!! $errors->first('quantity', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
        	<label for="quantity">Select Category:</label>
            <select class="form-select" name="category[]" id="category" multiple aria-label="multiple select example">
            <option value="">Select Category</option>
            @foreach($categories as $category)
            	
	            @foreach($product_categories as $categ)	            
	            	 <?php $selected = ''; if ($category->id == $categ->category_id) { $selected = 'selected="selected"'; } ?>
	            @endforeach
	                  <option value="{{$category->id}}" <?= $selected; ?> > {{$category->name}} </option>                              	            
            @endforeach            
        </select>
        {!! $errors->first('category', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
        	<label for="Available-at">Aviable At :  </label>
            
            @foreach($product_availables as $product_available)
            
	            <div class="form-check form-check-inline">
	              <input class="form-check-input" type="checkbox" id="available" name="available[]" value="breakfast" 
	              		{{ $product_available->available_at == 'breakfast' ? 'checked' : null }} />
	              <label class="form-check-label" for="inlineCheckbox1">Breakfast</label>
	            </div>
	            <div class="form-check form-check-inline">
	              <input class="form-check-input" type="checkbox" id="available" name="available[]" value="lunch" 
	              		{{ $product_available->available_at == 'lunch' ? 'checked' : null }} />
	              <label class="form-check-label" for="inlineCheckbox2">Lunch</label>
	            </div>
	            <div class="form-check form-check-inline">
	              <input class="form-check-input" type="checkbox" id="available" name="available[]" value="dinner" 
	              		{{ $product_available->available_at == 'dinner' ? 'checked' : null }} />
	              <label class="form-check-label" for="inlineCheckbox1">Dinner</label>
	            </div>
	         
	            
	        @endforeach
            {!! $errors->first('available', '<p class="text-danger">:message</p>') !!}
        </div>
        
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" class="form-control" id="price" name="price" value="{{ (old('price')) ? old('price') : $product->price}}">
             {!! $errors->first('price', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="sale_price">Sale Price:</label>
            <input type="text" class="form-control" id="sale_price" name="sale_price" value="{{ (old('sale_price')) ? old('sale_price') : $product->sale_price}}">
             {!! $errors->first('sale_price', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group">
            <label for="product_image">Product Image: </label>
            <img class="profile-logo img img-thumbnail" src="{{ asset('public/uploads/products/thumbnail/'.$product_images[0]->image_url) }}" />
            <input type="file" class="form-control" id="product_image" name="product_image" value="{{ old('product_image')}}">
             {!! $errors->first('product_image', '<p class="text-danger">:message</p>') !!}
        </div>
        
        <div class="form-group">
            <label for="mp3_file">mp3 file:</label>
            <input type="file" class="form-control" id="mp3_file" name="mp3_file" value="{{ old('mp3_file')}}">
             {!! $errors->first('mp3_file', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group" style="display: -webkit-inline-box;">
            <label for="status">Status: </label>            
            <input type="radio" class="form-control" name="status" value="1" {{ ($product->status == 1) ? 'checked' : ''}} >
            <input type="radio" class="form-control" name="status" value="0" {{ ($product->status == 0) ? 'checked' : '' }}>
        </div> <br>

        <div class="form-group" style="display: -webkit-inline-box;">
            <label for="isFeature">Is Feature:</label>            
            <input type="radio" class="form-control" name="isfeature" value="1" {{ ($product->featured == 1) ? 'checked' : ''}}>
  			<input type="radio" class="form-control" name="isfeature" value="0" {{ ($product->featured == 0) ? 'checked' : ''}}>
        </div> <br>
        
        <div class="form-group" style="display: -webkit-inline-box;">
            <label for="isFeature">Post Type:</label>            
                Post <input type="radio" class="form-control" name="product_type" value="1">
                Link <input type="radio" class="form-control" name="product_type" value="2">
                MP3 <input type="radio" class="form-control" name="product_type" value="3">
                <span> {!! $errors->first('product_type', '<p class="text-danger">:message</p>') !!} </span>
        </div>

        <div class="form-group">
            <button style="cursor:pointer" type="submit" class="btn btn-primary">Update Product</button>
        </div>
       @endforeach
    </form>


@endsection 
 
 
