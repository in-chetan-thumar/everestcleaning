@extends('layouts.app')
@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Add client</h2>
	    <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/race/list') }}" class="btn_back_onlystyle">Back</a>
		</div>
             <form class="form-horizontal" role="form" method="POST" action="{{ url('/client/save') }}">
                        {!! csrf_field() !!}

			<div class="form-group">
			    <label class="col-md-4 control-label">Name<span class="add_redcolor">*</span></label>
			    <div class="col-md-4">
				<input type="text" class="form-control" name="cli_com_name" value="{{ old('cli_com_name') }}">
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
				<input type="text" class="form-control" name="cli_com_phone" value="{{ old('cli_com_phone') }}">
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
				<textarea class="form-control summernote" name="cli_com_address" rows="10">{{ old('cli_com_address') }}</textarea>
				@if ($errors->has('cli_com_address'))
				    <span class="help-block">
					<strong>{{ $errors->first('cli_com_address') }}</strong>
				    </span>
				@endif			
			    </div>
			</div>		
			<div>
			 <h3>Contact Person</h3>
			 <table class="table">
			 	<tr>
			 		<th>Name</th><th>Email</th><th>Phone</th><th>Position</th>
			 	</tr>
			    <?php
			    
			    for($i=0;$i<3;$i++){
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
			</div>	
			<div class="form-group">
	                    <div class="col-md-6 col-md-offset-4">
				<button type="submit" class="btn btn-primary">
				    Save
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
