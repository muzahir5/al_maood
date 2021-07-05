

  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  
 
        
        <?php if(! auth()->check() ){ ?>
            <a href="{{ url('admin/register') }}">Register</a>
        <?php }?>

        <?php if( auth()->check() ){ ?>

          <a href="{{ url('/admin/product')}}">Products</a>
          <a href="{{ url('/admin/audio')}}">Audio</a>
          <a href="{{ url('admin/categories') }}">Categories</a>
          <a href="{{ url('admin/users') }}">Users</a>

          <a href="{{ url('admin/logout') }}">Logout</a>

        <?php }else{ ?>
         <a href="{{ url('admin/login') }}">Login</a>
          <?php }?>
     







