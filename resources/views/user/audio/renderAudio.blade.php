@extends('user.layouts.default')

@section('title', 'Audios')

@section('content')

    <h2>Categories 5</h2>
    <div class="col-lg-6">	    
	    <div class="form-group">
	        <label>Type a name</label>
	        <input type="text" name="audio" id="audio" placeholder="Enter audio name" class="form-control">
	        <input type="hidden" name="cate_id" id="cate_id" value="{{$cat_id}}" class="form-control">
	    </div>
	    <div id="country_list">
	    	<ul> <li></li> </ul>
	    </div>                    
	</div> 

	    @if($audios)
	    	<ul>
	    	@foreach($audios as $audio)    		
    			<li class="list-group-item">{{$audio->title}}</li>	    
	    	@endforeach
	    	</ul>
	    @endif	
@endsection

@include('dashboard.includes.foot')

<script type="text/javascript">
    $(document).ready(function () {
    	$('#country_list').css('display','none');
     
        $('#audio').on('keyup',function() {
            var query = $(this).val();
            var cat_id = $('#cate_id').val();
            $('#country_list').html('');

            if( query.length > 2) {
            	// console.log(query.length);
            $.ajax({               
                url:"{{ route('user.listAudio') }}" + '/'+query +'/'+ cat_id,
                type:"GET",               
                //data:{'searching_word':query,'cat_id':cat_id},
                success:function (data) {
                	// console.log(data);
                	JSON.stringify(data); //to string
                    var html = [];
                    $.each(data.audios, function(audio) {
                   	 // console.log(data.audios[audio]);
				        html +='<li><a href="'+ data.audios[audio].audio_url +'" title="'+ data.audios[audio].title +'" target="_blank">'+ data.audios[audio].title +'</a></li>';
				    });
                   	$('#country_list').css('display','block');
			        $('#country_list').html(html);
			        console.log(html);
                }
            })
            }// end of ajax call
            if( query.length < 3) {
            	$('#country_list').css('display','none');
            }
        });
        
        $(document).on('click', 'li', function(){
          
            var value = $(this).text();
            $('#country').val(value);
            $('#country_list').html("");
        });
    });
</script>