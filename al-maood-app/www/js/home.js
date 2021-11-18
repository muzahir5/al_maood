var home = {    
    render_index_screen: function(to_day){
        var param = [];
        var url = 'user/renderIndexScreen/'+to_day;
        // mainView.router.loadPage('templates/audio_list.html');
        // core.log('Error: ' + url);
        core.getRequest(url,param, function (response, status) {
            
            if (status === 'success') {
                var result = response;                     
                if (result.status === 'success') {
                    var categories = result.categories;
                    var languages = result.languages;
                    var narrators = result.narrators;
                    $.each(languages, function (index, value) {
                        languages_arr.push({id:value.id, name:value.name});
                    });
                    $.each(narrators, function (index, value) {
                        narrators_arr.push({id:value.id, name:value.name, profile_pic:value.profile_pic});
                    });
                    
                    // core.log(narrators_arr);
                    var current = 1;
                    $.each(narrators_arr,function(key,value){
                        // core.log(result.base_path);
                        var id = value.id; var profile_pic = value.profile_pic; var narator_name = "'"+ value.name +"'";
                        var narr_swiper = ' <div class="col">'+
                        '<a onclick="home.audio_list_by_narrator('+id+','+narator_name+')" class="list_cat_home" href="#">'+
                        '<img src="http://localhost/al-maood/public/narrators/'+profile_pic+'" alt="Narrator Avatar" width="80px" height="80px">'+
                        '<b>'+ value.name+' </b></a></div>';
                        $('.no-gap-narrators').append(narr_swiper);
                        current++;
                    });

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
        core.getRequest(url,param, function (response, status) {            
            if (status === 'success') {
                var result = response;                     
                if (result.status === 'success') {
                    var narrators = result.narrators;
                    var current = 1;
                    $.each(narrators,function(key,value){
                        // core.log(result.base_path);
                        var id = value.id; var profile_pic = value.profile_pic; var narator_name = "'"+ value.name +"'";
                        var narr_swiper = ' <div class="col">'+
                        '<a onclick="home.audio_list_by_narrator('+id+','+narator_name+')" class="list_cat_home" href="#">'+
                        '<img src="http://localhost/al-maood/public/narrators/'+profile_pic+'" alt="Narrator Avatar" width="80px" height="80px">'+
                        '<b>'+ value.name+' </b></a></div>';
                        $('.no-gap-narrators').append(narr_swiper);
                        current++;
                    });
                }
            }
        });
    },audios_arrays_rendering : function(cat_name,audios_all,audiosTitle_all,audiosImage_all,audiosSrc_all){
        var current = 0;
        $("#data_tbl").dataTable().fnDestroy();     //to sovel the dataTable reinitialise error/warning
        $('.block-title').html(''); $('.render_music').html(''); //$('.append_render_chips').html('');
        $.each(languages_arr,function(key,value){
            $.each(audiosAvaInLang_all,function(key,lang_id){
                // var lang_id = list_lang_value.language_id;
                // console.log('vId ='+ value.id +' && lang_id = '+lang_id);
                if(value.id == lang_id){
                    var searchInCat = 3;
                    var lang_chips = '<div class="chip" onclick="home.audio_list('+searchInCat+','+cat_name+','+lang_id+')">'+value.name+'</div>';
                    // $('.append_render_chips').html('');
                    $('.append_render_chips').append(lang_chips);
                }
            });
            
        });
        $.each(audios_all,function(key,value){
            // core.log(songsTitle_all);
            var id = value.id; var audio_url = "'http://localhost/al-maood/"+ value.audio_url+"'";
            var audio_img = "http://localhost/al-maood/public/audio/images/"+ audiosImage_all[current]; 
            var title = "'"+audiosTitle_all[current]+"'";
            var html = '<tr id="'+current+'"> <td>'+
                        '<div class="list-group def_audios"> <span class="list-group-item list_audio"style="">'+
                        '<img src="'+audio_img+'" alt="img" style="width:80px;float:left;margin-right:3%;border:1px dotted orange;margin:5px;">'+
                        '<span><h4 class="list-group-item-heading">'+audiosTitle_all[current]+'</h4>'+
                        '<p class="list-group-item-text">'+value.description+'<i class="fas fa-play list_play_'+current+'" onclick="home.playaudio('+current+' ,'+current+')" style="float: right;"></i> <i class="fas fa-pause fam-pause fam-pause_'+current+'" style="margin-right:5px; float: right;"></i> </p>'+
                        '</span> </span> </div> </td>  </tr>';
            current++;
            $('.render_music').append(html);    var aAIlL = audiosAvaInLang_all.length; var aAIlL_count = 0;
            
            
        });
    },audio_list: function(searchInCat,cat_name,lang_id=''){
        var param = [];        
        var url = 'user/listAudioByCatagory/'+searchInCat+'/'+lang_id;
        mainView.router.loadPage('templates/audio_list.html');

        if(searchInCat == 3 & audiosTitle_all.length > 0){    //for all nohay & all
            console.log("songsTitle_all Array is Not empty!");  //console.log(songsTitle_all); console.log(songs_all);            
            home.audios_arrays_rendering(cat_name,audios_all,audiosTitle_all,audiosImage_all,audiosSrc_all);
            console.log('langg ' + audiosAvaInLang_all);

        }else{
            console.log("languages_arr Array is Empty!");
            // core.log('Error: ' + url);
            core.getRequest(url,param, function (response, status) {
                
                if (status === 'success') {
                    var result = response;
                    // core.log(result);
                    if (result.status === 'success') {
                        $("#data_tbl").dataTable().fnDestroy();     //to sovel the dataTable reinitialise error/warning
                        var audios = result.audios;
                        $('.block-title').html('');$('.append_render_chips').html(''); $('.render_music').html('');
                        
                        $('.block-title').append(cat_name); var catag_name = "'" + cat_name +"'";
                        $.each(languages_arr,function(key,value){
                            var list_lang = result.list_lang;       //from server
                            $.each(list_lang,function(key,list_lang_value){
                                var lang_id = list_lang_value.language_id;
                                            
                                if(!audiosAvaInLang_all.includes(lang_id)){
                                    console.log(lang_id + ' added in audiosAvaInLang_all');
                                    audiosAvaInLang_all.push(lang_id);
                                } 
                                if(value.id == lang_id){
                                    var lang_chips = '<div class="chip" onclick="home.audio_list('+searchInCat+','+catag_name+','+lang_id+')">'+value.name+'</div>';
                                    $('.append_render_chips').append(lang_chips);
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
                                        '<p class="list-group-item-text">'+value.description+'<i class="fas fa-play list_play_'+current+'" onclick="home.playaudio('+current+' ,'+value.id+')" style="float: right;"></i> <i class="fas fa-pause fam-pause fam-pause_'+current+'" style="margin-right:5px; float: right;"></i> </p>'+
                                        '</span> </span> </div> </td>  </tr>';

                                        if(searchInCat == 3){    //for all nohay & all
                                            audios_all.push(current);
                                            audiosTitle_all.push(value.title);
                                            audiosImage_all.push(value.audio_img);
                                            audiosSrc_all.push(value.audio_url);                                
                                            current++;
                                        }else{
                                            songs.push(current);
                                            songsTitle.push(value.title);
                                            songsImage.push(value.audio_img);
                                            songsSrc.push(value.audio_url);                                
                                            current++;
                                        }
                            $('.render_music').append(html);
                        });
                        // core.log(languages_arr);
                        // console.log(songs);console.log(songsTitle);console.log(songsImage);console.log(songsSrc);
                    }
                }
                /*setTimeout(function(){
                    $('#data_tbl').DataTable( {
                        "pagingType": "full_numbers",
                        "pageLength": 50
                    } );    
                }, 2000);*/
            });

        }
        setTimeout(function(){                           

            $('#data_tbl').DataTable( {
                "pagingType": "full_numbers",
                "pageLength": 50
            } );    
        }, 2000);
        
	},
    audio_list_by_narrator: function(narrator_id,narrator_name){
    	var param = [];
        
        var tab_name = 'audio'; var col_name = 'narrator'; var where_value = narrator_id;
        var url = 'user/dynamicSearch/'+ tab_name +'/'+ col_name +'/'+ where_value;
        mainView.router.loadPage('templates/audio_list.html');
        // core.log('Error: ' + url);
        core.getRequest(url,param, function (response, status) {
        	
            if (status === 'success') {
                var result = response;
                core.log(result);
                if (result.status === 'success') {
                    // core.log('786 ');
                    $("#data_tbl").dataTable().fnDestroy();     //to sovel the dataTable reinitialise error/warning
                    var audios = result.results;
                    $('.block-title').html('');$('.append_render_chips').html(''); $('.render_music').html('');
                    
                    $('.block-title').append(narrator_name); //var catag_name = "'" + cat_name +"'";
                    
                    
                    $.each(narrators_arr,function(key,value){
                        
var render_chips = '<div class="chip" onclick="home.audio_list_by_narrator('+narrator_id+','+narrator_name+')">'+value.name+'</div>';
                                $('.append_render_chips').append(render_chips);

                    });
                    
                    
                    var current = 0;
                    $.each(audios,function(key,value){
                        // core.log(result);
                        var id = value.id; var audio_url = "'http://localhost/al-maood/"+ value.audio_url+"'";
                        var audio_img = "http://localhost/al-maood/public/audio/images/"+ value.audio_img; var title = "'"+value.title+"'";
                        var html = '<tr id="'+current+'"> <td>'+
                                    '<div class="list-group def_audios"> <span class="list-group-item list_audio"style="">'+
                                    '<img src="'+audio_img+'" alt="img" style="width:80px;float:left;margin-right:3%;border:1px dotted orange;margin:5px;">'+
                                    '<span><h4 class="list-group-item-heading">'+value.title+'</h4>'+
                                    '<p class="list-group-item-text">'+value.description+'<i class="fas fa-play list_play_'+current+'" onclick="home.playaudio('+current+' ,'+value.id+')" style="float: right;"></i> <i class="fas fa-pause fam-pause fam-pause_'+current+'" style="margin-right:5px; float: right;"></i></p>'+
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