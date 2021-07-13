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
                    // core.log(result.audios);
                    var html = '<li style="border: 1px dashed orange;list-style: none; border-radius: 7px;">'+
                            '<a href="templates/audio_show.html?id='+value.id+'" id='+value.title+' onclick="audio.play_audio('+value.id+');" class="item-link item-content">'+
                                '<div class="item-media"><img src="http://localhost/al-maood/public/'+value.audio_img+'" style="border: 1px dotted orange;" width="80" /></div>'+
                                    '<div class="item-inner" style="">'+
                                    '<div class="item-title-row">'+
                                        '<div class="item-title">'+value.title+'</div>'+
                                        '<div class="item-after">'+value.upload_by+'</div>'+
                                    '</div>'+
                           '<div class="item-subtitle">'+value.narrator +
                           '<audio controls="" style="height: 23px; width: 100px; float: right;" src="http://localhost/al-maood/'+value.audio_url+'" type="audio/mp3" controlslist="nodownload"> </div>'+
                        '<div class="item-text">'+value.description+'</div>'+
                    '</div></a></li>';
                    $('.audios').append(html);
                });
                }
            }
        });
	}
}
