@extends('admin.layouts.default')
@section('title', 'Admin - Locations Index')
@section('content')
<?php // echo '<pre>';print_r($locations);exit;?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">
                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                <ul>
                                    <li>{!! \Session::get('success') !!}</li>
                                </ul>
                            </div>
                        @endif
                        </h1>
                        <a href="{{url('admin/addLocation')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="http://localhost/al-maood/admin/audios text-white-50"></i>Add Location</a>
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                    <div class="col-xl-12 col-md-12 mb-4">
                    <table id="data_tbl" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Id #</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($locations)
                                @foreach($locations as $location)
                            <tr>
                                <td>{{$location->id}}</th>
                                <td>{{$location->name}}</td>
                                <td>{{$location->status}}</td>
                                <td>
                                 <a href="{{url('admin/editLocation' ,$location->id)}}">Edit</a>
             |                   <a href="#" onclick="deletelocation({{$location->id}})"> Delete </a> </td> 
                            </tr>                             
                                @endforeach
                            @endif 
                        </tbody>
                    </table>
                </td>
                </tr>
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
            $('.alert').css('display','none');
        }, 5000);

    }); 
</script>
@endsection