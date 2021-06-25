@extends('layouts.default')

@section('title', 'Products')

@section('content')

    <h2>Products  
    	<span style="float: right;"><a href="{{ url('admin/addProduct') }}">Add Product</a>  </span>
    </h2>
    @if($products)
    	@foreach($products as $product)
            <div class="col-sm-3">
		<div class="thumb-wrapper">
                    <a href="{{ url('/admin/editProduct', $product->id)}}">
                        <div class="img-box">
                                <img src="{{ asset('public/uploads/products/thumbnail/'.$product->image_url) }} " alt="Product_image_url" style="max-width: 250px;max-height: 350px;">
                        </div>
                        <div class="thumb-content">
                                <h4>{{$product->name}}</h4>
                                <p class="item-price"><strike>{{$product->price}}</strike> <span>{{$product->sale_price}}</span></p>
                                <p class="item-price"><b>Category : </b> 
                                    <span>
                                        @foreach($categories as $category)
                                            @if($category->id == $product->category_id)
                                                {{$category->name}}
                                            @endif
                                        @endforeach
            
            </span></p>
                                <!-- <a href="#" class="btn btn-primary">Add to Cart</a> -->
                        </div>
                    </a>
		</div>
            </div>
    	@endforeach
    @endif  

@endsection 
 
 

