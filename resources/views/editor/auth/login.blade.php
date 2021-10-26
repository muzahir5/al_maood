@extends('editor.layouts.default')

@section('title', 'Admin Dashboard')

@section('content')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-8 mb-4">

                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Editor In</h6>
                                </div>
                                <div class="card-body">
                                    @if($errors->any())
                                        <h4 class="text-danger">{{$errors->first('message')}}</h4>
                                    @endif
                                    <form method="POST" action="{{ url('/editor/login')}} ">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="email">Email:</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email')}}">
                                             {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                                        </div>

                                        <div class="form-group">
                                            <label for="password">Password:</label>
                                            <input type="password" class="form-control" id="password" name="password" value="{{ old('password')}}">
                                             {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
                                        </div>

                                        <div class="form-group">
                                            <button style="cursor:pointer" type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

@endsection


<script type="text/javascript">
    // $(document).ready(function () {

    // });
</script>