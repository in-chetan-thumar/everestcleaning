@extends('layouts.app')

@section('content') 
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">View Payroll</h2>
		<div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url("/payroll/export/".$payroll->id) }}" target="_blank" class="btn btn-primary">Export PDF</a>
		    <a href="{{ url("/payroll/print/".$payroll->id) }}" target="_blank" class="btn btn-primary">Print</a>
		</div>	
             <form class="form-horizontal veiw_mode" role="form" method="POST" action="">
		<div class="form-group">
		    <label class="col-md-4 control-label">Name</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="name" value="{{ $payroll->user_id }}" readonly="readonly">		
		    </div>		    
		</div>  		

		 
	     </form>
          </div>
     
@endsection
