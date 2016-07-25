@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-10 content_wrapper">
	     <div class="col-md-6"><h2 class="sub-header pull-left">User List</h2>
		 @if(in_array(1,Session::get('log_id')))
		 <a href="{{ url('/user/create') }}" class="create_btn">Create  <i class="fa fa-user-plus" aria-hidden="true"></i></a>
		 @endif
	     </div>
	     <div class="clearfix"></div>
	      @if (session('status'))
		<div class="alert alert-info error_msg" role="alert">		   
		    {{ session('status') }}
		</div>
		@endif
          <div class="table-responsive margintop20">
            <table class="table table-hover" id="add_datatbl">
              <thead>
                <tr>
                  <th>#</th>
                  <th>User Name</th>
                  <th>Full Name</th>
                  <th>Position</th>
                  <th>NIRC</th>
                  <th>Pass Status</th>
				  <th>Working time shift</th>
				  <th>User Role</th>
				  <th>Post Date</th>
				  <th>Post User</th>
				  <th>Action</th>
                </tr>
              </thead>
              <tbody>
		<?php $i=1; foreach ($user as $value){ ?>		
                <tr>
                  <td> {{ $i  }}</td>
                  <td>{{ $value->user_name}}</td>
                  <td>{{ $value->full_name}}</td>
                  <td>{{ $value->position }}</td>
                  <td>{{ $value->nirc }}</td>
                  <td><?php $getpass = DB::table('pass_status')->where('id', $value->pass_status)->first();
			    echo $getpass->pass_name; ?></td>
		  <td><?php $getshift = DB::table('ec_workshift')->where('id', $value->time_shift)->first();
			    echo $getshift->wshift_name; ?></td>
		  <td><?php $getuser = DB::table('ec_user_role')->where('id', $value->user_role)->first(); ?>{{ $getuser->role_name }}</td>
		  <td>{{ $value->created_at }}</td>
		  <td><?php $getuser = DB::table('users')->where('id', $value->post_user)->first(); ?>{{ $getuser->full_name }}	</td>
		  <td>  
		      @if(in_array(3,Session::get('log_id')))
		      <a href="{{ url("/user/view/".$value->id) }}" class="btn btn-primary">View</a>
		      @endif
		      @if(in_array(2,Session::get('log_id')))
		        <a href="{{ url("/user/edit/".$value->id) }}" class="btn btn-primary">Edit</a>
		      @endif
		      @if(in_array(4,Session::get('log_id')))
		        @if($value->user_name != "administrator")
			<span class="display-inline">
			<form class="form-horizontal" id="em_del_form" role="form" method="POST" action="{{ url('/user/delete') }}">
			    {!! csrf_field() !!}
			    <input type="hidden" value="{{ $value->id }}" name="id">
			    <button type="button" class="btn btn-info em_del_btn">
				Delete
			    </button>
			 </form>
			</span>
			 @endif
		       @endif
		  </td>
                </tr> 		
		<?php $i++; }   ?>
		
              </tbody>
	     
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection
