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
function loadSong(song) {
  title.innerText = song;

  // alert(song);

  title.innerText = songsTitle[song];
  cover.src = 'http://localhost/al-maood/public/audio/images/' + songsImage[song];
  audio.src = 'http://localhost/al-maood/public/audio/mp3/' + songsSrc[song]; // song = audio_index

  // audio.src = `public/music/${song}.mp3`;
  // cover.src = `public/images/${song}.jpg`;

}

// Play song
function playSong() {
	$('div#music-container').css('display','block !important');

  musicContainer.classList.add('play');
  playBtn.querySelector('i.fas').classList.remove('fa-play');
  playBtn.querySelector('i.fas').classList.add('fa-pause');  

  audio.play();
  $('.list_play_'+songIndex).css('display','none');
}

// Pause song
function pauseSong() {
  musicContainer.classList.remove('play');
  playBtn.querySelector('i.fas').classList.add('fa-play');
  playBtn.querySelector('i.fas').classList.remove('fa-pause');

  $('list_play').css('display','none');

  audio.pause();

  $('.list_play_'+songIndex).css('display','block');
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

  loadSong(songs[songIndex]);

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

  loadSong(songs[songIndex]);

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