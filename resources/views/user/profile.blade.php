@extends('layouts.app')

@section('content') 
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">View User Detail</h2>
		
             <form class="form-horizontal veiw_mode" role="form" method="POST" action="">
             	<div class="form-group">
		    <label class="col-md-4 control-label">User Name</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="user_name" value="{{ $user->user_name }}" readonly="readonly">		
		    </div>		    
		</div>  
		<div class="form-group">
		    <label class="col-md-4 control-label">Full Name</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="full_name" value="{{ $user->full_name }}" readonly="readonly">		
		    </div>		    
		</div>  		
		<div class="form-group">
                        <label class="col-md-4 control-label"></label>
			<div class="col-md-2">                               
			    <input type="text" class="form-control" value="{{ $user->gender }}" readonly="readonly">		   
			</div>
			<div class="col-md-2">     
			    <input type="text" class="form-control" value="{{ $user->maritalstatus }}" readonly="readonly">		   
			</div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Date of Birth</label>
		    <?php $day = date('d',strtotime($user->dob));
		          $month = date('m',strtotime($user->dob));
			  $year = date('Y',strtotime($user->dob));
		    ?>
		    <div class="col-md-1">
			<input type="text" value="{{ $day }}" class="form-control" readonly="readonly">
		    </div>
		     <div class="col-md-1">
			 <input type="text" value="{{ $month }}" class="form-control" readonly="readonly">
		    </div>
		     <div class="col-md-2">
			 <input type="text" value="{{ $year }}" class="form-control" readonly="readonly">
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Country of Birth</label>
		    <div class="col-md-4">         
			<?php $getval = DB::table('country')->where('id', $user->country_of_birth)->first(); ?>
			<input type="text" value="{{ $getval->country_name }}" class="form-control" readonly="readonly">		
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Nationality</label>
		    <div class="col-md-4">
			<?php $getval = DB::table('nationality')->where('id', $user->nationality)->first(); ?>
			<input type="text" value="{{ $getval->nationality_name }}" class="form-control" readonly="readonly">		
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Race</label>
		    <div class="col-md-4">  
			<?php $getval = DB::table('race')->where('id', $user->race)->first(); ?>
			<input type="text" value="{{ $getval->race_name }}" class="form-control" readonly="readonly">		
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">FIN/ NIRC</label>		    
		    <div class="col-md-4">
			<input type="text" value="{{ $user->nirc }}" class="form-control" readonly="readonly">
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Work Commencement Date</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" value="{{ date('d-m-Y',strtotime($user->start_employment)) }}" readonly="readonly">
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">End of Working Date</label>
		    <div class="col-md-4">
			<?php
			if($user->leave_employment == '0000-00-00'){
			    $leave_date = "-";
			}
			else{
			    $leave_date = date('d-m-Y',strtotime($user->leave_employment));
			}
			?>
			<input type="text" value="{{ $leave_date }}" class="form-control" readonly="readonly">
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Position</label>
		    <div class="col-md-4">
			<input type="text" value="{{ $user->position }}" class="form-control" readonly="readonly">		
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Email</label>
		    <div class="col-md-4">
			<input type="text" value="{{ $user->email }}" class="form-control" readonly="readonly">
		    </div>
		</div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Phone</label>
		    <div class="col-md-4">
			<input type="text" value="{{ $user->phone }}" class="form-control" readonly="readonly">
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Address</label>
		    <div class="col-md-4">
			<textarea class="form-control" readonly="readonly">{{ $user->address }}</textarea>
		    </div>
		</div> 
		<div class="form-group">
		     <label class="col-md-4 control-label"></label>
		     <div class="col-md-2">
			<input type="text" value="{{ $user->pass_status }}" class="form-control" readonly="readonly">			
		    </div>
		   <div class="col-md-2">                               
			<input type="text" value="{{ $user->time_shift }}" class="form-control" readonly="readonly">		
		    </div>
		</div>  
			
		<div class="form-group">
		    <label class="col-md-4 control-label">Agency</label>
		    <div class="col-md-4">                               
			<input type="text" value="{{ $user->agency }}" class="form-control" readonly="readonly">		
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Pay Status</label>

		    <div class="col-md-4">                               
			<input type="text" value="{{ $user->pay_status }}" class="form-control" readonly="readonly">			
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label"></label>
		    <div class="col-md-2">   
			    <?php 
			    if($user->cpf_status == 1){
				$cstatus = "checked";
			    }else{
				$cstatus = "";
			    } ?>
			<input type="checkbox" name="cpf_status" <?php echo $cstatus; ?> disabled="disable">&nbsp;
			CPF status
			
		    </div>
		    <div class="col-md-2"> 
			<?php 
			if($user->levy_status == 1){
			    $cstatus = "checked";
			}else{
			    $cstatus = "";
			} ?>
			<input type="checkbox" name="levy_status" <?php echo $cstatus; ?> disabled="disable">&nbsp;
			Levy status	
			@if($user->levy_status == 1)
			<input type="text" value="<?php echo $user->levy_val; ?>" class="form-control" readonly/>
			@endif
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Housing Fee</label>

		    <div class="col-md-4">
			<input type="text" value="{{ $user->housing_fee }}" class="form-control" readonly="readonly">			
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Salary</label>

		    <div class="col-md-4">
			<input type="text" value="{{ $user->salary }}" class="form-control" readonly="readonly">			
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">User Role</label>
		    <div class="col-md-4">                               
			<input type="text" value="{{ $user->user_role }}" class="form-control" readonly="readonly">		
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Remark</label>
		    <div class="col-md-4">
			<textarea class="form-control" readonly="readonly">{{ $user->remark }}</textarea>
		    </div>
		</div> 
		 @if($user->image != "")
		 <div class="form-group">
		    <label class="col-md-4 control-label">Photo</label>
		    <div class="col-md-4">
			 <div style="border:#444 solid 2px;max-width:250px;max-height:250px;">
				<img src="<?php echo "../../images/user/".$user->image; ?>" style="width:100%">
			 </div>
		    </div>
		</div> 
		@endif
		
	     </form>
          </div>
     
@endsection
