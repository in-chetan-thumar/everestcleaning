@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Edit country</h2>
	   <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/country/list') }}" class="em_btn_back_onlystyle">Back</a>
		</div>
		 @if (session('status'))
		<div class="alert alert-success em_error_msg" role="alert">		   
		    {{ session('status') }}
		</div>
		@endif
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/country/edit') }}">
                        {!! csrf_field() !!}
		<input type="hidden" name="id" value="{{ $country->id }}"/>
		<div class="form-group">
		    <label class="col-md-4 control-label">Name <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="country_name" value="{{ $country->country_name }}" min="0">
			@if ($errors->has('country_name'))
			    <span class="help-block">
				<strong>{{ $errors->first('country_name') }}</strong>
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
			<a href="{{ url('/country/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
		</form>
          </div>
     
@endsection
