@extends('dashboard.layouts.default')

@section('title', 'Product Detail')

@section('content')

    <h2>Product Detail</h2>
    @if($product)
    	<!--@foreach($product as $product)-->
    		<div class="col-sm-4 text-center">
                    <div class="thumb-wrapper">
                        <a href="#">
                            <div class="img-box">
                                <img src="{{ asset('public/uploads/products/thumbnail/'.$product->image_url) }} " alt="Product_image_url" style="max-width: 250px;max-height: 350px;">
                            </div>
                            <div class="thumb-content">
                                <h4>{{$product->name}}</h4>
                                <p class="item-price"><strike>{{$product->price}}</strike> <span>{{$product->sale_price}}</span></p>
                                                                            
                                <!-- <a href="#" class="btn btn-primary">Add to Cart</a> -->
                            </div>
                        </a>
                    </div>
                </div>
        
                <div class="col-sm-4">
                    <div class="card border-primary mb-3" style=";">
                    <div class="card-header">Product Datails</div>
                    <div class="card-body text-primary">
                      <h5 class="card-title">Name :{{$product->name}}</h5>
                      <p class="card-text">Price : {{$product->price}}</p>
                      <p class="card-text">Sale Price : {{$product->sale_price}}</p>
                      <p class="card-text">Quantity: {{$product->quantity}}</p>
                      <p class="card-text">Weight : {{$product->weight}}</p>

                      <audio controls="" style="vertical-align: middle" src="{{ asset($product->media_file_url) }} " type="audio/mp3" controlslist="nodownload">
                        Your browser does not support the audio element.
                     </audio>
                      
                    </div>
                  </div>
                </div>
    	<!--@endforeach-->
    @endif
@endsection

<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->

@include('dashboard.includes.foot')

<script stype="text/javascript">
    
    $(document).ready(function() {
     // executes when HTML-Document is loaded and DOM is ready
          
      postTracking();
     
    });
    
    function postTracking(){
        
        var product_id = '  <?php echo $product->id; ?>  ';
        var user_id = '  <?php //echo Auth::guard('user')->id(); ?>  ';
        var language = '  <?php echo 'en'; ?>  ';
        var device_type = '  <?php echo 'web'; ?>  ';
        var event_type = '  <?php echo 'post_view'; ?>  ';
        
//      console.log('product_id is = '+ event_type);        

        var url = "{{ url('index/postTracking') }}";
        $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  }
        });
        $.ajax({
            url : url,
            type : 'POST',
            data:{post_id:product_id,user_id:user_id,language:language,device_type,event_type},
            success: function(data){
                console.log(data);
            },
        });
    }
    
</script>
