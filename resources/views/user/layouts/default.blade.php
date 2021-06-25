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
   		<div class="col-lg-2 col-md-3 col-sm-0 col-xs-0 sidebar" id="mySidebar" >
   			@include('user.includes.sidebar')
      </div>

      <div class="col-lg-10 col-md-9 col-sm-12 col-xs-12" id="main">
        	<button class="openbtn" onclick="openNav()">☰ </button>
          @yield('content')
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

<script stype="text/javascript">
  function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  
  document.getElementById("main").style.marginLeft = "250px";
  $(".sidebar").css("display", "block");
  $(".openbtn").css("display", "none");
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  
  $(".sidebar").css("display", "none");
  $(".openbtn").css("display", "block");
}
</script>

</html>