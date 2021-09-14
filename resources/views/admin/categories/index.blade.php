@extends('layouts.default')

@section('content')

    <div class="content_header">
    	<h2>Categories</h2>
    	  <h3> <a href="{{ url('admin/addCategory') }}" style="float: right;">Add Category</a> </h3>
	</div>

	@if($categories)
	<table  class="table">
		<thead> <tr> <th> Name </th> <th> Status </th> <th> Action </th> </tr> </thead>
		 
    	@foreach($categories as $category)
			<tr> <td> {{$category->name}} </td> <td> {{$category->status}}</td> <td> <a href="{{url('admin/editCategory' ,$category->id )}} ">Edit</a>
			 | <a href="#" onclick="deleteCategory({{$category->id}})"> Delete </a> </td> </tr>
		@endforeach
	</table>
	@endif    
@endsection

@include('dashboard.includes.foot')

<script stype="text/javascript">
    
    $(document).ready(function() {
     // executes when HTML-Document is loaded and DOM is ready         
      // postTracking();
     
    });
    
    function deleteCategory(cat_id){
        
        var id = cat_id;
        console.log('cat_id = '+ id);        

        var url = "{{ url('admin/deleteCategory') }}"+ '/'+id;
        $.ajaxSetup({
                  headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  }
        });
        $.ajax({
            url : url,
            type : 'GET',
            // data:{id:id},
            success: function(data){
                console.log(data);
                JSON.stringify(data); //to string
   
                if(data.status == 'success'){
                	alert(data.message)
                	location.reload(true);
                }else{
                    alert(data.message)
                }
            },
        });
    }
    
</script>
