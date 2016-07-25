@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Edit client</h2>
	   <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/client/list') }}" class="em_btn_back_onlystyle">Back</a>
		</div>
		 @if (session('status'))
		<div class="alert alert-success em_error_msg" role="alert">		   
		    {{ session('status') }}
		</div>
		@endif
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/client/edit') }}">
        {!! csrf_field() !!}
		<input type="hidden" name="id" value="{{ $client->id }}"/>
		<div class="form-group">
		    <label class="col-md-4 control-label">Name <span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="cli_com_name" value="{{ $client->cli_com_name }}" min="0">
			@if ($errors->has('cli_com_name'))
			    <span class="help-block">
				<strong>{{ $errors->first('cli_com_name') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>		
		<div class="form-group">
			    <label class="col-md-4 control-label">Phone<span class="add_redcolor"></span></label>
			    <div class="col-md-4">
				<input type="text" class="form-control" name="cli_com_phone" value="{{ $client->cli_com_phone }}">
				@if ($errors->has('cli_com_phone'))
				    <span class="help-block">
					<strong>{{ $errors->first('cli_com_phone') }}</strong>
				    </span>
				@endif			
			    </div>
			</div>	
			<div class="form-group">
			    <label class="col-md-4 control-label">Address<span class="add_redcolor">*</span></label>
			    <div class="col-md-4">
				<textarea class="form-control summernote" name="cli_com_address" rows="10">{{ $client->cli_com_address }}</textarea>
				@if ($errors->has('cli_com_address'))
				    <span class="help-block">
					<strong>{{ $errors->first('cli_com_address') }}</strong>
				    </span>
				@endif			
			    </div>
			</div>	
			<h3>Contact Person</h3>
			 <table class="table">
			 	<tr>
			 		<th>Name</th><th>Email</th><th>Phone</th><th>Position</th>
			 	</tr>
			    <?php
			    foreach($client_contactperson as $value){
			    ?>
			    <tr id="row">
			 		<input type="hidden" name="getall_contact[]" value=<?php echo $value->id; ?>/>
			 		<td><input type="text" class="form-control" name="cname[]" value=<?php echo $value->cli_cname; ?>></td>
			 		<td><input type="email" class="form-control" name="cemail[]" value=<?php echo $value->cli_cemail; ?>></td>
			 		<td><input type="phone" class="form-control" name="cphone[]" value=<?php echo $value->cli_cphone; ?>></td>
			 		<td><input type="text" class="form-control" name="cposition[]" value=<?php echo $value->cli_cposition; ?>></td>
			 	</tr>
			    <?php
			    }
			    $count_client_row = count($client_contactperson);
			    if($count_client_row == 3){ $count_client = 0; }
			    if($count_client_row == 2){ $count_client = 1; }
			    if($count_client_row == 1){ $count_client = 2; }
			    if($count_client_row == 0){ $count_client = 3; }

			    for($i=0;$i<$count_client;$i++){
			    ?>
			    <tr id="row">
			 		<input type="hidden" name="getall_contact[]"/>
			 		<td><input type="text" class="form-control" name="cname[]"></td>
			 		<td><input type="email" class="form-control" name="cemail[]"></td>
			 		<td><input type="phone" class="form-control" name="cphone[]"></td>
			 		<td><input type="text" class="form-control" name="cposition[]"></td>
			 	</tr>
			    <?php
			    }
			 	?>
			 </table>	
		<div class="form-group">
            <div class="col-md-6 col-md-offset-4">
			<button type="submit" class="btn btn-primary">
			    Update
			</button>
			<button type="reset" class="btn btn btn-info">
			    Cancel
			</button>
			<a href="{{ url('/client/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
		</form>
          </div>
     
@endsection
