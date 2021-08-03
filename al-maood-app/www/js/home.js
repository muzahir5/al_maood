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
                $.each(audios,function(key,value){
                    // core.log(result.base_path);
                    var id = value.id; var audio_url = "'http://localhost/al-maood/"+ value.audio_url+"'";
                    var audio_img = "'http://localhost/al-maood/public/"+ value.audio_img+"'"; var title = "'"+value.title+"'";
                    // core.log(audio_url);
                    var html = '<li style="border: 1px dashed orange;list-style: none; border-radius: 7px;">'+                            
                            '<a href="#" id='+id+' class="item-link item-content">'+
                                '<div class="item-media"><img src='+audio_img+' style="border: 1px dotted orange;" width="80" /></div>'+
                                    '<div class="item-inner" style="">'+
                                    '<div class="item-title-row">'+
                                        '<div class="item-title">'+value.title+'</div>'+
                                        '<div class="item-after">'+value.upload_by+'</div>'+
                                    '</div>'+
                           '<div class="item-subtitle">'+value.narrator +
        '<i class="fas fa-play" onclick="home.load_audio_play('+id+','+audio_url+','+audio_img+','+title+');" id="audio_'+value.id+'"></i> </div>'+
                        '<div class="item-text">'+value.description+'</div>'+
                    '</div></a></li>';
                    $('.audios').append(html);
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
