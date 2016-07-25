@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-10 content_wrapper">
	     <div class="col-md-6"><h2 class="sub-header pull-left">Payroll list</h2>		 
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
			<th>Employee</th>
			<th>Total Working Days</th>
			<th>Unpaid Leaves</th>
			<th>Salary</th>
			<th>Pay Day</th>
			<th>Action</th>
		      </tr>
		    </thead>
		    <tbody>
			
		      <?php $i=1; 
		      if(count($payroll) > 0){
		      foreach($payroll as $value){  ?>		
		      <tr>
			  <td>{{ $i }}</td>
			  <td><?php $getuser = DB::table('users')->where('id', $value->user_id)->first(); ?>{{ $getuser->full_name }}</td>
			  <td>{{ $value->actual_working_days }} </td>
			  <td>{{ $value->unpaid_leave }}</td>
			  <td>{{ $value->total_salary }}</td>
			  <td>{{ $value->pay_day }}</td>
			  <td>
			       @if(in_array(3,Session::get('log_id')))
				<a href="{{ url("/payroll/view/".$value->id) }}" class="btn btn-primary">View</a>
			       @endif
				@if(in_array(2,Session::get('log_id')))
				  <a href="{{ url("/payroll/edit/".$value->id) }}" class="btn btn-primary">Edit</a>
				@endif
				<a href="{{ url("/payroll/export/".$value->id) }}" target="_blank" class="btn btn-primary">Export PDF</a>
				<a href="{{ url("/payroll/print/".$value->id) }}" target="_blank" class="btn btn-primary">Print</a>
				
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
@endsection
