var home = {    
    audio_list: function(searchInCat,cat_name){    	
    	var param = [];
        var url = 'user/listAudio/'+searchInCat;
        mainView.router.loadPage('templates/audio_list.html');
        // core.log('Error: ' + url);
        core.getRequest(url,param, function (response, status) {
        	
            if (status === 'success') {
                var result = response;                     
                if (result.status === 'success') {
                var audios = result.audios;
                $('.block-title').append(cat_name);
                $.each(audios,function(key,value){
                    // core.log(result.audios);
                    var html = '<li style="border: 1px dashed orange;list-style: none;margin: 3px; border-radius: 7px;">'+
                            '<a href="templates/audio_show.html?id='+value.id+'" id='+value.title+' onclick="audio.play_audio('+value.id+');" class="item-link item-content" style="display: flex;padding:5px;">'+
                                '<div class="item-media"><img src="http://localhost/al-maood/public/'+value.img_upload_text_link+'" style="border: 1px dotted orange;" width="80" /></div>'+
                                    '<div class="item-inner" style="padding-left: 5px;">'+
                                    '<div class="item-title-row" style="display: flex;">'+
                                        '<div class="item-title">'+value.title+'</div>'+
                                        '<div class="item-after" style="margin-left: 5%;">'+value.upload_by+'</div>'+
                                    '</div>'+
                           '<div class="item-subtitle">'+value.narrator+'</div>'+
                        '<div class="item-text">'+value.description+'</div>'+
                    '</div></a></li>';
                    $('.audios').append(html);
                });
                }
            }
        });
	}
}
