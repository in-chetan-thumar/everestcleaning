@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Edit invoice</h2>
	   <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/invoice/list') }}" class="em_btn_back_onlystyle">Back</a>
		</div>
		 @if (session('status'))
		<div class="alert alert-success em_error_msg" role="alert">		   
		    {{ session('status') }}
		</div>
		@endif
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/invoice/edit') }}">
                        {!! csrf_field() !!}
		<input type="hidden" name="id" value="{{ $invoice->id }}"/>
		<div class="form-group">
		    <label class="col-md-4 control-label">Invoice No<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="invoice_no" value="{{ $invoice->invoice_no }}">
			@if ($errors->has('invoice_no'))
			    <span class="help-block">
				<strong>{{ $errors->first('invoice_no') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Date<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="invoice_date" value="{{ $invoice->invoice_date }}">
			@if ($errors->has('invoice_date'))
			    <span class="help-block">
				<strong>{{ $errors->first('invoice_date') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Client<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
				<select class="form-control" name="client_id">
				    <option value="">Client</option>
				   	 @foreach($client as $value)
				    <option value="<?php echo $value->id; ?>" <?php if($value->id == $invoice->client_id){ echo "selected";} ?>><?php echo $value->cli_com_name; ?></option>
				     @endforeach
			</select>	
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Project<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
				<select class="form-control" name="project_id">
				    <option value="">Project</option>
				   	 @foreach($project as $value)
				    <option value="<?php echo $value->id; ?>" <?php if($value->id == $invoice->project_id){ echo "selected"; } ?>><?php echo $value->project_name; ?></option>
				     @endforeach
				</select>	
		    </div>
		</div>		
		<div class="form-group">
		    <label class="col-md-4 control-label">Description<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<textarea class="form-control summernote" name="invoice_description" rows="20">{{ $invoice->invoice_description }}</textarea>
			@if ($errors->has('invoice_description'))
			    <span class="help-block">
				<strong>{{ $errors->first('invoice_description') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Remark<span class="add_redcolor"></span></label>
		    <div class="col-md-4">
			<textarea class="form-control summernote" name="invoice_remark" rows="10">{{ $invoice->invoice_remark }}</textarea>
			@if ($errors->has('invoice_remark'))
			    <span class="help-block">
				<strong>{{ $errors->first('invoice_remark') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Signature<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<textarea class="form-control summernote" name="invoice_signature" rows="5">{!! 'Ranjit Tulsi<br/>Everest Cleaning Serivces' !!}</textarea>
			@if ($errors->has('invoice_signature'))
			    <span class="help-block">
				<strong>{{ $errors->first('invoice_signature') }}</strong>
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
			<a href="{{ url('/invoice/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
		</form>
          </div>
     
@endsection
