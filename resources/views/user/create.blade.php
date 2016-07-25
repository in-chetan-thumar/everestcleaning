@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Add Employee Info</h2>
	    <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/user/list') }}" class="em_btn_back_onlystyle">Back</a>
		</div>
             <form class="form-horizontal" role="form" method="POST" action="{{ url('/user/save') }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}
        <div class="form-group">
		    <label class="col-md-4 control-label">User Name <span class="add_redcolor">*</span><p class="show_guide_label">User name only allows small letters and numbers</p></label>
		    <div class="col-md-4">
			<input type="text" class="form-control check_valid_uname" name="user_name" value="{{ old('user_name') }}" autocomplete="off">
			@if ($errors->has('user_name'))
			    <span class="help-block">
				<strong>{{ $errors->first('user_name') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>  
		<div class="form-group">
		    <label class="col-md-4 control-label">Full Name <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="full_name" value="{{ old('name') }}" autocomplete="off">
			@if ($errors->has('full_name'))
			    <span class="help-block">
				<strong>{{ $errors->first('full_name') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>  		
		<div class="form-group">
                        <label class="col-md-4 control-label">Status <span class="add_redcolor">*</span></label>
			<div class="col-md-2">                         
			    <select class="form-control" name="gender" >
				<option value="">Gender</option>				
				<option value="male">Male</option>
				<option value="female">Female</option>
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
				<option value="single">Single</option>
				<option value="married">Married</option>
				<option value="separated">Separated</option>
				<option value="other">Other</option>
			    </select>	
			    @if ($errors->has('marital_status'))
			    <span class="help-block">
				<strong>{{ $errors->first('marital_status') }}</strong>
			    </span>
			    @endif	
			</div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Date of Birth <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="dob" value="{{ old('dob') }}" id="j_datepicker2" autocomplete="off">
			@if ($errors->has('dob'))
			    <span class="help-block">
				<strong>{{ $errors->first('dob') }}</strong>
			    </span>
			@endif	
		    </div>		    
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Country of Birth <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">                               
			<select class="form-control" name="country_of_birth" >
			   <option value="">Choose country</option>
			    @foreach($country as $cvalue)
			    <option value="{{ $cvalue->id }}" @if($cvalue->id == old('country_of_birth')) {{ 'selected' }} @endif>{{ $cvalue->country_name }}</option>			      
			    @endforeach;
			</select>
			@if ($errors->has('country_of_birth'))
			    <span class="help-block">
				<strong>{{ $errors->first('country_of_birth') }}</strong>
			    </span>
			@endif				
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Nationality <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">                               
			<select class="form-control" name="nationality" >
			    <option value="">Choose country</option>
			    @foreach($nationality as $nvalue)
			    <option value="{{ $nvalue->id }}" @if($nvalue->id == old('nationality')) {{ 'selected' }} @endif>{{ $nvalue->nationality_name }}</option>
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
		    <label class="col-md-4 control-label">Race <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">                               
			<select class="form-control" name="race" >
			  <option value="">Choose race</option>
			    @foreach($race as $rvalue)
			    <option value="{{ $rvalue->id }}" @if($rvalue == old('race')) {{ 'selected' }} @endif>{{ $rvalue->race_name }}</option>
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
		    <label class="col-md-4 control-label">FIN/ NIRC <span class="add_redcolor">*</span></label>		    
		    <div class="col-md-4">
			<input type="text" class="form-control" name="nirc" value="{{ old('nirc') }}" >
			@if ($errors->has('nirc'))
			    <span class="help-block">
				<strong>{{ $errors->first('nirc') }}</strong>
			    </span>
			@endif	
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Work Commencement Date <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="start_working_date" value="{{ old('start_working_date') }}" id="j_datepicker">
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
			<input type="text" class="form-control" name="end_working_date" value="{{ old('end_working_date') }}" id="j_datepicker1">
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Position <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="" class="form-control" name="position" value="{{ old('position') }}" >	
			@if ($errors->has('position'))
			    <span class="help-block">
				<strong>{{ $errors->first('position') }}</strong>
			    </span>
			@endif	
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Email </label>
		    <div class="col-md-4">
			<input type="email" class="form-control" name="email" value="{{ old('email') }}" >
			<!-- @if ($errors->has('email'))
			    <span class="help-block">
				<strong>{{ $errors->first('email') }}</strong>
			    </span>
			@endif	-->
		    </div>
		</div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Password <span class="add_redcolor">*</span><p class="show_guide_label">Password must contain Letters,Capital Letter, Numbers and Special Character</p></label>
		    <div class="col-md-4">
			<input type="password" class="form-control" name="password" ><span class="add_redcolor">E.g: Everest2016!@#</span>
			@if ($errors->has('password'))
			    <span class="help-block">
				<strong>{{ $errors->first('password') }}</strong>
			    </span>
			@endif	
		    </div>
		</div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Confirm Password <span class="add_redcolor">*</span></label>
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
		    <label class="col-md-4 control-label">Phone <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="phone" value="{{ old('phone') }}" >
			@if ($errors->has('phone'))
			    <span class="help-block">
				<strong>{{ $errors->first('phone') }}</strong>
			    </span>
			@endif	
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Address <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<textarea class="form-control" name="address">{{ old('address') }}</textarea>
			@if ($errors->has('address'))
			    <span class="help-block">
				<strong>{{ $errors->first('address') }}</strong>
			    </span>
			@endif	
		    </div>
		</div> 
		<div class="form-group">
		     <label class="col-md-4 control-label">Status  <span class="add_redcolor">*</span></label>
		     <div class="col-md-2">
			<select class="form-control" name="pass_status" >
			    <option value="">Choose pass status</option>
			     @foreach($pass as $value)
				<option value="{{ $value->id }}" @if($value->id == old('pass_status')) {{ 'selected' }} @endif>{{ $value->pass_name }}</option>
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
			      @foreach($wshift as $wvalue)
				<option value="{{ $wvalue->id }}" @if($wvalue->id == old('working_shift')) {{ 'selected' }} @endif>{{ $wvalue->wshift_name }}</option>
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
		    <label class="col-md-4 control-label">Agency <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">                               
			<select class="form-control" name="agency" >
			    <option value="">Choose agency</option>
			    @foreach($agency as $avalue)
				<option value="{{ $avalue->id }}" @if($avalue->id == old('agency')) {{ 'selected' }} @endif>{{ $avalue->agency_name }}</option>
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
		    <label class="col-md-4 control-label">Pay Status <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">                               
			<select class="form-control" name="pay_status" >
			    <option value="">Choose pay status</option>
			     <?php
				$sample = array('Fixed Pay','Pay By Hour');
				for($g=0;$g<count($sample);$g++){
				    $gg = $g+1;
				?>
				<option value="{{ $gg }}" @if($gg == old('pay_status')) {{ 'selected' }} @endif>{{ $sample[$g] }}</option>
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
			<input type="checkbox" name="cpf_status">&nbsp;
			CPF status	
		    </div>
		    <div class="col-md-2">   			
			<input type="checkbox" name="levy_status" class="check_levy">&nbsp;
			Levy status	
			<input type="number" min="0" class="form-control get_levy" name="levy_val"/>
		    </div>
                </div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Housing Fee</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="housing_fee" value="{{ old('housing_fee') }}">	
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Salary  <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="salary" value="{{ old('salary') }}">	
			@if ($errors->has('salary'))
			    <span class="help-block">
				<strong>{{ $errors->first('salary') }}</strong>
			    </span>
			@endif	
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">User Role  <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">                               
			<select class="form-control" name="user_role" >
			    <option value="">Choose User Role</option>
			     @foreach($userrole as $uvalue)
				<option value="{{ $uvalue->id }}" @if($uvalue == old('user_role')) {{ 'selected' }} @endif>{{ $uvalue->role_name }}</option>
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
			<textarea class="form-control" name="remark">{{ old('remark') }}</textarea>
		    </div>
		</div> 
		<div class="form-group">
		    <label class="col-md-4 control-label">Photo</label>
		    <div class="col-md-4">
			<input type='file' name='photo'/>
		    </div>
		</div> 
		<div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
			<button type="submit" class="btn btn-primary">
			    Save
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
