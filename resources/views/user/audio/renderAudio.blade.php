@extends('user.layouts.default')

@section('title', 'User !')

@section('content')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> Add Audio</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-4">

                            <h2>{{$category->name}} 5<span name="cate_id" id="cate_id" style="display: none;">{{$cat_id}}</span></h2>
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
                                                <img src="http://localhost/al-maood/public/audio/images/{{$audio->audio_img}}" alt="audio img" style="border-radius: 14px; width: 72px;float: left;margin-right: 5px;">
                                                <h4 class="list-group-item-heading">{{$audio->title}}  </h4>
                                                <p class="list-group-item-text">{{$category->name}}
                                                <i class="fas fa-play list_play_<?php echo $i;?>" onclick="playaudio(<?php echo $i;?> , {{$audio->id}} )" style="float: right;"></i> </p>
                                            </span> 
                                        </div>
                                        </td>
                                    </tr>
                                    <?php $i++?>
                                    @endforeach
                                @endif 
                                </tbody>
                            </table>

                        <!-- Ends Row & col -->
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

@endsection

@section('footer-js-content')

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
                    var html = []; var current = 0;
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
        } // End load js song arr by cat_id


        $(document).on('click', 'li', function(){        
            var value = $(this).text();
            $('#country').val(value);
            $('#country_list').html("");
        });
        // songs.push('Willy');     // console.log(songs);        
    });
    
    function playaudio(audio_index, audio_id)
        {
            songIndex = audio_index;
            loadSong(audio_index);
            playSong();

            $("#data_tbl tbody").on("click", "tr", function(){
                // console.log(audio_index +' id ');
                // console.log('audio_id ' + audio_id );
            });
        }
        
</script>
@endsection