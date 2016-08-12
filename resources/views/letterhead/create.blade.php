@extends('layouts.app')
@section('content')   
<link href="../css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="../js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
        <div class="col-sm-9 col-md-9 content_wrapper">
	    <h2 class="sub-header">Add letterhead</h2>
	    <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/letterhead/list') }}" class="btn_back_onlystyle">Back</a>
		</div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/letterhead/save') }}">
        {!! csrf_field() !!}

		<input type="hidden" name="letterhead_id" id="letterhead_id" value="<?php echo $letterhead_id ?>" />
		<div class="form-group">
		    <label class="col-md-4 control-label">Letterhead No<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="letterhead_no" value="LET{{ $letterhead_id }}" readonly id="LET_no">
			@if ($errors->has('letterhead_no'))
			    <span class="help-block">
				<strong>{{ $errors->first('letterhead_no') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Letterhead Subject<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="letterhead_subject" value="">
			@if ($errors->has('letterhead_subject'))
			    <span class="help-block">
				<strong>{{ $errors->first('letterhead_subject') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Date<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<input type="text" class="form-control form_date" id="letterhead_date" name="letterhead_date" value="{{ date('Y-m-d') }}" data-format="yyyy-MM-dd" readonly >
			@if ($errors->has('letterhead_date'))
			    <span class="help-block">
				<strong>{{ $errors->first('letterhead_date') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>		
		<div class="form-group">
		    <label class="col-md-4 control-label">Description<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<textarea class="form-control summernote" name="letterhead_description" rows="20">{{ old('letterhead_description') }}</textarea>
			@if ($errors->has('letterhead_description'))
			    <span class="help-block">
				<strong>{{ $errors->first('letterhead_description') }}</strong>
			    </span>
			@endif			
		    </div>
		</div>
		<div class="form-group">
		    <label class="col-md-4 control-label">Signature<span class="add_redcolor">*</span></label>
		    <div class="col-md-4">
			<textarea class="form-control summernote" name="letterhead_signature" rows="5">{!! 'Ranjit Tulsi<br/>Everest Cleaning Serivces' !!}</textarea>
			@if ($errors->has('letterhead_signature'))
			    <span class="help-block">
				<strong>{{ $errors->first('letterhead_signature') }}</strong>
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
			<a href="{{ url('/letterhead/list') }}" class="em_btn_back_onlystyle">Back</a>
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
