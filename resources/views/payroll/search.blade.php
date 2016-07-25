@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-10 content_wrapper">
	     <h2 class="sub-header">Search existing payroll</h2>
	     <div class="payroll_generate_wrapper">
             <form class="form-horizontal" role="form" method="POST" action="{{ url('/payroll/search') }}">
                        {!! csrf_field() !!}
		<div class="form-group">
		    <label class="col-md-2 control-label">Choose month and year <span class="add_redcolor">*</span></label>		   
			<?php $pdate = DB::table('ec_payroll_setting')->groupBy('pay_day')->orderBy('pay_day', 'desc')->get();
			    $month_array =array();
			    $year_array = array();
			    foreach($pdate as $value){
				 $get_m = date('m',strtotime($value->pay_day));
				 array_push($month_array,$get_m);
				 $get_y = date('Y',strtotime($value->pay_day));
				 array_push($year_array,$get_y);
			    }
			?>
		     <div class="col-md-2">			 
			<select class="form-control col-md-2" name="m_search">
			    <option value="">Month</option>
			    <?php 
			     for($i=1;$i<=12;$i++){
				 if($i<10){ $m =  "0".$i;} else{ $m=  $i; }
				 if(in_array($m,$month_array)){
		            ?>
			    <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
			    <?php
				 }
			     }
			    ?>
			</select>
			 @if ($errors->has('m_search'))
			    <span class="help-block">
				<strong>{{ $errors->first('m_search',"This field is required") }}</strong>
			    </span>
			@endif	
		     </div>
		     <div class="col-md-2">
			<select class="form-control col-md-2" name="y_search">
			    <option value="">Year</option>
			    <?php
			    for($i=0;$i<count(array_unique($year_array));$i++){
			    ?>
			    <option value="<?php echo $year_array[$i]; ?>"><?php echo $year_array[$i]; ?></option>
			    <?php
			    }
			    ?>
			</select>
			 @if ($errors->has('y_search'))
			    <span class="help-block">
				<strong>{{ $errors->first('y_search',"This field is required") }}</strong>
			    </span>
			@endif	
		    </div>
		    <div class="col-md-2">
			<button type="submit" class="btn btn-primary">
			    Search
			</button>
		    </div>
		</div>
		
		</form>
	     </div>
	     <?php if(isset($payroll) && count($payroll) > 0){ ?>
	     <div class="col-md-6"><h2 class="sub-header pull-left">Search Result</h2>
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
		      
		      foreach($payroll as $value){  ?>		
		      <tr>
			  <td>{{ $i }}</td>
			  <td><?php $getuser = DB::table('users')->where('id', $value->user_id)->first(); ?>{{ $getuser->full_name }}</td>
			  <td>{{ $value->actual_working_days }} </td>
			  <td>{{ $value->unpaid_leave }}</td>
			  <td>{{ $value->total_salary }}</td>
			  <td>{{ $value->pay_day }}</td>
			  <td>
				<a href="{{ url("/payroll/export/".$value->id) }}" target="_blank" class="btn btn-primary">Export PDF</a>
				<a href="{{ url("/payroll/print/".$value->id) }}" target="_blank" class="btn btn-primary">Print</a>
			  </td>
		      </tr> 			     
		      <?php $i++; }  
		      ?>
		    </tbody>
		  </table>
		</div>
        </div>    <?php  } 		      
		      else{
		      echo '<tr><td>There is not data to display.</td></tr>';
		      } ?> 
@endsection
