@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-10 content_wrapper">
	     <div class="col-md-6"><h2 class="sub-header pull-left">SDL Setting List</h2>
		 @if(in_array(7,Session::get('log_id')))
		 <a href="{{ url('/sdl/create') }}" class="create_btn">Create <i class="fa fa-user-plus" aria-hidden="true"></i></a>
		 @endif
	     </div>
	     <div class="clearfix"></div>
	      @if (session('status'))
		<div class="alert alert-info error_msg" role="alert">		   
		    {{ session('status') }}
		</div>
		@endif
          <div class="table-responsive margintop20">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Total Wages greter then</th>
				  <th>SDL Payable</th>
				  <th>Created Date</th>
				  <th>Updated Date</th>
				  <th>Post User</th>
				  @if(in_array(8,Session::get('log_id')) || in_array(9,Session::get('log_id')) || in_array(10,Session::get('log_id')))
				  <th>Action</th>
				  @endif
                </tr>
              </thead>
              <tbody>
		<?php $i=1; 
		if(count($sdl) > 0){
		foreach($sdl as $cvalue){  ?>
		
                <tr>
		    <td>{{ $i }}</td>
		    <td>{{ $cvalue->total_wages }}</td>
		    <td>{{ $cvalue->sdl_payable }}</td>
		    <td>{{ $cvalue->created_at }}</td>
		    <td>{{ $cvalue->updated_at }}</td>
		     <td><?php $getuser = DB::table('users')->where('id', $cvalue->post_user)->first(); ?>{{ $getuser->full_name }}</td>
		     <td>
			@if(in_array(2,Session::get('log_id')))
			  <a href="{{ url("/sdl/edit/".$cvalue->id) }}" class="btn btn-primary">Edit</a>
			@endif
			@if(in_array(4,Session::get('log_id')))
			  <!--span class="display-inline">
			  <form class="form-horizontal" id="em_del_form" role="form" method="POST" action="{{ url('/sdl/delete') }}">
			      {!! csrf_field() !!}
			      <input type="hidden" value="{{ $cvalue->id }}" name="id">
			      <button type="button" class="btn btn-info em_del_btn">
				  Delete
			      </button>
			   </form>
			  </span-->
			  <a href="#" onclick="deleteConfirmation({{$cvalue->id}})" class="btn btn-danger">Delete</a>
			 @endif
		     </td>
                </tr> 
		
		<?php $i++; } 
		} 
		else{
		echo '<tr><td>There is not data to display.</td></tr>';
		}
		?>
              </tbody>
            </table>
          </div>
        </div>
    <script>
		function deleteConfirmation(id){
			var r = confirm("Are you sure that you want to delete this SDL?");
			if (r == true) {
				$(location).attr('href','/sdl/delete/'+id);
			}
		}
	</script> 
@endsection
