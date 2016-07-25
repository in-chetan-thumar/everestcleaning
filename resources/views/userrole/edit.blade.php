@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Edit User Info</h2>
	   <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/userrole/list') }}" class="em_btn_back_onlystyle">Back</a>
		</div>
		 @if (session('status'))
		<div class="alert alert-success em_error_msg" role="alert">		   
		    {{ session('status') }}
		</div>
		@endif
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/userrole/edit') }}">
                        {!! csrf_field() !!}
		<input type="hidden" name="id" value="{{ $userrole->id }}"/>
		<div class="form-group">
		    <label class="col-md-4 control-label">Name</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="role_name" value="{{ $userrole->role_name }}" >
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
			<?php 
			$getlog  = explode(',',$userrole->credential_list);
			foreach($usercredential as $value){
			?>
			<input type="checkbox" name="credential_list[]" value="{{$value->id}}" @if(in_array($value->id,$getlog)) {{ 'checked' }}  @endif>&nbsp;{{ $value->p_name }}<br/><br/>
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
			    Update
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
