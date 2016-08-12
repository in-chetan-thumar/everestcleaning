@extends('layouts.app')
@section('content')  
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <!--script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script-->
<script src="../js/fullcalendar.min.js"></script>
<link rel="stylesheet" href="../css/fullcalendar.min.css"/>
	
<link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>


<div class="col-sm-9 col-md-9 content_wrapper">
	<h2 class="sub-header">Scheduling of workers</h2>
	<div>
		<form class="form-horizontal" role="form" method="POST" action="{{ url('/schedule') }}">
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
					<button type="submit" class="btn btn-primary" id="view_schedule">
						View
					</button>
				</div>
				<div class="col-md-3">
					<button type="button" id="create_schedule" class="btn btn-primary">
						Create Schedule
					</button>
				</div>
			</div>		
		</form>
	</div>
	<div >
		<div  id="calendar"></div>
	</div>
	
<!-- Create Schedule Modal Dialog  -->
<div class="modal fade in" id="create_schedule_popup" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title" id="doc_title"><label class="control-label">Create Schedule</label></h4>
			</div>
			<div class="modal-body" id="doc_display_area" align="center">
				<form class="form-horizontal" role="form" id="create_schedule_form" method="POST" action="{{ url('/schedule') }}"  novalidate="novalidate">
					{!! csrf_field() !!}
						<div class="form-group">
							<label class="col-md-2 control-label">Project<span class="add_redcolor">*</span></label>
							<div class="col-md-4">
								<select class="form-control" name="project_id" id="project_id">
									<option class="" value="">Project</option>
									 @foreach($projects as $project)
									<option value="<?php echo $project->id; ?>"><?php echo $project->project_name; ?></option>
									 @endforeach
								</select>	
							</div>
							<label class="col-md-2 control-label">Date<span class="add_redcolor">*</span></label>
							<div class="col-md-4">
							<input type="text" class="form-control form_date" id="schedule_date" name="schedule_date" value="" data-format="yyyy-MM-dd" readonly >
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label">Select Month</label> 
							<div class="col-md-10" style="text-align: left;">
							<?php $i = 1;
								foreach($month_list as $key => $month){									
									echo '<input type="checkbox" id="selected_month" name="selected_month[]" value="'.$key.'"> '.$month.' &nbsp;&nbsp;&nbsp;';
									if($i > 3){  echo "<br>"; $i=0;} $i++;
								}
							?>
							</div>
							
						</div>
					
							<table class="table table-bordered schedule_table" id="schedule_table" style="margin-bottom: 0px;">
								<tr><td></td>
									<td><label class="control-label">Employee</label></td>
									<td width="200"><label class="control-label">Time</label></td>
									<td width="120"><label class="control-label">Rate</label></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<select class="form-control employee_id required" name="employee_id[0]" >
											<option value="">Select Employee</option>
											 @foreach($users as $user)
											<option value="<?php echo $user->id; ?>"><?php echo $user->full_name; ?></option>
											 @endforeach
										</select>
									</td>
									
									<td>
										<select class="form-control start_time" name="start_time[0]" id="start_time" style="width: 80px;float:left; padding-left:0px;">
											<?php foreach($time_list As $time){
													echo '<option value='.$time.'>'.$time.'</option>';
												}
											?>
										</select> &nbsp; To 
										<select class="form-control end_time" name="end_time[0]" id="end_time" style="width: 80px;float:right; padding-left:0px;">
											<?php foreach($time_list As $key => $time){
													if($key == "0") continue;
													echo '<option value='.$time.'>'.$time.'</option>';
												}
											?>
										</select>
									</td>
									<td>
										&nbsp;$&nbsp;
										<input type="number" class="form-control" name="rate[0]" value="1" min="1" style="width: 80px; float:left">
									</td>
								</tr>
							</table>
							<table class="table" style="margin-bottom: 0px;">
								<tr>
									<td><i class="fa fa-plus addrow" data-id="1"></i></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</table>
						
						<div class="form-group">
							<div class="col-md-12">
								<button type="submit" class="btn btn-primary pull-right" name="save_schedule" id="save_schedule">Save</button>
							</div>
						</div>
							
				</form>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!--  Modal End -->
	
</div>
<script>
 $('.form_date').datetimepicker({               
	format: 'yyyy-mm-dd',
	startView: 'month',
	minView: 'month',
	autoclose: true   
});

$(document).ready(function(){
    $(".addrow").click(function(){
		//options = $('#employee_id option');
		//alert(options);
		var id = $(this).data("id");
		$(this).data("id", id+1);
		employee_options = $('.employee_id').html();
		end_time_options = $('.end_time').html();
		start_time_options = $('.start_time').html();
        $("#schedule_table").append('<tr><td><i class="fa fa-minus remrow"></i></td><td style="padding: 5px; "><select class="employee_id form-control" name="employee_id[]">'+employee_options+'</select></td><td style="padding: 5px;line-height: 30px;"><select style="width: 80px;float:left; padding-left:0px;" class="form-control" name="start_time[]" id="start_time">'+start_time_options+'</select> &nbsp;To <select style="width: 80px; float:right; padding-left:0px;" class="form-control" name="end_time[]" id="end_time">'+end_time_options+'</select></td><td>&nbsp;$&nbsp;<input type="number" class="form-control" name="rate[]" value="1" min="1" style="width: 80px; float:left"></td></tr>');
    });
    $("#schedule_table").on('click','.remrow',function(){
        $(this).parent().parent().remove();
    });
	
	$("#save_schedule").on('click', function(){
		if($("#project_id option:selected").val() == ""){
			alert("Please select project");
			return false;
		}
		
		if($("#schedule_date").val() == ""){
			alert("Please select date");
			return false;
		}

		if($("input[type=checkbox]:checked").length == "0"){
			alert("Please select month");
			return false;
		}
	});

	$("#create_schedule_form").validate({
		rules: {
			'employee_id[]': {
				required: true
			}
		},
		
		submitHandler: function(form) {
			form.submit();
		}
	});
	
	$("#view_schedule").on('click', function(){
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
	
	
	if($("#view_project_id option:selected").val() != ""){
		var project_id = $("#view_project_id option:selected").val();
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			defaultDate: '<?php echo $calendarDate;?>',
			selectable: true,
			selectHelper: true,
			select: function(start, end) {
				var title = prompt('Event Title:');
				var eventData;
				if (title) {
					eventData = {
						title: title,
						start: start,
						end: end
					};
					$('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
				}
				$('#calendar').fullCalendar('unselect');
			},
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events:{
				url: 'schedule/scheduleemployeelist?project_id='+project_id,
				error: function() {
					$('#script-warning').show();
				}
			},
			eventRender: function(event, element) {
				element.append( "<span class='closeon'>X</span>" );
				element.find(".closeon").click(function() {
					if(confirm("Are you sure you want to remove " + event.title + " ?")) {
						// delete event in backend
						jQuery.get(
							"/schedule/delete/"+event.id
							//, { "id": calEvent.id }
						);
						// delete in frontend
						$('#calendar').fullCalendar('removeEvents', event.id);
					}
				 
				});
			},
			loading: function(bool) {
				$('#loading').toggle(bool);
			}
		});
	}
	
});
</script>
@endsection