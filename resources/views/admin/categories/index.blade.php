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
			<tr> <td> {{$category->name}} </td> <td> {{$category->status}}</td> <td> <a href="{{url('admin/editCategory' ,$category->id )}} ">Edit</a> |Delete </td> </tr>
		@endforeach
	</table>
	@endif    
@endsection 
 
 

