@extends('admin.layouts.default')

@section('title', 'Narrator Index')

@section('content')

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
                        <a href="{{url('admin/addNarrator')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="http://localhost/al-maood/admin/audios text-white-50"></i> Add Narrator</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                    <div class="col-xl-12 col-md-12 mb-4">
                        
                        <table id="narrator_data_tbl" class="display data_tbl_cls" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Id#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($narrators)
                                    @foreach($narrators as $narrator)
                                    <tr>
                                        <th scope="row">{{$narrator->id}}</th>
                                        <td>{{$narrator->name}}</td>
                                        <td>{{$narrator->email}}</td>
                                        <td>
                                            @if($narrator->status == 3)
                                            <a href="#" title="narrator is Deleted" > Deleted </a>
                                            @elseif($narrator->status == 1)
                                            <a href="{{url('admin/updateNarratorStatus' , $narrator->id)}}" title="Click to InActive status" > Active </a>
                                            @else
                                            <a href="{{url('admin/updateNarratorStatus' ,$narrator->id)}}" title="Click to Activate status" > InActive </a>
                                            @endif
                                        </td>
                                        <td><a href="{{url('admin/editNarrator' ,$narrator->id )}} ">Edit</a> |Delete</td>
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
        
        $('#narrator_data_tbl').DataTable( {
                "pagingType": "full_numbers",
                "pageLength": 50
        } );

        setTimeout(function(){
            $('.alert').css('display','none');
        }, 5000);

    }); 
</script>
@endsection