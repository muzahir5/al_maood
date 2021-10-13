var home = {    
    audio_list: function(searchInCat,cat_name){    	
    	var param = [];
        var url = 'user/listAudioByCatagory/'+searchInCat;
        mainView.router.loadPage('templates/audio_list.html');
        // core.log('Error: ' + url);
        core.getRequest(url,param, function (response, status) {
        	
            if (status === 'success') {
                var result = response;                     
                if (result.status === 'success') {
                var audios = result.audios;
                $('.block-title').append(cat_name);
                var current = 0;
                $.each(audios,function(key,value){
                    // core.log(result.base_path);
                    var id = value.id; var audio_url = "'http://localhost/al-maood/"+ value.audio_url+"'";
                    var audio_img = "http://localhost/al-maood/public/audio/images/"+ value.audio_img; var title = "'"+value.title+"'";
                    // core.log(audio_url);

                    var html = '<tr id="'+current+'"> <td>'+
                                '<div class="list-group def_audios"> <span class="list-group-item list_audio"style="">'+
                                '<img src="'+audio_img+'" alt="img" style="width:80px;float:left;margin-right:3%;border:1px dotted orange;margin:5px;">'+
                                '<span><h4 class="list-group-item-heading">'+value.title+'</h4>'+
                                '<p class="list-group-item-text">'+value.description+'<i class="fas fa-play list_play_11" onclick="home.playaudio('+current+' ,'+value.id+')" style="float: right;"></i> </p>'+
                                '</span> </span> </div> </td>  </tr>';

                                songs.push(current);
                                songsTitle.push(value.title);
                                songsImage.push(value.audio_img);
                                songsSrc.push(value.audio_url);
                                
                                current++;
                    $('.render_music').append(html);
                });
                // console.log(songs);console.log(songsTitle);console.log(songsImage);console.log(songsSrc);
                }
            }
            setTimeout(function(){     
                $('#data_tbl').DataTable( {
                    "pagingType": "full_numbers",
                    "pageLength": 50
                } );    
             }, 2000);
        });
	},
    playaudio: function(audio_index, audio_id)
        {
            songIndex = audio_index;
            loadSong(audio_index);
            playSong();
            $("#data_tbl tbody").on("click", "tr", function(){
                // console.log(audio_index +' id ');
                // console.log('audio_id ' + audio_id );
            });
        },
    categories_list: function(){	
    	var param = [];
        var url = 'user/getCategories/';
        // mainView.router.loadPage('templates/audio_list.html');
        // core.log('Error: ' + url);
        core.getRequest(url,param, function (response, status) {
        	
            if (status === 'success') {
                var result = response;                     
                if (result.status === 'success') {
                var categories = result.categories;
                // core.log(categories);
                var current = 1;
                $.each(categories,function(key,value){
                    // core.log(result.base_path);
                    var id = value.id; var cat_name = "'"+ value.name +"'"; var category_img = value.category_img;
                    // core.log(id);                    
                    if(current < 3){
                        var html = ' <div class="col">'+
                                '<a onclick="home.audio_list('+id+','+cat_name+')" class="elevation-demo elevation-12" href="#">'+
                                '<img src="http://localhost/al-maood/public/categories/'+category_img+'" alt="Avatar" width="80px">'+
                                '<p>'+ cat_name+' <i class="pe-7s-music"></i></p></a></div>';                    

                        $('.no-gap').append(html);
                    }
                    if(current > 2 && current < 5){
                        var html2 = ' <div class="col">'+
                                '<a onclick="home.audio_list('+id+','+cat_name+')" class="elevation-demo elevation-12" href="#">'+
                                '<img src="http://localhost/al-maood/public/categories/'+category_img+'" alt="Avatar" width="80px">'+
                                '<p>'+ cat_name+' <i class="pe-7s-music"></i></p></a></div>';
                        $('.no-gap2').append(html2);
                    }
                    current++;
                });
                }
            }
        });
	},
    render_page: function(page_name){
        // alert(page_name);
        mainView.router.loadPage('templates/'+page_name);
    },
    load_audio_play: function(id,audio_url,audio_img,title){
        // core.log('id is '+audio_url);
        core.log('img is '+audio_img+'title is '+title);
        $("#audio").attr("src",audio_url);
        $("#cover").attr("src",audio_img);
        $("#title").html(title);

    // overflow: unset;
    // position: fixed;
    // bottom: 0em;
        $('#music-container').css({'display':'flex','overflow':'unset','position':'fixed','bottom':'0em'})
        playSong();

    }
}