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
                    core.log(result.base_path);
                    var id = value.id; var audio_url = "'"+value.audio_url+"'";
                    var html = '<li style="border: 1px dashed orange;list-style: none; border-radius: 7px;">'+                            
                            '<a href="#" id='+value.title+' oncjclick="audio.play_audio('+value.id+');" class="item-link item-content">'+
                                '<div class="item-media"><img src="http://localhost/al-maood/public/'+value.audio_img+'" style="border: 1px dotted orange;" width="80" /></div>'+
                                    '<div class="item-inner" style="">'+
                                    '<div class="item-title-row">'+
                                        '<div class="item-title">'+value.title+'</div>'+
                                        '<div class="item-after">'+value.upload_by+'</div>'+
                                    '</div>'+
                           '<div class="item-subtitle">'+value.narrator +
                            '<i class="fas fa-play" id="audio_'+value.id+'" onclick="home.load_audio_play('+id+','+audio_url+');"></i> </div>'+
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
    load_audio_play: function(id,audio_url){
        core.log('id is '+audio_url);
        // core.log('id is '+audio_url);
        $("#audio").attr("src",audio_url);
        $('#music-container').css('display','block')

    }
}
