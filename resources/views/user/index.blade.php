@extends('user.layouts.default')

@section('title', 'Audio Index')

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
                        <a href="{{url('admin/addAudio')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="http://localhost/al-maood/admin/audios text-white-50"></i> Add Audio</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
						@if($categories)
							@foreach($categories as $category)
							<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 mb-4 text-center">
								<div class="card border-left-primary shadow h-100 py-2">
									<a href="{{ url('/user/listAudioByCatagory', $category->id)}}">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
													{{$category->category_type}}</div>
													<div class="img-box">
													<img style="max-width: 120px;max-height: 350px;" src="{{ asset('public/categories/'.$category->category_img) }}" alt="Category_image_url">
												</div>
													<div class="h5 mb-0 font-weight-bold text-gray-800"> <strike>{{$category->id}} , {{$category->name}}</strike> </div>
												</div>
												<!-- <div class="col-auto">
													<i class="fas fa-music fa-2x text-primary"></i>
												</div> -->
											</div>
										</div>
									</a>
								</div>
							</div>

								<!-- <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 col-xl-3"> -->
									<!-- <div class="thumb-wrapper col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
										<a href="">
											<div class="img-box">
												<img src="{{ asset('public/categories/'.$category->category_img) }} " alt="Category_image_url" style="max-width: 250px;max-height: 350px;">
											</div>
											<div class="thumb-content">
												<h4></h4>
												<p class="item-price"><strike>{{$category->id}}</strike> <span></span></p>
											</div>
										</a>
									</div> -->
								<!-- </div> -->
							@endforeach
						@endif                        
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