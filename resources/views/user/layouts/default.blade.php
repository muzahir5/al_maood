<!doctype html>
<html>
    <head>
        @include('includes.head')
    </head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('user.includes.header')

   		  @include('user.includes.sidebar')

        @include('user.includes.navbar')
     	
        @yield('content')

        <div class="music-container" id="music-container">
            <div class="music-info">
              <h4 id="title"></h4>
              <div class="progress-container" id="progress-container">            
                <div class="progress" id="progress"></div>
                <span id="currTime"></span> <span id="durTime"></span>
              </div>
            </div>

            <audio src="{{ asset('public/music/ukulele.mp3')}}" id="audio"></audio>

            <div class="img-container">
              <img src="{{ asset('public/images/ukulele.jpg')}}" alt="music-cover" id="cover" />
            </div>
            <div class="navigation">
              <button id="prev" class="action-btn">
                <i class="fas fa-backward"></i>
              </button>
              <button id="play" class="action-btn action-btn-big">
                <i class="fas fa-play"></i>
              </button>
              <button id="next" class="action-btn">
                <i class="fas fa-forward"></i>
              </button>
            </div>
            <div id="player_options">
            <span class="text-dark" onclick="hide_player()">Hide</span>
            </div>
          </div>

        @include('user.includes.footer')
    
        <!-- Page Wrapper End -->
    </div>

</body>

@include('includes.foot')
@yield('footer-js-content')

<script stype="text/javascript">

      function hide_player()
      {
        $('div#music-container').css('display','none');
      }
      function show_player(){
        $('div#music-container').css('display','block');
      }
    $(document).ready(function () {

      
      

      /*
      For  auto play after load/Reload page
      var current_audio_url = localStorage.getItem("current_audio_url");
      var current_audio_pic = localStorage.getItem("current_audio_pic");
      var current_audio_title = localStorage.getItem("current_audio_title");
      var current_audio_status = localStorage.getItem("current_audio_status");      
      // console.log(current_audio_status + ' { }' + current_audio_pic + ' { }' + current_audio_title + ' { }' + current_audio_url);

		  if( current_audio_status == 1)
      {
        title.innerText = "current_audio_title";
        cover.src = current_audio_pic;
        audio.src = current_audio_url;

        setTimeout(function(){
            // playSong();
        }, 3000);
        
      }
      */

    });

</script>

</html>