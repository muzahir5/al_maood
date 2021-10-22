<!doctype html>
<html>
    <head>
        @include('includes.head')
    </head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('editor.includes.header')

   		@include('editor.includes.sidebar')

        @include('editor.includes.navbar')
     	
        @yield('content')

        @include('editor.includes.footer')
    
        <!-- Page Wrapper End -->
    </div>

</body>

@include('includes.foot')
@yield('footer-js-content')

<script stype="text/javascript">

</script>

</html>