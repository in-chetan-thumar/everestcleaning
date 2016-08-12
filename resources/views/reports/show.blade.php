@extends('layouts.app')
@section('content')  

<div class="col-sm-9 col-md-9 content_wrapper">
	<h2 class="sub-header">Report of workers</h2>
	<div>
		<form class="form-horizontal" role="form" method="POST" action="{{ url('/reports') }}">
            {!! csrf_field() !!}
			<div class="form-group">
				<div class="col-md-3">
					<select class="form-control" name="project_id" id="view_project_id">
						<option value="">Select project</option>
						<?php
							foreach($projects As $project){			   
								$selected = (isset($calendarData['project_id']) && $project->id == $calendarData['project_id'] ? "selected" : "");
								echo "<option ".$selected." value='".$project->id."'>".$project->project_name."</option>";
							}
						?>
					</select>
				</div>
				<div class="col-md-2">			 
					<select class="form-control col-md-2" name="month" id="view_month">
						<option value="">Month</option>
						<?php
							foreach($months As $key => $value){			   
								$selected = (isset($calendarData['month']) && $key == $calendarData['month'] ? "selected" : "");
								echo "<option ".$selected." value='".$key."'>".$value."</option>";
							}						?>
					</select>
				</div>
				<div class="col-md-2">
					<select class="form-control col-md-2" name="year" id="view_year">
						<option value="">Year</option>
						<?php 
							foreach($years As $key => $value){			   
								$selected = (isset($calendarData['year']) && $key == $calendarData['year'] ? "selected" : "");
								echo "<option ".$selected." value='".$key."'>".$value."</option>";
							}						?>
					</select>
				</div>
				<div class="col-md-2">
					<button type="submit" class="btn btn-primary" id="view_report">
						View
					</button>
				</div>
			</div>		
		</form>
	</div>
	@if($project_name AND $report_month)
	<div style="padding:10px;" class="col-sm-12">
		<div class="col-sm-9">
			<div style="padding:5px;"><b>Project Name: </b>{{ $project_name }}</div>
			<div style="padding:5px;"><b>Report for the month of: </b>{{ $report_month }}</div>
		</div>
		<div class="col-sm-3">
			<a class="btn btn-primary" target="_blank" href="reports/export/pdf/{{$calendarData['project_id']}}/{{$calendarData['month']}}/{{$calendarData['year']}}">Export PDF</a>
			<a class="btn btn-primary" target="_blank" href="reports/export/print/{{$calendarData['project_id']}}/{{$calendarData['month']}}/{{$calendarData['year']}}">Print</a>
		</div>
	</div>
	@endif
	@if($report_data AND $report_data)
	<div style="padding:10px;">
		<table class="table">
			<tr>
				<th>#</th>
				<th>Date</th>
				<th>time</th>
				<th>Worker</th>
				<th>Paid amount</th>
			</tr>
			<?php $g_total = 0;	?>
			@foreach($report_data as $key => $data)
				<tr>
					<th>{{ $key + 1}}</th>
					<td>{{ $data->date }}</td>
					<td>{{ $data->start_time }} to {{ $data->end_time }}</td>
					<td>{{ $data->full_name }}</td>
					<td>${{ $data->rate }}</td>
				</tr>
				<?php $g_total = $g_total + $data->rate; ?>
			@endforeach
			
			<tr>
				<th> </th>
				<th> </th>
				<th> </th>
				<th> Total Amount </th>
				<th>${{ $g_total}} </th>
			</tr>
		</table>
	</div>
	@endif
	
</div>
<script>
$(document).ready(function(){
   
	$("#view_report").on('click', function(){
		if($("#view_project_id option:selected").val() == ""){
			alert("Please select project");
			return false;
		}
		
		if($("#view_month option:selected").val() == ""){
			alert("Please select Month");
			return false;
		}
		
		if($("#view_year option:selected").val() == ""){
			alert("Please select Year");
			return false;
		}
	});	
});
</script>
@endsection