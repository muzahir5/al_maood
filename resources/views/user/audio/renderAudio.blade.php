@extends('user.layouts.default')
@section('title', 'Audios')
@section('content')
    <h2>{{$category->name}} <span name="cate_id" id="cate_id" style="display: none;">{{$cat_id}}</span></h2>
    <!-- <div class="col-lg-6">	    
	    <div class="form-group">
	        <label>Type a name</label>
	        <input type="text" name="audio" id="audioo" placeholder="Enter audio name" class="form-control">
	        <input type="hidden" name="cate_id" id="cate_id" value="{{$cat_id}}" class="form-control">
	    </div>
	    <div id="country_list">
	    	<ul> <li></li> </ul>
	    </div>                    
	</div>  -->
	    	<table id="data_tbl" class="display" style="width:100%">
                <thead>
                    <tr>
                    <th scope="col"></th>
                    </tr>
                    </thead>
                <tbody>
                  @if($audios)
                  <?php $i = 0?>
                    @foreach($audios as $audio)
                      <tr id="{{$i}}">
                        <td>
                        <div class="list-group def_audios">
                            <span class="list-group-item list_audio"style="margin: 1px;">
                                <h4 class="list-group-item-heading">{{$audio->title}}  </h4>
                                <p class="list-group-item-text">{{$category->name}}
                                <i class="fas fa-play list_play" onclick="playaudio(<?php echo $i;?>)" style="float: right;"></i> </p>
                            </span> 
                        </div>
                        </td>
                      </tr>
                      <?php $i++?>
                      @endforeach
                  @endif 
                </tbody>
            </table>
@endsection

@include('dashboard.includes.foot')

<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>

<script type="text/javascript">
    $(document).ready(function () {

        $('#data_tbl').DataTable( {
                "pagingType": "full_numbers",
                "pageLength": 50
            } );                    

    	//load js song arr by cat_id
    	var cate_id = $('#cate_id').text();

    	if(cate_id > 0){
    		console.log(cate_id);
    		$.ajax({               
                url:"{{ route('user.listAudioByCatagoryId') }}" + '/'+ + cate_id,
                type:"GET",               
                // data:{'cate_id':cate_id},
                success:function (data) {
                    // console.log(data);
                    JSON.stringify(data); //to string
                    var html = [];
                    var current = 0;
                    $.each(data.audios, function(audio) {
                   	 // console.log(data.audios[audio]);
                        songs.push(current);
				        songsTitle.push(data.audios[audio].title);
				        songsImage.push(data.audios[audio].audio_img);
				        songsSrc.push(data.audios[audio].audio_url);

                        current++;        
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
        songIndex = audio_index;
        loadSong(audio_index);
        playSong();

        $("#data_tbl tbody").on("click", "tr", function(){
        // console.log(audio_index +' id ');        
        

    });
    }
</script>