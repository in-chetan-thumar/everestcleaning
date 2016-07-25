@extends('layouts.app')
@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Add shift</h2>
	    <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/workshift/list') }}" class="btn_back_onlystyle">Back</a>
		</div>
             <form class="form-horizontal" role="form" method="POST" action="{{ url('/workshift/save') }}">
                        {!! csrf_field() !!}

		<div class="form-group">
		    <label class="col-md-4 control-label">Shift<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="wshift_name" value="{{ old('wshift_name') }}">
			@if ($errors->has('wshift_name'))
			    <span class="help-block">
				<strong>{{ $errors->first('wshift_name') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Total working days<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="total_working_days" value="@if(old('total_working_days') !== null){{ old('total_working_days') }} else{{ '0' }} @else {{'0' }} @endif" >
			@if ($errors->has('total_working_days'))
			    <span class="help-block">
				<strong>{{ $errors->first('total_working_days') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Working hours per day<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="working_hour" value="{{ old('working_hour') }}">
			@if ($errors->has('working_hour'))
			    <span class="help-block">
				<strong>{{ $errors->first('working_hour') }}</strong>
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
			<a href="{{ url('/workshift/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
		</form>
          </div>
     
@endsection
