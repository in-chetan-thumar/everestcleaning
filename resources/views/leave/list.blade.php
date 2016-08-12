@extends('layouts.app')
@section('content')  
<link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
	<div class="col-sm-9 col-md-10 content_wrapper">
	    <h2 class="sub-header">Add employee leave</h2>
		<div>
			<form class="form-horizontal" role="form" method="POST" action="{{ url('/leave/create') }}">
				{!! csrf_field() !!}
				<div class="form-group">
					<div class="col-md-3">
						<select class="form-control" name="employee_id" id="employee_id">
							<option value="">Select employee</option>
							<?php
								foreach($employeeList As $employee){			   
									echo "<option value='".$employee->id."'>".$employee->full_name."</option>";
								}
							?>
						</select>
					</div>
					<div class="col-md-2">
						<input type="text" class="form-control form_date" id="leave_date" name="leave_date" data-format="yyyy-MM-dd" readonly >
					</div>
					<div class="col-md-3">
						<select id="leave_type" name="leave_type" class="form-control col-md-2">
							<option value="">Leave type</option>
							<option value="urgent">Urgent(Paid or Unpaid)</option>
							<option value="annual">Annual</option>
							<option value="medical_hospitalisation">Medical Hospitalisation</option>
							<option value="medical_non_hospitalisation">Medical Non Hospitalisation</option>
							<option value="compensation">Compensation</option>
						</select>
					</div>
					<div class="col-md-2" id="is_paid_div" style="display:none;">
						<input type="radio" name="is_paid" value="Y" selected> Paid &nbsp;&nbsp;
						<input type="radio" name="is_paid" value="N"> Unpaid 
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary" id="save_leave">
							Save
						</button>
					</div>
				</div>		
			</form>
		</div>
	</div>
	<div class="col-sm-9 col-md-10 content_wrapper"><br></div>
	<div class="col-sm-9 col-md-10 content_wrapper">
	    <div class="col-md-6"><h2 class="sub-header pull-left">Leave List</h2></div>
	     <div class="clearfix"></div>
          <div class="table-responsive margintop20">
			@if($leaveList AND count($leaveList) > 0)
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Employee Name</th>
							<th>Date</th>
							<th>Leave type</th>
							<th>Paid / Unpaid</th>
						</tr>
					</thead>
					<tbody>
						@foreach($leaveList AS $key => $leave)
							<tr>
								<th>{{ $key + 1}}</th>
								<td>{{ $leave->full_name }}</td>
								<td>{{ $leave->date }}</td>
								<td>{{ ucfirst(str_replace("_", " ", $leave->leave_type)) }}
								</td>
								<td> 
									@if($leave->is_paid == "Y") 
										Paid
									@else
										Unpaid
									@endif
									
									@if($leave->is_hospitalisation_leave == "Y") 
										(Hospitalisation)
									@elseif($leave->is_hospitalisation_leave == "N") 
										(Non Hospitalisation)
									@endif
								</td>
							</tr>
						@endforeach
				  </tbody>
				</table>
			@else
				There is not data to display.
			@endif
          </div>
    </div>

<script>
$('.form_date').datetimepicker({               
	format: 'yyyy-mm-dd',
	startView: 'month',
	minView: 'month',
	autoclose: true   
});

$(document).ready(function(){
   
	$("#save_leave").on('click', function(){
		if($("#employee_id option:selected").val() == ""){
			alert("Please select employee");
			return false;
		}
		
		if($("#leave_date").val() == ""){
			alert("Please select date");
			return false;
		}
		
		if($("#leave_type option:selected").val() == ""){
			alert("Please select leave type");
			return false;
		}
	});

	$('#employee_id').change(function (){
		if($("#leave_date").val() != ""){
			$.ajax({url: "leave/validate?employee_id="+$(this).find('option:selected').val()+"&leave_date="+$("#leave_date").val(), 
				success: function(result){
					if(result.response == "success"){
						$("#leave_type").html(result.data);
					}else{
						alert(result.message);
					}			
				}
			});
		}		
	});
	
	$('#leave_date').change(function (){
		if($("#employee_id option:selected").val() != ""){
			$.ajax({url: "leave/validate?employee_id="+$("#employee_id option:selected").val()+"&leave_date="+$("#leave_date").val(), 
				success: function(result){
					if(result.response == "success"){
						$("#leave_type").html(result.data);
					}else{
						alert(result.message);
					}			
				}
			});
		}		
	});
	
	$('#leave_type').change(function (){
		if($(this).find('option:selected').val() == "urgent" || $(this).find('option:selected').val() == "compensation"){
			$("#is_paid_div").show();
		}else{
			$("#is_paid_div").hide();
		}
	});
});
</script>
@endsection