@extends('layouts.app')
@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Add User Credential</h2>
	    <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/userrole/list') }}" class="btn_back_onlystyle">Back</a>
		</div>
             <form class="form-horizontal" role="form" method="POST" action="{{ url('/userrole/save') }}">
                        {!! csrf_field() !!}

		<div class="form-group">
		    <label class="col-md-4 control-label">Name</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="role_name" value="{{ old('role_name') }}" >
			@if ($errors->has('role_name'))
			    <span class="help-block">
				<strong>{{ $errors->first('role_name') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>  		
		<div class="form-group">
		    <label class="col-md-4 control-label">Credential</label>
		    <div class="col-md-4">
			<?php $user_cre_array = array();
			foreach($usercredential as $value){	
			?>
			<input type="checkbox" name='credential_list[]' value="{{$value->id }}"/>&nbsp;{{ $value->p_name }}
			<br/>
			<br/>
			<?php
			}
?>
			@if ($errors->has('credential_list'))
			    <span class="help-block">
				<strong>{{ $errors->first('credential_list') }}</strong>
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
			<a href="{{ url('/userrole/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
		</form>
          </div>
     
@endsection
