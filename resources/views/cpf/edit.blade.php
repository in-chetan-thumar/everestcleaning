@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Edit CPF Aged Group</h2>
	   <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/cpf/list') }}" class="em_btn_back_onlystyle">Back</a>
		</div>
		 @if (session('status'))
		<div class="alert alert-success em_error_msg" role="alert">		   
		    {{ session('status') }}
		</div>
		@endif
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/cpf/edit') }}">
                        {!! csrf_field() !!}
		<input type="hidden" name="id" value="{{ $cpf->id }}"/>
		<div class="form-group">
		    <label class="col-md-4 control-label">Employee Age(Year) <span class="add_redcolor">*</span></label>
		    <div class="col-md-1">
			<input type="number" class="form-control" name="aged_from" value="{{ $cpf->aged_from }}" min="0">
			@if ($errors->has('aged_from'))
			    <span class="help-block">
				<strong>{{ $errors->first('aged_from') }}</strong>
			    </span>
			@endif			
		    </div>
		    <div class="col-md-2">
			<select class='form-control get_cpf_type' name="cpf_type">
			    <option value='to' @if($cpf->cpf_type == 'to') {{ 'selected' }} @endif>to</option>
			    <option value='andabove' @if($cpf->cpf_type == 'andabove') {{ 'selected' }} @endif>and above</option>
			    <option value='andbelow' @if($cpf->cpf_type == 'andbelow') {{ 'selected' }} @endif>and below</option>			    
			</select>
		    </div>
		    <div class="col-md-1">
			<input type="number" class="form-control aged_to_class" name="aged_to" value="{{ $cpf->aged_to }}" min="0" >
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
			<input type="number" class="form-control" name="employer_rate" value="{{ $cpf->employer_rate }}" min="0">
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
			<input type="number" class="form-control" name="employee_rate" value="{{ $cpf->employee_rate }}" min="0">
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
			    Update
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
