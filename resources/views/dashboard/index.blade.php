@extends('dashboard.layouts.default')

@section('title', 'Index')

@section('content')

    <h2>Products</h2>
    @if($products)
    	@foreach($products as $product)
    		<div class="col-sm-3">
							<div class="thumb-wrapper">
								<a href="{{ url('/index/productDetail', $product->id)}}">
									<div class="img-box">
										<img src="{{ asset('public/uploads/products/thumbnail/'.$product->image_url) }} " alt="Product_image_url" style="max-width: 250px;max-height: 350px;">
									</div>
									<div class="thumb-content">
										<h4>{{$product->name}}</h4>
										<p class="item-price"><strike>{{$product->price}}</strike> <span>{{$product->sale_price}}</span></p>
										<div class="star-rating">
											<ul class="list-inline">
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star"></i></li>
												<li class="list-inline-item"><i class="fa fa-star-o"></i></li>
											</ul>
										</div>
										<!-- <a href="#" class="btn btn-primary">Add to Cart</a> -->
									</div>
								</a>
							</div>
						</div>
    	@endforeach
    @endif
@endsection