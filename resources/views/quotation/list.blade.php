@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-10 content_wrapper">
	     <div class="col-md-6"><h2 class="sub-header pull-left">Quotation List</h2>
		 @if(in_array(7,Session::get('log_id')))
		 <a href="{{ url('/quotation/create') }}" class="create_btn">Create <i class="fa fa-plus" aria-hidden="true"></i></a>
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
                  <th>Quotation Name</th>
				  <th>Client Name</th>
				  <th>Project Name</th>
				  <th>Created Date</th>
				  <th>Post User</th>
				  @if(in_array(8,Session::get('log_id')) || in_array(9,Session::get('log_id')) || in_array(10,Session::get('log_id')))
				  <th>Action</th>
				  @endif
                </tr>
              </thead>
              <tbody>
				<?php $i=1; 
				if(count($quotation) > 0){
				foreach($quotation as $cvalue){  ?>
		
                <tr>
		    <td>{{ $i }}</td>
		    <td>{{ $cvalue->quotation_no }}</td>
			<td>{{ $clients_name[$cvalue->client_id] }}</td>
			<td>{{ $projects_name[$cvalue->project_id] }}</td>
		    <td>{{ $cvalue->created_at }}</td>
		     <td><?php $getuser = DB::table('users')->where('id', $cvalue->post_user)->first(); ?>{{ $getuser->full_name }}</td>
		     <td>
			@if(in_array(2,Session::get('log_id')))
			  <a href="{{ url("/quotation/edit/".$cvalue->id) }}" class="btn btn-primary">Edit</a>
			@endif
			@if(in_array(4,Session::get('log_id')))
			  <!--span class="display-inline">
			  <form class="form-horizontal" id="em_del_form" role="form" method="POST" action="{{ url('/quotation/delete') }}">
			      {!! csrf_field() !!}
			      <input type="hidden" value="{{ $cvalue->id }}" name="id">
			      <button type="button" class="btn btn-info em_del_btn">
				  Delete
			      </button>
			   </form>			   
			  </span-->
			  <a href="#" onclick="deleteConfirmation({{$cvalue->id}})" class="btn btn-danger">Delete</a>
			  <?php
				$quotationPath = config('constants.QUOTATION_STORAGE');
				$quotation_no = str_replace("/", "", str_replace(":", "", $cvalue->quotation_no));
				$quotationFile = $quotationPath.$quotation_no.'.pdf';
			  ?>
				@if(is_file($quotationFile))
					<a href="{{ env('APP_URL').'\\'.$quotationFile }}" target="blank"><img src="/images/pdf-icon.png" alt="Download Quotation" width="32" height="32"></a>
				@endif
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
    <script>
		function deleteConfirmation(id){
			var r = confirm("Are you sure that you want to delete this quotation?");
			if (r == true) {
				$(location).attr('href','/quotation/delete/'+id);
			}
		}
	</script> 
@endsection
