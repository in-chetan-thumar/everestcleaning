@extends('layouts.app')
@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Add project</h2>
	    <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/project/list') }}" class="btn_back_onlystyle">Back</a>
		</div>
             <form class="form-horizontal" role="form" method="POST" action="{{ url('/project/save') }}">
                        {!! csrf_field() !!}
			
		<div class="form-group">
		    <label class="col-md-4 control-label">Client<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<select class="form-control" name="client_id">
			    <option value="">Client</option>
			   	 @foreach($client as $value)
			    <option value="<?php echo $value->id; ?>"><?php echo $value->cli_com_name; ?></option>
			     @endforeach
			</select>		
		    </div>
		</div>		
		<div class="form-group">
		    <label class="col-md-4 control-label">Project Name<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="project_name" value="{{ old('project_name') }}">
			@if ($errors->has('project_name'))
			    <span class="help-block">
				<strong>{{ $errors->first('project_name') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>		
		<div class="form-group">
		    <label class="col-md-4 control-label">Short Project Name for Invoice<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="project_shortname" value="{{ old('project_shortname') }}">
			@if ($errors->has('project_shortname'))
			    <span class="help-block">
				<strong>{{ $errors->first('project_shortname') }}</strong>
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
			<a href="{{ url('/project/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
		</form>
          </div>
     
@endsection
