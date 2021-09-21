@extends('user.layouts.default')
@section('title', 'Audios')
@section('content')
    <h2>{{$category->name}}</h2>
    <div class="col-lg-6">	    
	    <div class="form-group">
	        <label>Type a name</label>
	        <input type="text" name="audio" id="audioo" placeholder="Enter audio name" class="form-control">
	        <input type="hidden" name="cate_id" id="cate_id" value="{{$cat_id}}" class="form-control">
	    </div>
	    <div id="country_list">
	    	<ul> <li></li> </ul>
	    </div>                    
	</div> 
	    @if($audios)
	    	<div class="list-group def_audios">
                <?php $i = 0?>
	    	@foreach($audios as $audio)
			    <span class="list-group-item list_audio"style="margin: 1px;">
			      <h4 class="list-group-item-heading">{{$audio->title}}</h4>
			      <p class="list-group-item-text">{{$category->name}}
			      	<i class="fas fa-play list_play" onclick="playaudio(<?php echo $i;?>)" style="float: right;"></i> </p>
			    </span>   		
    			<?php $i++?>
	    	@endforeach
	    	</div>
	    @endif
@endsection

@include('dashboard.includes.foot')

<script type="text/javascript">
    $(document).ready(function () {

    	//load js song arr by cat_id
    	var cate_id = $('#cate_id').val();

    	if(cate_id > 0){
    		// console.log(cate_id);
    		$.ajax({               
                url:"{{ route('user.listAudioByCatagoryId') }}" + '/'+ + cate_id,
                type:"GET",               
                // data:{'cate_id':cate_id},
                success:function (data) {
                    // console.log(data);
                    JSON.stringify(data); //to string
                    var html = [];
                    $.each(data.audios, function(audio) {
                   	 // console.log(data.audios[audio]);
				        songsTitle.push(data.audios[audio].title);
				        songsImage.push(data.audios[audio].audio_img);
				        songsSrc.push(data.audios[audio].audio_url);
				    });
                }
            });
    	}

    	

    	$('#country_list').css('display','none');     
        $('#audioo').on('keyup',function() {
            var query = $(this).val();
            var cat_id = $('#cate_id').val();
            $('#country_list').html('');

            if( query.length > 2) {
            	// console.log(query.length);
            $.ajax({               
                url:"{{ route('user.listAudio') }}" + '/'+ query +'/'+ cat_id,
                type:"GET",               
                //data:{'searching_word':query,'cat_id':cat_id},
                success:function (data) {
                	console.log(data);
                	JSON.stringify(data); //to string
                    var html = [];
                    $.each(data.audios, function(audio) {
                   	 // console.log(data.audios[audio]);
                        html +='<li><span title="'+ data.audios[audio].title +'" target="_blank">'+ data.audios[audio].title + ' <i class="fas fa-play list_play" onclick="playaudio('+data.audios[audio].id+')" style="float: right;"></i> </span></li>';
                        songsTitle.push(data.audios[audio].title);
                        songsImage.push(data.audios[audio].audio_img);
                        songsSrc.push(data.audios[audio].audio_url);

                        
				    });

                    
                    if(!Array.isArray(data.audios) || !data.audios.length ){
                            $('.def_audios').css('display','');
                            console.log(3);
                        }else{                            
                            $('.def_audios').css('display','none');
                            console.log(5);
                        }

                   	$('#country_list').css('display','block');
			        $('#country_list').html(html);

                    //console.log(songsTitle);	console.log(songsImage);	console.log(songsSrc);

			        // console.log(html);
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

        // songs.push('Willy');
        // console.log(songs);
    });

    function playaudio(audio_index)
    {
        // console.log(audio_index);    console.log(songsImage[audio_index]);   console.log(songsSrc[audio_index]);
        loadSong(audio_index);
        playSong();
    }
</script>