@extends('layouts.default')

@section('title', 'Users')

@section('content')

    <h2>Users
    	<!-- <span style="float: right;"><a href="{{ url('admin/addAudio') }}">Add Audio</a>  </span> -->
    </h2>
    <div class="info_msgs">
      @if(session('success'))
        <h3>{{session('success')}}</h3>
      @endif
    </div>
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
          </td>
        </tr>
      </table>
   

@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>

<script>
  $(document).ready(function() {
          
    $('#data_tbl').DataTable( {
        "pagingType": "full_numbers",
        "pageLength": 50
    } );
  } );

  setInterval(function(){ $('.info_msgs').css('display','none'); }, 5000);

</script>