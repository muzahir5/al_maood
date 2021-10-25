var home = {    
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
                    var languages = result.languages;                    
                    $.each(languages, function (index, value) {
                        languages_arr.push({id:value.id, name:value.name});
                    });
                    // core.log(categories);
                    var current = 1;                    
                    $.each(categories,function(key,value){
                        // core.log(result.base_path);
                        var id = value.id; var cat_name = "'"+ value.name +"'"; var category_img = value.category_img;
                        var html = ' <div class="col">'+
                                '<a onclick="home.audio_list('+id+','+cat_name+')" class="list_cat_home" href="#">'+
                                '<img src="http://localhost/al-maood/public/categories/'+category_img+'" alt="Avatar" width="80px" height="80px">'+
                                '<b>'+ value.name+' </b></a></div>';
                        $('.no-gap').append(html);
                        current++;
                    });
                }
            }
        });
    },
    narrators_list: function(){
        var param = [];
        var url = 'user/getNarrators/';
        // mainView.router.loadPage('templates/audio_list.html');
        // core.log('Error: ' + url);
        core.getRequest(url,param, function (response, status) {
            
            if (status === 'success') {
                var result = response;                     
                if (result.status === 'success') {
                    var narrators = result.narrators;
                    // core.log(narrators);
                    var current = 1;
                    $.each(narrators,function(key,value){
                        // core.log(result.base_path);
                        var id = value.id; var narr_name = "'"+ value.name +"'"; var profile_pic = value.profile_pic;
                        var narr_swiper = '<div class="swiper-slide"> '+ 
                        '<img src="http://localhost/al-maood/public/narrators/'+profile_pic+'" alt="Avatar" width="80px" height="80px" style="margin-left: 12%;">' +
                                            value.name +  '</div>';
                        $('.swiper-wrapper').append(narr_swiper);
                        current++;
                    });
                }
            }
        });
    },
    audio_list: function(searchInCat,cat_name,lang_id=''){
    	var param = [];
        var url = 'user/listAudioByCatagory/'+searchInCat+'/'+lang_id;
        mainView.router.loadPage('templates/audio_list.html');
        // core.log('Error: ' + url);
        core.getRequest(url,param, function (response, status) {
        	
            if (status === 'success') {
                var result = response;
                // core.log(result);
                if (result.status === 'success') {
                    $("#data_tbl").dataTable().fnDestroy();     //to sovel the dataTable reinitialise error/warning
                    var audios = result.audios;
                    $('.block-title').html('');$('.append_lang_chips').html(''); $('.render_music').html('');
                    
                    $('.block-title').append(cat_name); var catag_name = "'" + cat_name +"'";
                    $.each(languages_arr,function(key,value){
                        var list_lang = result.list_lang;       //from server
                        $.each(list_lang,function(key,list_lang_value){
                            var lang_id = list_lang_value.language_id;
                            if(value.id == lang_id){
                                var lang_chips = '<div class="chip" onclick="home.audio_list('+searchInCat+','+catag_name+','+lang_id+')">'+value.name+'</div>';
                                $('.append_lang_chips').append(lang_chips);
                            }
                        });
                    });

                    var current = 0;
                    $.each(audios,function(key,value){
                        // core.log(result.base_path);
                        var id = value.id; var audio_url = "'http://localhost/al-maood/"+ value.audio_url+"'";
                        var audio_img = "http://localhost/al-maood/public/audio/images/"+ value.audio_img; var title = "'"+value.title+"'";
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
                    // core.log(languages_arr);
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
    },
    hide_player: function(){
        $('.music-container').css('display','none');
    },
    show_player: function(){
        $('.music-container').css('display','flex');
    }
}