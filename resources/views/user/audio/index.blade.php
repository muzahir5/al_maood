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
                        <a href="{{url('user/createAudio')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="http://localhost/al-maood/user/audios text-white-50"></i> Add Audio</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                    <div class="col-xl-12 col-md-12 mb-4">
                        
                    <table id="data_tbl" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">Id#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Status</th>
                                <th scope="col">Uploaded by</th>                  
                                <th scope="col">Category</th>
                                <th scope="col">View By</th>
                                <th scope="col">Action</th>
                                <th scope="col">Item</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($audios)
                                @foreach($audios as $audio)
                                <tr>
                                    <th scope="row">{{$audio->id}}</th>
                                    <td>{{$audio->title}}</td>
                                    <td>
                                        @if($audio->status == 3)
                                        <b> Deleted </b>
                                        @elseif($audio->status == 1)
                                        <b> Active </b>
                                        @else
                                        <b title="Will be Activated by Admin Soon,  be Patience plz" > InActive </b>
                                        @endif
                                    </td>
                                    <td>{{$audio->upload_by}}</td>                  
                                    <td>
                                    @foreach($categories as $cat)
                                        @if($cat->id == $audio->category)
                                        {{$cat->name}}
                                        @endif
                                    @endforeach
                                    </td>
                                    <td>{{$audio->view_by}}</td>                  
                                    <td><a href="{{url('user/editAudio' ,$audio->id )}} ">Edit</a> |Delete</td>
                                    <td>
                                    <!-- {{$audio->audio_url}} -->
                                    <audio controls="" style="vertical-align: middle" src="{{ asset('public/audio/mp3/'.$audio->audio_url) }} " type="audio/mp3" controlslist="nodownload">
                                    </td>
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