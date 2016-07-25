@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Edit nationality</h2>
	   <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/nationality/list') }}" class="em_btn_back_onlystyle">Back</a>
		</div>
		 @if (session('status'))
		<div class="alert alert-success em_error_msg" role="alert">		   
		    {{ session('status') }}
		</div>
		@endif
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/nationality/edit') }}">
                        {!! csrf_field() !!}
		<input type="hidden" name="id" value="{{ $nationality->id }}"/>
		<div class="form-group">
		    <label class="col-md-4 control-label">Name<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="nationality_name" value="{{ $nationality->nationality_name }}" min="0">
			@if ($errors->has('nationality_name'))
			    <span class="help-block">
				<strong>{{ $errors->first('nationality_name') }}</strong>
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
			<a href="{{ url('/nationality/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
		</form>
          </div>
     
@endsection
