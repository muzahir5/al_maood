const musicContainer = document.getElementById('music-container');
const playBtn = document.getElementById('play');
const prevBtn = document.getElementById('prev');
const nextBtn = document.getElementById('next');

const audio = document.getElementById('audio');
const progress = document.getElementById('progress');
const progressContainer = document.getElementById('progress-container');
const title = document.getElementById('title');
const cover = document.getElementById('cover');
const currTime = document.querySelector('#currTime');
const durTime = document.querySelector('#durTime');

// Song titles
	const songs = [];
	const songsTitle = [];
	const songsImage = [];
	const songsSrc = [];

	//console.log(songs);  console.log(songsTitle);	console.log(songsImage);	console.log(songsSrc);

// Keep track of song
let songIndex = '';
var next_row = prev_row = 0;

// Initially load song details into DOM
// loadSong(songsTitle[songIndex]);

// Update song details
function loadSong(song,category_id) { 
	if(category_id == 0){ core.log('id is '+ category_id);
		title.innerText = today_duas[song].title;
		cover.src = 'http://localhost/al-maood/public/audio/images/' + today_duas[song].audio_img;
		audio.src = 'http://localhost/al-maood/public/audio/mp3/' + today_duas[song].audio_url; // song = audio_index
	}else if(category_id == 3){
		// audios_nohay_all_ids,cat_name,audios_nohay_all_current,audios_nohay_Title,audios_nohay_image_src,audios_nohay_url_src
		title.innerText = nohay_all[song].title;
		cover.src = 'http://localhost/al-maood/public/audio/images/' + nohay_all[song].audio_img;
		audio.src = 'http://localhost/al-maood/public/audio/mp3/' + nohay_all[song].audio_url; // song = audio_index
	}else{
		title.innerText = song;
		title.innerText = songsTitle[song];
		cover.src = 'http://localhost/al-maood/public/audio/images/' + songsImage[song];
		audio.src = 'http://localhost/al-maood/public/audio/mp3/' + songsSrc[song]; // song = audio_index
	}

}

// Play song
function playSong() {
  musicContainer.classList.add('play');
  playBtn.querySelector('i.fas').classList.remove('fa-play');
  playBtn.querySelector('i.fas').classList.add('fa-pause');  

  audio.play();

//   setTimeout(function(){
		$('.music-container').css('display','flex');
		// $('.fam-pause_'+songIndex).css('display','block !important');		
//    }, 2000);
	$('.list_play_'+songIndex).css('display','none');
	$('.list_pause_'+songIndex).css('display','block');

	$('#player_icon').css('display','block');
	$('.music-info').css('display','');
	
	setTimeout(function(){
		var aud_src = $('#audio').attr('src');
		aud_src = aud_src.substr(aud_src.length - 27); //get last 27 from src 
		// core.log('aud_src = ' + aud_src);
		home.incAudioByOne(aud_src);
	}, 5000);
}

// Pause song
function pauseSong() {
  musicContainer.classList.remove('play');
  playBtn.querySelector('i.fas').classList.add('fa-play');
  playBtn.querySelector('i.fas').classList.remove('fa-pause');

  audio.pause();

  $('.list_pause_'+songIndex).css('display','none');
  $('.list_play_'+songIndex).css('display','block');

	$('.music-info').css('display','none');
}

// Previous song
function prevSong() {

	var prev_row = $('#'+songIndex ).prev("tr").attr("id");
	if(prev_row == undefined){ prev_row = songIndex; }

	// console.log(prev_row);
  	// songIndex--;
	// if (songIndex < 0) {
	// 	songIndex = songs.length - 1;
	// }

	songIndex = prev_row;
core.log('c l C is '+ carrent_load_categ);
  loadSong(songIndex,carrent_load_categ);
//   loadSong(songs[songIndex]);	//old
	$('.fam-pause').css('display','none');
	$('.fam-play').css('display','block');
  playSong();
}

// Next song
function nextSong() {
		var next_row = $('#'+songIndex ).next("tr").attr("id");
        
        if(next_row == undefined){ next_row = songIndex; }
        		
		// console.log(next_row);

//   songIndex++;
//   if (songIndex > songs.length - 1) {
//     songIndex = 0;
//   }

songIndex = next_row;

core.log('songIndex is '+ songIndex);
loadSong(songIndex,carrent_load_categ);
//   loadSong(songs[songIndex]);
$('.fam-pause').css('display','none');
$('.fam-play').css('display','block');
  playSong();
}

// Update progress bar
function updateProgress(e) {
  const { duration, currentTime } = e.srcElement;
  const progressPercent = (currentTime / duration) * 100;
  progress.style.width = `${progressPercent}%`;
}

// Set progress bar
function setProgress(e) {
  const width = this.clientWidth;
  const clickX = e.offsetX;
  const duration = audio.duration;

  audio.currentTime = (clickX / width) * duration;
}

//get duration & currentTime for Time of song
function DurTime (e) {
	const {duration,currentTime} = e.srcElement;
	var sec;
	var sec_d;

	// define minutes currentTime
	let min = (currentTime==null)? 0:
	 Math.floor(currentTime/60);
	 min = min <10 ? '0'+min:min;

	// define seconds currentTime
	function get_sec (x) {
		if(Math.floor(x) >= 60){
			
			for (var i = 1; i<=60; i++){
				if(Math.floor(x)>=(60*i) && Math.floor(x)<(60*(i+1))) {
					sec = Math.floor(x) - (60*i);
					sec = sec <10 ? '0'+sec:sec;
				}
			}
		}else{
		 	sec = Math.floor(x);
		 	sec = sec <10 ? '0'+sec:sec;
		 }
	} 

	get_sec (currentTime,sec);

	// change currentTime DOM
	currTime.innerHTML = min +':'+ sec;

	// define minutes duration
	let min_d = (isNaN(duration) === true)? '0':
		Math.floor(duration/60);
	 min_d = min_d <10 ? '0'+min_d:min_d;


	 function get_sec_d (x) {
		if(Math.floor(x) >= 60){
			
			for (var i = 1; i<=60; i++){
				if(Math.floor(x)>=(60*i) && Math.floor(x)<(60*(i+1))) {
					sec_d = Math.floor(x) - (60*i);
					sec_d = sec_d <10 ? '0'+sec_d:sec_d;
				}
			}
		}else{
		 	sec_d = (isNaN(duration) === true)? '0':
		 	Math.floor(x);
		 	sec_d = sec_d <10 ? '0'+sec_d:sec_d;
		 }
	} 

	// define seconds duration
	
	get_sec_d (duration);

	// change duration DOM
	durTime.innerHTML = min_d +':'+ sec_d;
		
};

// Event listeners
playBtn.addEventListener('click', () => {
  const isPlaying = musicContainer.classList.contains('play');

  if (isPlaying) {
    pauseSong();
  } else {
    playSong();
  }
});

// Change song
prevBtn.addEventListener('click', prevSong);
nextBtn.addEventListener('click', nextSong);

// Time/song update
audio.addEventListener('timeupdate', updateProgress);

// Click on progress bar
progressContainer.addEventListener('click', setProgress);

// Song ends
audio.addEventListener('ended', nextSong);

// Time of song
audio.addEventListener('timeupdate',DurTime);