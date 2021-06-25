

  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  
<?php if(! Auth::guard('user')->user() ){ ?>
    <a href="{{ url('user/register') }}">Register</a>
<?php }else{
	echo '<b> Hi '.Auth::guard('user')->user()->name.'</b>';
}
?>
<a href="{{ url('/index')}}">Products</a>

<?php if( Auth::guard('user')->user() ){ ?>

<!-- <a href="{{ url('admin/categories') }}">Categories</a>   -->

  <a href="{{ url('user/logout') }}">Logout</a>

<?php }else{ ?>
 <a href="{{ url('user') }}">Login</a>
  <?php }?>
     







