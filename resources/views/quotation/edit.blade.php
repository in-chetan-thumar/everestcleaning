@extends('layouts.app')

@section('content')   
<link href="../../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="../../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../../js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Edit quotation</h2>
	   <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/quotation/list') }}" class="em_btn_back_onlystyle">Back</a>
		</div>
		 @if (session('status'))
		<div class="alert alert-success em_error_msg" role="alert">		   
		    {{ session('status') }}
		</div>
		@endif
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/quotation/edit') }}">
                        {!! csrf_field() !!}
		<input type="hidden" name="quotation_id" id="quotation_id" value="{{ $quotation->id }}" />
		<input type="hidden" name="id" value="{{ $quotation->id }}"/>
		<div class="form-group">
		    <label class="col-md-4 control-label">Quotation No<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="quotation_no" value="{{ $quotation->quotation_no }}" readonly id="QUO_no">
			@if ($errors->has('quotation_no'))
			    <span class="help-block">
				<strong>{{ $errors->first('quotation_no') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Date<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control form_date" id="quotation_date" name="quotation_date" value="{{ $quotation->quotation_date }}" data-format="yyyy-MM-dd" readonly >
			@if ($errors->has('quotation_date'))
			    <span class="help-block">
				<strong>{{ $errors->first('quotation_date') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Client<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
				<select class="form-control" name="client_id" id="QUO_client_id">
				    <option value="">Client</option>
				   	 @foreach($client as $value)
				    <option value="<?php echo $value->id; ?>" <?php if($value->id == $quotation->client_id){ echo "selected";} ?>><?php echo $value->cli_com_name; ?></option>
				     @endforeach
			</select>	
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Project<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
				<select class="form-control" name="project_id" id="QUO_project_id">
				    <option class="show" value="">Project</option>
				   	 @foreach($project as $value)
				    <option value="<?php echo $value->id; ?>" class="<?php echo $value->client_id; ?>" id="<?php echo $value->project_shortname_for_invoice; ?>" <?php if($value->id == $quotation->project_id){ echo "selected"; } ?>><?php echo $value->project_name; ?></option>
				     @endforeach
				</select>	
		    </div>
		</div>		
		<div class="form-group">
		    <label class="col-md-4 control-label">Description<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<textarea class="form-control summernote" name="quotation_description" rows="20">{{ $quotation->quotation_description }}</textarea>
			@if ($errors->has('quotation_description'))
			    <span class="help-block">
				<strong>{{ $errors->first('quotation_description') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Remark<span class="add_redcolor"></span></label>
		    <div class="col-md-4">
			<textarea class="form-control summernote" name="quotation_remark" rows="10">{{ $quotation->quotation_remark }}</textarea>
			@if ($errors->has('quotation_remark'))
			    <span class="help-block">
				<strong>{{ $errors->first('quotation_remark') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>	
		<div class="form-group">
		    <label class="col-md-4 control-label">Signature<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<textarea class="form-control summernote" name="quotation_signature" rows="5">{!! 'Ranjit Tulsi<br/>Everest Cleaning Serivces' !!}</textarea>
			@if ($errors->has('quotation_signature'))
			    <span class="help-block">
				<strong>{{ $errors->first('quotation_signature') }}</strong>
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
			<a href="{{ url('/quotation/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
		</form>
          </div>
<script>
$('.form_date').datetimepicker({               
	format: 'yyyy-mm-dd',
	startView: 'month',
	minView: 'month',
	autoclose: true   
});		  
</script>     
@endsection
