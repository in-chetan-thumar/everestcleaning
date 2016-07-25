@extends('layouts.app')

@section('content') 
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">View User Detail</h2>
		<div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/userrole/list') }}" class="em_btn_back_onlystyle">Back</a>
		</div>
             <form class="form-horizontal veiw_mode" role="form" method="POST" action="">
		<div class="form-group">
		    <label class="col-md-4 control-label">Name</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" readonly="readonly" value="{{ $userrole->role_name }}" >		
		    </div>
		</div>  		
		<div class="form-group">
		    <label class="col-md-4 control-label">Credential</label>
		    <div class="col-md-4">
			<?php 
			$getlog  = explode(',',$userrole->credential_list);
			foreach($usercredential as $value){
			?>
			<input type="checkbox" @if(in_array($value->id,$getlog)) {{ 'checked' }} @endif disabled>&nbsp;{{ $value->p_name }}<br/><br/>
			<?php
			}
			?>
		    </div>
		</div> 
		 <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
			 <a href="{{ url('/userrole/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
	     </form>
          </div>
     
@endsection
