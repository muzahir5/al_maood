@extends('admin.layouts.default')

@section('title', 'Admin - Edit Category')

@section('content')
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> Edit Category</h1>
                    </div>
                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-xl-12 col-md-12 mb-4">
                            <form method="POST" action="{{ url('/admin/updateCategory')}} " enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $category->id }}">
                                <div class="form-group">
                                    <label for="name">Category Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
                                     {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group">
                                    <label for="name">Category type:</label>
                                    <input type="text" value="{{ $category->category_type }}" name="category_type" id="category_type" class="form-control" placeholder="audio,video,hdform">
                                     {!! $errors->first('category_type', '<p class="text-danger">:message</p>') !!}
                                </div>
                                <div class="form-group" style="display: -webkit-inline-box;">
                                    <label for="status">Status:</label>            
                                    Active<input type="radio" class="form-control" name="status" value="1" {{ ($category->status=="1")? "checked" : "" }}>
                                    DeActive<input type="radio" class="form-control" name="status" value="0" {{ ($category->status=="0")? "checked" : "" }}>
                                </div>
                                <div class="row" style="border: 1px dotted orange;padding: 5px;border-radius: 23px;">
                                        <div class="form-group col-6">
                                            <label for="category_img">Image:</label>
                                            <input type="file" class="form-control" id="category_img" name="category_img" value="{{ old('category_img')}}">
                                            {!! $errors->first('category_img', '<p class="text-danger">:message</p>') !!}
                                        </div>
                                        <div class="form-group col-6" style="text-align: center;border: 1px dashed red;max-width: 200px;padding: 5px;">            
                                        <img src="{{ asset($category->category_img) }} " alt="Product_image_url" style="max-width: 110px;">
                                        </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <button style="cursor:pointer" type="submit" class="btn btn-primary">Update Category</button>
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