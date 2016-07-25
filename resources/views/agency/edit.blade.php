@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Edit agency</h2>
	   <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/agency/list') }}" class="em_btn_back_onlystyle">Back</a>
		</div>
		 @if (session('status'))
		<div class="alert alert-success em_error_msg" role="alert">		   
		    {{ session('status') }}
		</div>
		@endif
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/agency/edit') }}">
                        {!! csrf_field() !!}
		<input type="hidden" name="id" value="{{ $agency->id }}"/>
		<div class="form-group">
		    <label class="col-md-4 control-label">Name <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="agency_name" value="{{ $agency->agency_name }}" min="0">
			@if ($errors->has('agency_name'))
			    <span class="help-block">
				<strong>{{ $errors->first('agency_name') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Fund <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="agency_fund" value="{{ $agency->agency_fund }}" min="0">
			@if ($errors->has('agency_fund'))
			    <span class="help-block">
				<strong>{{ $errors->first('agency_fund') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Description <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<textarea class="form-control" name="agency_des" value="{{ $agency->agency_description }}"></textarea>
			@if ($errors->has('agency_des'))
			    <span class="help-block">
				<strong>{{ $errors->first('agency_des') }}</strong>
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
			<a href="{{ url('/agency/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
		</form>
          </div>
     
@endsection
