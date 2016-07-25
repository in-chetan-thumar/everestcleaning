@extends('layouts.app')
@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Add CPF Setting</h2>
	    <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/cpf/list') }}" class="btn_back_onlystyle">Back</a>
		</div>
             <form class="form-horizontal" role="form" method="POST" action="{{ url('/cpf/save') }}">
                        {!! csrf_field() !!}

		<div class="form-group">
		    <label class="col-md-4 control-label">Employee Age(Year) <span class="add_redcolor">*</span></label>
		    <div class="col-md-1">
			<input type="text" class="form-control" name="aged_from" value="{{ old('aged_from') }}" min="0">
			@if ($errors->has('aged_from'))
			    <span class="help-block">
				<strong>{{ $errors->first('aged_from') }}</strong>
			    </span>
			@endif			
		    </div>
		    <div class="col-md-2">
			<select class='form-control get_cpf_type' name="cpf_type">
			    <option value='to'>to</option>
			    <option value='andabove'>and above</option>
			    <option value='andbelow'>and below</option>			    
			</select>
		    </div>
		    <div class="col-md-1">
			<input type="text" class="form-control aged_to_class" name="aged_to" value="{{ old('aged_to') }}" min="0" >
			@if ($errors->has('aged_to'))
			    <span class="help-block">
				<strong>{{ $errors->first('aged_to') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>		
		<div class="form-group">
		    <label class="col-md-4 control-label">Employer Rate <span class="add_redcolor">*</span><p class='show_guide_label'>Percentage</p></label>
		    <div class="col-md-2">
			<input type="text" class="form-control" name="employer_rate" value="{{ old('employer_rate') }}" min="0">
			@if ($errors->has('employer_rate'))
			    <span class="help-block">
				<strong>{{ $errors->first('employer_rate') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Employee Rate <span class="add_redcolor">*</span><p class='show_guide_label'>Percentage</p></label>
		    <div class="col-md-2">
			<input type="text" class="form-control" name="employee_rate" value="{{ old('employee_rate') }}" min="0">
			@if ($errors->has('employee_rate'))
			    <span class="help-block">
				<strong>{{ $errors->first('employee_rate') }}</strong>
			    </span>
			@endif			
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
			<a href="{{ url('/cpf/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
		</form>
          </div>
     
@endsection
