@extends('admin.layouts.default')

@section('title', 'Admin - Users Index')

@section('content')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Users</h1>
                        <div class="info_msgs">
                          @if(session('success'))
                          <div class="alert alert-success">
                                <ul>
                                    <li>{!! \Session::get('success') !!}</li>
                                </ul>
                            </div>
                          @endif
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                    <div class="col-xl-12 col-md-12 mb-4">
                        
                    <table id="data_tbl" class="display" style="width:100%">
                        <thead>
                            <tr>
                              <th scope="col">Id#</th>
                              <th scope="col">Name</th>
                              <th scope="col">E-mail</th>
                              <th scope="col">mobile #</th>
                              <th scope="col">Status</th>                  
                              <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          @if($users)
                            @foreach($users as $user)
                              <tr>
                                <th scope="row">{{$user->id}}</th>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->mobile_number}}</td>
                                <td>
                                    @if($user->status == 3)
                                      <a href="#" title="User is Block" > Block , </a>
                                    @elseif($user->status == 0)
                                      <a href="#" title="User is UnActive" > UnActive , </a>
                                    @endif
                                    @if($user->status == 0 || $user->status == 3)
                                      <a href="{{url('admin/updateUserStatus' , [ $user->id , 1 ])}}" title="Click to Activite User" > Activite </a>
                                    @else
                                      <a href="{{url('admin/updateUserStatus' ,[ $user->id , 3 ])}}" title="Click to Block User"> Block </a>
                                    @endif
                                </td>                
                                <td><a href="{{url('admin/editUser' ,$user->id )}} ">Edit</a> |Delete</td>
                                
                              </tr>                              
                              @endforeach
                          @endif 
                        </tbody>
                    </table>

                    </div>

                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

@endsection

@section('footer-js-content')
<script type="text/javascript">
    $(document).ready(function () {
        
        $('#data_tbl').DataTable( {
                "pagingType": "full_numbers",
                "pageLength": 50
        } );

        setTimeout(function(){
            $('.info_msgs').css('display','none');
        }, 5000);

    }); 
</script>
@endsection