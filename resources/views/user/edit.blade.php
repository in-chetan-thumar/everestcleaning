@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Edit User Info</h2>
	   <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/user/list') }}" class="em_btn_back_onlystyle">Back</a>
		</div>
		 @if (session('status'))
		<div class="alert alert-success em_error_msg" role="alert">		   
		    {{ session('status') }}
		</div>
		@endif
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/user/edit') }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
		<input type="hidden" name="id" value="{{ $user->id }}"/>
		<div class="form-group">
		    <label class="col-md-4 control-label">User Name</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="user_name" value="{{ $user->user_name }}" >	
			@if ($errors->has('user_name'))
			    <span class="help-block">
				<strong>{{ $errors->first('user_name') }}</strong>
			    </span>
			@endif	
		    </div>
		</div>  
		<div class="form-group">
		    <label class="col-md-4 control-label">Full Name</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="full_name" value="{{ $user->full_name }}" >	
			@if ($errors->has('full_name'))
			    <span class="help-block">
				<strong>{{ $errors->first('full_name') }}</strong>
			    </span>
			@endif	
		    </div>
		</div>  		
		<div class="form-group">
                        <label class="col-md-4 control-label"></label>
			<div class="col-md-2">   
			    <select class="form-control" name="gender" >
				<option value="">Gender</option>
				<option value="female" @if($user->gender == 'female') {{ 'selected' }} @endif)>Female</option>
				<option value="male" @if($user->gender == 'male') {{ 'selected' }} @endif>Male</option>
			    </select>	
			    @if ($errors->has('gender'))
			    <span class="help-block">
				<strong>{{ $errors->first('gender') }}</strong>
			    </span>
			    @endif				    
			</div>
			<div class="col-md-2">                               
			    <select class="form-control" name="marital_status" >
				<option value="">Marital Status</option>
				<option value="single" @if($user->maritalstatus == 'single') {{ 'selected' }} @endif>Single</option>
				<option value="married" @if($user->maritalstatus == 'married') {{ 'selected' }} @endif>Married</option>
				<option value="separated" @if($user->maritalstatus == 'separated') {{ 'selected' }} @endif>Separated</option>
				<option value="other" @if($user->maritalstatus == 'other') {{ 'selected' }} @endif>Other</option>
			    </select>	
			     @if ($errors->has('marital_status'))
			    <span class="help-block">
				<strong>{{ $errors->first('marital_status') }}</strong>
			    </span>
			    @endif
			</div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Date of Birth</label>
		    <?php $day = date('d',strtotime($user->dob));
		    
		          $month = date('m',strtotime($user->dob));
			  $year = date('Y',strtotime($user->dob));
			
		    ?>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="dob" value="{{ date('d-m-Y',strtotime($user->dob)) }}" id="j_datepicker2">
			@if ($errors->has('dob'))
			    <span class="help-block">
				<strong>{{ $errors->first('dob') }}</strong>
			    </span>
			@endif	
		    </div>		   
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Country of Birth</label>
		    <div class="col-md-4">                               
			<select class="form-control" name="country_of_birth" >
			    <option value="">Choose country</option>
			    @foreach($country as $value)
			    <option value="{{ $value->id }}" @if($value->id == $user->country_of_birth) {{ 'selected' }} @endif>{{ $value->country_name }}</option>
			    @endforeach
			</select>
			@if ($errors->has('country_of_birth'))
			    <span class="help-block">
				<strong>{{ $errors->first('country_of_birth') }}</strong>
			    </span>
			@endif				
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Nationality</label>
		    <div class="col-md-4">                               
			<select class="form-control" name="nationality" >
			    <option value="">Choose nationality</option> 
			    @foreach($nationality as $value)
			    <option value="{{ $value->id }}" @if($value->id == $user->nationality) {{ 'selected' }} @endif>{{ $value->nationality_name }}</option>
			    @endforeach
			</select>	
			@if ($errors->has('nationality'))
			    <span class="help-block">
				<strong>{{ $errors->first('nationality') }}</strong>
			    </span>
			@endif	
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Race</label>
		    <div class="col-md-4">                               
			<select class="form-control" name="race" >
			    <option value="">Choose race</option>
			    @foreach($race as $value)
			    <option value="{{ $value->id}}" @if($value->id == $user->race) {{ 'selected' }} @endif>{{ $value->race_name }}</option>
			   @endforeach
			</select>
			@if ($errors->has('race'))
			    <span class="help-block">
				<strong>{{ $errors->first('race') }}</strong>
			    </span>
			@endif				
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">FIN/ NIRC</label>		    
		    <div class="col-md-4">
			<input type="text" class="form-control" name="nirc" value="{{ $user->nirc }}" >
			@if ($errors->has('nirc'))
			    <span class="help-block">
				<strong>{{ $errors->first('nirc') }}</strong>
			    </span>
			@endif	
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Work Commencement Date</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="start_working_date" value="{{ $user->start_employment }}" id="j_datepicker">
			@if ($errors->has('start_working_date'))
			    <span class="help-block">
				<strong>{{ $errors->first('start_working_date') }}</strong>
			    </span>
			@endif	
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">End of Working Date</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="end_working_date" value="{{ $user->leave_employment }}" id="j_datepicker">
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Position</label>
		    <div class="col-md-4">
			<input type="" class="form-control" name="position" value="{{ $user->position }}" >
			@if ($errors->has('position'))
			    <span class="help-block">
				<strong>{{ $errors->first('position') }}</strong>
			    </span>
			@endif				
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Email</label>
		    <div class="col-md-4">
			<input type="email" class="form-control" name="email" value="{{ $user->email }}" >
			@if ($errors->has('email'))
			    <span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			    </span>
			@endif	
		    </div>
		</div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Password</label>
		    <div class="col-md-4">
			<input type="password" class="form-control" name="password" >
			@if ($errors->has('password'))
			    <span class="help-block">
				<strong>{{ $errors->first('password') }}</strong>
			    </span>
			@endif	
		    </div>
		</div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Confirm Password</label>
		    <div class="col-md-4">
			<input type="password" class="form-control" name="cpassword" >
			@if ($errors->has('cpassword'))
			    <span class="help-block">
				<strong>{{ $errors->first('cpassword') }}</strong>
			    </span>
			@endif	
		    </div>
		</div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Phone</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="phone" value="{{ $user->phone }}" >
			@if ($errors->has('phone'))
			    <span class="help-block">
				<strong>{{ $errors->first('phone') }}</strong>
			    </span>
			@endif	
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Address</label>
		    <div class="col-md-4">
			<textarea class="form-control" name="address">{{ $user->address }}</textarea>
			@if ($errors->has('address'))
			    <span class="help-block">
				<strong>{{ $errors->first('address') }}</strong>
			    </span>
			@endif	
		    </div>
		</div> 
		<div class="form-group">
		     <label class="col-md-4 control-label"></label>
		     <div class="col-md-2">
			<select class="form-control" name="pass_status" >
			     <option value="">Choose pass status</option>
			      @foreach($pass as $value)
				<option value="{{ $value->id }}" @if($value->id == $user->pass_status) {{ 'selected' }} @endif>{{ $value->pass_name }}</option>
				@endforeach
			</select>
			  @if ($errors->has('pass_status'))
			    <span class="help-block">
				<strong>{{ $errors->first('pass_status') }}</strong>
			    </span>
			@endif	
		    </div>
		   <div class="col-md-2">                               
			<select class="form-control" name="working_shift" >
			    <option value="">Choose time shift</option>
			     @foreach($wshift as $value)
				<option value="{{ $value->id }}" @if($value->id == $user->time_shift) {{ 'selected' }} @endif>{{ $value->wshift_name }}</option>
			     @endforeach
			</select>
			@if ($errors->has('working_shift'))
			    <span class="help-block">
				<strong>{{ $errors->first('working_shift') }}</strong>
			    </span>
			@endif			       
		    </div>
		</div>  
			
		<div class="form-group">
		    <label class="col-md-4 control-label">Agency</label>
		    <div class="col-md-4">                               
			<select class="form-control" name="agency" >
			    <option value="">Choose agency</option>
			    @foreach($agency as $value)
				<option value="{{ $value->id }}" @if($value->id == $user->agency) {{ 'selected' }} @endif>{{ $value->agency_name }}</option>
			    @endforeach
			</select>
			@if ($errors->has('agency'))
			    <span class="help-block">
				<strong>{{ $errors->first('agency') }}</strong>
			    </span>
			@endif				
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Pay Status</label>

		    <div class="col-md-4">                               
			<select class="form-control" name="pay_status" >
			    <option value="">Choose pay status</option>
			     <?php
				$sample = array('Fixed Pay','Pay By Hour');
				for($g=0;$g<count($sample);$g++){
				    $gg = $g+1;
				?>
				<option value="{{ $gg }}" @if($gg == $user->pay_status) {{ 'selected' }} @endif>{{ $sample[$g] }}</option>
				<?php
				}
			    ?>
			</select>
			@if ($errors->has('pay_status'))
			    <span class="help-block">
				<strong>{{ $errors->first('pay_status') }}</strong>
			    </span>
			@endif				
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
			<input type="checkbox" name="cpf_status" <?php echo $cstatus; ?>>&nbsp;
			CPF status			
		    </div>
		    <div class="col-md-2">   
			<?php 
			if($user->levy_status == 1){
			    $cstatus = "checked";
			}else{
			    $cstatus = "";
			} ?>			
			<input type="checkbox" name="levy_status" <?php echo $cstatus; ?> class="check_levy">&nbsp;
			Levy status		
			<input type="number" min="0" class="form-control get_levy" name="levy_val"/>
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Housing Fee</label>

		    <div class="col-md-4">
			<input type="text" class="form-control" name="housing_fee" value="{{ $user->housing_fee }}">			
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Salary</label>

		    <div class="col-md-4">
			<input type="text" class="form-control" name="salary" value="{{ $user->salary }}">	
			@if ($errors->has('salary'))
			    <span class="help-block">
				<strong>{{ $errors->first('salary') }}</strong>
			    </span>
			@endif	
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">User Role</label>
		    <div class="col-md-4">                               
			<select class="form-control" name="user_role" >
			    <option value="">Choose User Role</option>
			     @foreach($userrole as $value)
				<option value="{{ $value->id }}" @if($value->id == $user->user_role) {{ 'selected' }} @endif>{{ $value->role_name }}</option>
			     @endforeach
			</select>
			@if ($errors->has('user_role'))
			    <span class="help-block">
				<strong>{{ $errors->first('user_role') }}</strong>
			    </span>
			@endif				
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Remark</label>
		    <div class="col-md-4">
			<textarea class="form-control" name="remark">{{ $user->remark }}</textarea>
		    </div>
		</div> 
		@if($user->image != "")
		<div class="form-group">
		    <label class="col-md-4 control-label">Photo</label>
		    <div class="col-md-4">
			 <div style="border:#444 solid 2px;max-width:250px;max-height:250px;overflow:auto">
				<img src="<?php echo "../../images/user/".$user->image; ?>" style="width:100%">
			 </div>
		    </div>
		</div>
		@endif
		<div class="form-group">
		    <label class="col-md-4 control-label">Photo</label>
		    <div class="col-md-4">
			<input type='file' name='photo'/>
		    </div>
		</div> 
		<div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
			<button type="submit" class="btn btn-primary">
			    Update
			</button>
			<button type="reset" class="btn btn btn-info">
			    Cancel
			</button>
			<a href="{{ url('/user/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
		</form>
          </div>
     
@endsection
