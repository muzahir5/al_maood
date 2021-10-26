<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  
<?php if(! Auth::guard('user')->user() ){ ?>
<?php }else{
	echo '<b> Hi '.Auth::guard('user')->user()->name.'</b>';
}
?>
<!-- <a href="{{ url('/index')}}">ProductsU</a> -->

<?php if( Auth::guard('user')->user() ){ ?>

<?php }else{ ?>
  <?php }?>