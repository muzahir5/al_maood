@extends('admin.layouts.default')

@section('title', 'Narrator Edit')

@section('content')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> Edit Narrator</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                    <div class="col-xl-12 col-md-12 mb-4">

                    <form method="POST" action="{{ url('/admin/updateNarrator')}} " enctype="multipart/form-data">        
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Name :</label>
                            <input type="hidden" class="form-control" id="id" name="id" value="{{ $narrator->id }}">
                            <input type="text" class="form-control" id="name" name="name" value="{{ (old('name'))? old('name') : $narrator->name}}">
                            {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail :</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ (old('email'))? old('email') : $narrator->email}}">
                            {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="row" style="border: 1px dotted orange;padding: 5px;border-radius: 23px;">
                            <div class="form-group col-6">
                                <label for="profile_pic">Profile Pic:</label>
                                <input type="file" class="form-control" id="profile_pic" name="profile_pic" value="{{ old('profile_pic')}}">
                                {!! $errors->first('profile_pic', '<p class="text-danger">:message</p>') !!}
                            </div>
                            <div class="form-group col-6">            
                            <img src="{{ asset('public/narrators/'.$narrator->profile_pic) }}" alt="profile_pic" style="max-width: 150px;">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button style="cursor:pointer" type="submit" class="btn btn-primary">Update Audio</button>
                        </div>
                    </form>

                    <!-- Ends Row & col -->
                    </div> 
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

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