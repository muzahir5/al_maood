@extends('user.layouts.default')

@section('title', 'User Index')

@section('content')

    <!-- <div class="row">
	    <div class="col-lg-6">	    
		    <div class="form-group">
		        <label>Type a name</label>
		        <input type="text" name="audio" id="audioo" placeholder="Enter audio name" class="form-control">
		    </div>
		    <div id="country_list">
		    	<ul> <li></li> </ul>
		    </div>                    
		</div>
	</div> -->
	    @if($categories)
	    	@foreach($categories as $category)    		
	    		<!-- <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3"> -->
					<div class="thumb-wrapper col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
						<a href="{{ url('/user/listAudioByCatagory', $category->id)}}">
							<div class="img-box">
								<img src="{{ asset('public/categories/'.$category->category_img) }} " alt="Category_image_url" style="max-width: 250px;max-height: 350px;">
							</div>
							<div class="thumb-content">
								<h4>{{$category->name}}</h4>
								<p class="item-price"><strike>{{$category->id}}</strike> <span>{{$category->category_type}}</span></p>
							</div>
						</a>
					</div>
				<!-- </div> -->
	    	@endforeach
	    @endif

@endsection

@include('dashboard.includes.foot')

<script type="text/javascript">
    $(document).ready(function () {
    	
	   // Search	

		// $('#country_list').css('display','none');
     
        // $('#audioo').on('keyup',function() {
        //     var query = $(this).val();
        //     var cat_id = '';
        //     $('#country_list').html('');

        //     if( query.length > 2) {
        //     	// console.log(query.length);
        //     $.ajax({               
        //         url:"{{ route('user.listAudio') }}" + '/'+query +'/'+ cat_id,
        //         type:"GET",               
        //         //data:{'searching_word':query,'cat_id':cat_id},
        //         success:function (data) {
        //         	// console.log(data);
        //         	JSON.stringify(data); //to string
        //             var html = [];
        //             $.each(data.audios, function(audio) {
        //            	 // console.log(data.audios[audio]);
		// 		        html +='<li><a href="'+ data.audios[audio].audio_url +'" title="'+ data.audios[audio].title +'" target="_blank">'+ data.audios[audio].title +'</a></li>';
		// 		    });
        //            	$('#country_list').css('display','block');
		// 	        $('#country_list').html(html);
		// 	        console.log(html);
        //         }
        //     })
        //     }// end of ajax call
        //     if( query.length < 3) {
        //     	$('#country_list').css('display','none');
        //     }
        // });
        
        // $(document).on('click', 'li', function(){
          
        //     var value = $(this).text();
        //     $('#country').val(value);
        //     $('#country_list').html("");
        // });

	  // End Search
    });
</script>