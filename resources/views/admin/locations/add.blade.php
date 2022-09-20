@extends('admin.layouts.default')

@section('title', 'Admin - Add Location')

@section('content')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> Add Location</h1>
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                    <div class="col-xl-12 col-md-12 mb-4">
                    <form method="POST" action="{{ url('/admin/addLocation')}} " enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Location Name:</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ old('name')}}">
                             {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="form-group" style="display: -webkit-inline-box;">
                            <label for="status">Status:</label>            
                            Active<input type="radio" class="form-control" name="status" value="1" checked>
                            DeActive<input type="radio" class="form-control" name="status" value="0">
                        </div>
                        <div class="form-group">
                            <button style="cursor:pointer" type="submit" class="btn btn-primary">Add Location</button>
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
    }); 
</script>
@endsection