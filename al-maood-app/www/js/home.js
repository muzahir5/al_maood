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
    },audios_arrays_rendering : function(searchInCat,cat_name,lang_id){
        var current = 0;                
        $("#data_tbl").dataTable().fnDestroy();     //to sovel the dataTable reinitialise error/warning
        $('.block-title').html('');  $('.render_music').html('');  //$('.append_render_chips').html('');

// nohay_all.push({id:value.id,title:value.title,audio_img:value.audio_img,audio_url:value.audio_url,category:value.category,language:value.language});
            if(searchInCat == 3){
                all = nohay_all;
            }
          for (var i = 0; i < all.length; i++){
            var audio_id = all[i].id; var cat_id = all[i].category;
            var audio_img = "http://localhost/al-maood/public/audio/images/"+ nohay_all[i].audio_img;

                if(lang_id){
                    if (lang_id > 0 && lang_id == all[i].language){
                        core.log('IF , lang_id = ' + lang_id );
                            var html = '<tr id="'+i+'"> <td>'+
                                '<div class="list-group def_audios"> <span class="list-group-item list_audio"style="">'+
                                '<img src="'+audio_img+'" alt="img" style="width:80px;float:left;margin-right:3%;border:1px dotted orange;margin:5px;">'+
                                '<span><h4 class="list-group-item-heading">'+all[i].title+'</h4>'+
                                '<p class="list-group-item-text">'+i+'<i class="fas fa-play list_play_'+i+'" onclick="home.playaudio('+i+' ,'+audio_id+','+cat_id+')" style="float: right;"></i>'+
                                '<i class="fas fa-pause fam-pause fam-pause_'+i+'" style="margin-right:5px; float: right;"></i> </p>'+
                                '</span> </span> </div> </td>  </tr>';
                                $('.render_music').append(html);
                    }
                }else {
                        core.log('Else , lang_id = ' + lang_id );
                            var html = '<tr id="'+i+'"> <td>'+
                                '<div class="list-group def_audios"> <span class="list-group-item list_audio"style="">'+
                                '<img src="'+audio_img+'" alt="img" style="width:80px;float:left;margin-right:3%;border:1px dotted orange;margin:5px;">'+
                                '<span><h4 class="list-group-item-heading">'+all[i].title+'</h4>'+
                                '<p class="list-group-item-text">'+i+'<i class="fas fa-play list_play_'+i+'" onclick="home.playaudio('+i+' ,'+audio_id+','+cat_id+')" style="float: right;"></i>'+
                                '<i class="fas fa-pause fam-pause fam-pause_'+i+'" style="margin-right:5px; float: right;"></i> </p>'+
                                '</span> </span> </div> </td>  </tr>';
                                $('.render_music').append(html);
                }
                current++;

                $('.append_render_chips').html('');
                for (let i = 0; i < languages_arr.length; i++) {
                    $.each(nohay_languages,function(key,lang_id){
                        if(languages_arr[i].id == lang_id){
                            var catag_name = "'" + cat_name +"'";
                            var lang_chips = '<div class="chip" onclick="home.audio_list('+searchInCat+','+catag_name+','+lang_id+')">'+languages_arr[i].name+'</div>';
                            $('.append_render_chips').append(lang_chips);
                        }
                    });
                  }
          }
        
    },audio_list: function(searchInCat,cat_name,lang_id=''){
        var param = []; var InterVal;
        var url = 'user/listAudioByCatagory/'+searchInCat+'/'+lang_id;
        mainView.router.loadPage('templates/audio_list.html');

        if(searchInCat == 3 & nohay_all.length > 0){    //for all nohay & all
            console.log("nohay_all Array is Not empty!");
            home.audios_arrays_rendering(searchInCat,cat_name,lang_id);
            InterVal = 10;
        }else{ InterVal = 2000;
            console.log("languages_arr Array is Empty!");
            core.getRequest(url,param, function (response, status) {                
                if (status === 'success') {
                    var result = response;   // core.log(result);
                    if (result.status === 'success') {
                        $("#data_tbl").dataTable().fnDestroy();     //to sovel the dataTable reinitialise error/warning
                        var audios = result.audios;
                        $('.block-title').html('');$('.append_render_chips').html(''); $('.render_music').html('');
                        $('.block-title').append(cat_name);

                        var current = 0;
                        $.each(audios,function(key,value){
                            // core.log(value);
                            var id = value.id; var cat_id = "'"+value.category+"'";
                            var audio_img = "http://localhost/al-maood/public/audio/images/"+ value.audio_img; 
                            var html = '<tr id="'+current+'"> <td>'+
                                        '<div class="list-group def_audios"> <span class="list-group-item list_audio"style="">'+
                                        '<img src="'+audio_img+'" alt="img" style="width:80px;float:left;margin-right:3%;border:1px dotted orange;margin:5px;">'+
                                        '<span><h4 class="list-group-item-heading">'+value.title+'</h4>'+
                                        '<p class="list-group-item-text">'+value.id+
                                        '<i class="fas fa-play list_play_'+current+'" onclick="home.playaudio('+current+' ,'+id+','+cat_id+')" style="float: right;"></i>'+
                                        '<i class="fas fa-pause fam-pause fam-pause_'+current+'" style="margin-right:5px; float: right;"></i> </p>'+
                                        '</span> </span> </div> </td>  </tr>';

                                        if(searchInCat == 1){ //for all Quran
                                            languages_arr.push({id:value.id, name:value.name});
                    quran_all.push({nohay_id:value.id,nohay_title:value.title,nohay_audio_img:value.audio_img,nohay_audio_url:value.audio_url,nohay_category:value.category,nohay_language:value.language});
                                            current++;
                                        }else if(searchInCat == 3){ //for all nohay & all
                                            languages_arr.push({id:value.id, name:value.name});
// nohay_all.push({nohay_id:value.id,nohay_title:value.title,nohay_audio_img:value.audio_img,nohay_audio_url:value.audio_url,nohay_category:value.category,nohay_language:value.language});
nohay_all.push({id:value.id,title:value.title,audio_img:value.audio_img,audio_url:value.audio_url,category:value.category,language:value.language});
                                            current++;
                                        }else{
                                            songs.push(current);
                                            songsTitle.push(value.title);
                                            songsImage.push(value.audio_img);
                                            songsSrc.push(value.audio_url);                                
                                            current++;
                                        }
                            $('.render_music').append(html);
                            // core.log('ff '+ nohay_all[0].nohay_id);
                        });
                        var catag_name = "'" + cat_name +"'";
                        $.each(languages_arr,function(key,value){
                            var list_lang = result.list_lang;       //from server
                            $.each(list_lang,function(key,list_lang_value){
                                var lang_id = list_lang_value.language_id;
                                if(!nohay_languages.includes(lang_id)){   nohay_languages.push(lang_id);    }
                                if(value.id == lang_id){
            var lang_chips = '<div class="chip" onclick="home.audio_list('+searchInCat+','+catag_name+','+lang_id+')">'+value.name+'</div>';
                                    $('.append_render_chips').append(lang_chips);
                                }
                            });
                        });
                    }
                }
            });

        }
        setTimeout(function(){
            $('#data_tbl').DataTable( {
                "pagingType": "full_numbers",
                "pageLength": 50
            } ); //core.log('InterVal = '+ InterVal )
        }, InterVal);
        
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
    playaudio: function(audio_index, audio_id, category_id = 0)
    {
        songIndex = audio_index;
        if(category_id == 3){ core.log('playaudio if & cat_id = '+ category_id);// for nohay 
            loadSong(audio_index, category_id);
            carrent_load_categ = category_id;
        }else{
            core.log('playaudio else');
            loadSong(audio_index);
            carrent_load_categ = 0;
        }
        
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