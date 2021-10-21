@extends('editor.layouts.default')

@section('title', 'Editor Index')

@section('content')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> Add Audio</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                    <div class="col-xl-12 col-md-12 mb-4">

                    <form method="POST" action="{{ url('/editor/addAudio')}} " enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title')}}">
                            {!! $errors->first('title', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group">
                            <label for="poet">Poet:</label>
                            <input type="text" class="form-control" id="poet" name="poet" value="{{ old('poet')}}">
                            {!! $errors->first('poet', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group">
                            <label for="description">Description:</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{ old('description')}}">
                            {!! $errors->first('description', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group">
                            <label for="narrator">Narrator:</label>
                            <input type="text" class="form-control" id="narrator" name="narrator" value="{{ old('narrator')}}">
                            {!! $errors->first('narrator', '<p class="text-danger">:message</p>') !!}
                        </div>        

                        <div class="row">
                            <div class="form-group col-6">
                                <label for="category">Select Category:</label>
                                <select class="form-select form-control" name="category" id="category" multiple aria-label="multiple select example">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)                  
                                    <option value="{{$category->id}} "> {{$category->name}} </option>                              
                                @endforeach
                            </select>
                            {!! $errors->first('category', '<p class="text-danger">:message</p>') !!}
                            </div>

                            <div class="form-group col-6">
                                <label for="show_to">Show To:</label>
                                <select class="form-select form-control" name="show_to" id="show_to" multiple aria-label="">
                                <option value="">Select please</option>
                                    <option value="0"> All </option>
                                    <option value="1"> Science </option>
                                    <option value="3"> Art </option>
                            </select>
                            {!! $errors->first('show_to', '<p class="text-danger">:message</p>') !!}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="audio_type">Type:</label>
                            <input type="audio_type" class="form-control" id="audio_type" name="audio_type" value="{{ old('audio_type')}}" Placeholder="hmd , nat">
                            {!! $errors->first('audio_type', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="language">Language:</label>
                                <select class="form-select form-control" name="language" id="language" multiple aria-label="">
                                <option value="">Select please</option>                    
                                    @foreach($languages as $language)                  
                                        <option value="{{$language->id}} "> {{$language->name}} </option>                              
                                    @endforeach
                                </select>
                                {!! $errors->first('language', '<p class="text-danger">:message</p>') !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="album">Album:</label>
                            <input type="text" class="form-control" id="album" name="album" value="{{ old('album')}}">
                            {!! $errors->first('album', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group">
                            <label for="released_at">Released At:</label>
                            <input type="text" class="form-control" id="released_at" name="released_at" value="{{ old('released_at')}}">
                            {!! $errors->first('released_at', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group">
                            <label for="mp3_file">mp3 file:</label>
                            <input type="file" class="form-control" id="mp3_file" name="mp3_file" value="{{ old('mp3_file')}}">
                            {!! $errors->first('mp3_file', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group">
                            <label for="img_upload_text_link">Image:</label>
                            <input type="file" class="form-control" id="img_upload_text_link" name="img_upload_text_link" value="{{ old('img_upload_text_link')}}">
                            {!! $errors->first('img_upload_text_link', '<p class="text-danger">:message</p>') !!}
                        </div>

                        <div class="form-group">
                            <label for="pdf_upload_text_link">pdf_upload_text_link:</label>
                            <input type="file" class="form-control" id="pdf_upload_text_link" name="pdf_upload_text_link" value="{{ old('pdf_upload_text_link')}}">
                            {!! $errors->first('pdf_upload_text_link', '<p class="text-danger">:message</p>') !!}
                        </div>
                        
                        <div class="form-group">
                            <button style="cursor:pointer" type="submit" class="btn btn-primary">Add Audio</button>
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