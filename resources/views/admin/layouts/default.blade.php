<!doctype html>
<html>
    <head>
        @include('includes.head')
    </head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('admin.includes.header')

   		@include('admin.includes.sidebar')

        @include('admin.includes.navbar')
     	
        @yield('content')

        @include('admin.includes.footer')
    
        <!-- Page Wrapper End -->
    </div>

</body>

@include('includes.foot')
@yield('footer-js-content')

<script stype="text/javascript">

</script>

</html>