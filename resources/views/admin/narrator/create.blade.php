@extends('admin.layouts.default')

@section('title', 'Admin Add Narrator')

@section('content')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> Add Narrator</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                    <div class="col-xl-12 col-md-12 mb-4">

                    <form method="POST" action="{{ url('/admin/addNarrator')}} " enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}">
                            {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email')}}">
                            {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group">
                            <label for="mobile_number">Mobile Number:</label>
                            <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{ old('mobile_number')}}">
                            {!! $errors->first('mobile_number', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group">
                            <label for="profile_pic">profile_pic:</label>
                            <input type="file" class="form-control" id="profile_pic" name="profile_pic" value="{{ old('profile_pic')}}">
                            {!! $errors->first('profile_pic', '<p class="text-danger">:message</p>') !!}
                        </div>

                        
                        <div class="form-group">
                            <button style="cursor:pointer" type="submit" class="btn btn-primary">Add Narrator</button>
                        </div>
                    </form>

                    <!-- Ends Row & col -->
                    </div> 
                    </div>
                    Type

@endsection

@section('footer-content')
<script type="text/javascript">
    $(document).ready(function () {
        
        $('#data_tbl').DataTable( {
                "pagingType": "full_numbers",
                "pageLength": 50
        } );

    }); 
</script>
@endsection