@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-10 content_wrapper">
	     <div class="col-md-6"><h2 class="sub-header pull-left">Race List</h2>
		 @if(in_array(7,Session::get('log_id')))
		 <a href="{{ url('/race/create') }}" class="create_btn">Create <i class="fa fa-plus" aria-hidden="true"></i></a>
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
                  <th>Race Name</th>
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
		if(count($race) > 0){
		foreach($race as $cvalue){  ?>
		
                <tr>
		    <td>{{ $i }}</td>
		    <td>{{ $cvalue->race_name }}</td>
		    <td>{{ $cvalue->created_at }}</td>
		    <td>{{ $cvalue->updated_at }}</td>
		     <td><?php $getuser = DB::table('users')->where('id', $cvalue->post_user)->first(); ?>{{ $getuser->full_name }}</td>
		     <td>
			@if(in_array(2,Session::get('log_id')))
			  <a href="{{ url("/race/edit/".$cvalue->id) }}" class="btn btn-primary">Edit</a>
			@endif
			@if(in_array(4,Session::get('log_id')))
			  <span class="display-inline">
			  <form class="form-horizontal" id="em_del_form" role="form" method="POST" action="{{ url('/race/delete') }}">
			      {!! csrf_field() !!}
			      <input type="hidden" value="{{ $cvalue->id }}" name="id">
			      <button type="button" class="btn btn-info em_del_btn">
				  Delete
			      </button>
			   </form>
			  </span>			  
			 @endif
		     </td>
                </tr> 
		
		<?php $i++; } 
		} 
		else{
		echo '<tr><td colspan="8">There is not data to display.</td></tr>';
		}
		?>
              </tbody>
            </table>
          </div>
        </div>
     
@endsection
