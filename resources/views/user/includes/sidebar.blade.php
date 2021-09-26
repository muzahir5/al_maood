<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  
<?php if(! Auth::guard('user')->user() ){ ?>
    <a href="{{ url('user/register') }}">RegisterU</a>
<?php }else{
	echo '<b> Hi '.Auth::guard('user')->user()->name.'</b>';
}
?>
<a href="{{ url('/index')}}">ProductsU</a>

<?php if( Auth::guard('user')->user() ){ ?>

<!-- <a href="{{ url('admin/categories') }}">Categories</a>   -->

  <a href="{{ url('user/logout') }}">LogoutU</a>

<?php }else{ ?>
 <a href="{{ url('user') }}">LoginU</a>
  <?php }?>
  <a href="#" onclick="show_palyer()">Show Player</a>