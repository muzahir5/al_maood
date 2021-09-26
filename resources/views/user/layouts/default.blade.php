<!doctype html>

<html>

<head>

   @include('user.includes.head')

</head>

<body>

<div class="container-fluid">

   <header class="row">

       @include('user.includes.header')

   </header>

   <div class="row">
        <div class="sidebar" id="mySidebar" >
   			@include('user.includes.sidebar')
      </div>

      <div id="main">        	
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
            <span class="text-dark"onclick="hide_player()">Hide</span>
            </div>
          </div>
      
      </div>

   </div>

   <footer class="row">
   		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  p-5">
       		@include('user.includes.footer')
       	</div>

   </footer>

</div>

</body>

@include('user.includes.foot')
<script src="{{ asset('public/js/audio_player.js')}}"></script>
<script stype="text/javascript">
  function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  
  // document.getElementById("main").style.marginLeft = "250px";
  $(".sidebar").css("display", "block");
  $(".closebtnn").css("display", "block");
  $(".openbtn").css("display", "none");
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  // document.getElementById("main").style.marginLeft= "0";
  
  $(".sidebar").css("display", "none");
  $(".closebtnn").css("display", "none");
  $(".openbtn").css("display", "block");
}

  function hide_player()
  {
    $('div#music-container').css('display','none');
  }
  function show_palyer(){
    $('div#music-container').css('display','block');
  }
</script>

</html>