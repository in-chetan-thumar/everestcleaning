@extends('layouts.app')

@section('content') 
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">View Payroll</h2>
		<div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/payroll/list') }}" class="em_btn_back_onlystyle">Back</a>
		</div>	
            <!-- <form class="form-horizontal veiw_mode" role="form" method="POST" action="">
		<div class="form-group">
		    <label class="col-md-4 control-label">Name</label>
		    <div class="col-md-4">
			<input type="text" class="form-control" name="name" value="{{ $payroll->user_id }}" readonly="readonly">		
		    </div>		    
		</div> 
		 <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
			 <a href="{{ url('/payroll/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
	     </form>-->
	    <form class="form-horizontal" role="form" method="POST" action="{{ url('/payroll/edit') }}">
		<div class="row">
		    <div class="col-md-3">
			<h3>Info</h3>
			<div class="form-group">
			    <label class="col-md-5 control-label"> Full Name</label>
			    <div class="col-md-7">
				<?php $user = DB::table('users')->where('id', $payroll->user_id)->first();  ?>
				<input type="text" class="form-control"  value="{{ $user->full_name }}" readonly>		
			    </div>
			</div>			
			<div class="form-group">
			    <label class="col-md-5 control-label"> Total Working Days</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" readonly value="{{ $payroll->working_days }}">		
			    </div>
			</div>	
			<div class="form-group">
			    <label class="col-md-5 control-label"> Remark</label>
			    <div class="col-md-7">
				<textarea class="form-control" readonly value="{{ $payroll->remark }}"></textarea>		
			    </div>
			</div>
		    </div>
		    <div class="col-md-3">
			<h3>Gross Pay</h3>
			<div class="form-group">
			    <label class="col-md-5 control-label"> Basic Salary</label>
			    <div class="col-md-7">
				<input type="text" class="form-control"  value="{{ $payroll->basic_salary }}" readonly>		
			    </div>
			</div>
			<div class="form-group">
			    <label class="col-md-5 control-label"> OT</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" readonly value="{{ $payroll->ot }}">		
			    </div>
			</div>
			<div class="form-group">
			    <label class="col-md-5 control-label"> MISC</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" readonly value="{{ $payroll->misc }}">		
			    </div>
			</div>
			<div class="form-group">
			    <label class="col-md-5 control-label"> Commission</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" readonly value="{{ $payroll->commission }}">		
			    </div>
			</div>
			<div class="form-group">
			    <label class="col-md-5 control-label"> Allowances</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" readonly value="{{ $payroll->allowances }}">		
			    </div>
			</div>
			
		    </div>
		    <div class="col-md-3">
			<h3>Deduction</h3>
			<div class="form-group">
			    <label class="col-md-5 control-label"> Unpaid Leave</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" readonly value="{{ $payroll->unpaid_leave }}">		
			    </div>
			</div>
		    </div>
		    <div class="col-md-3">
			<h3>Contribution</h3>
			<div class="form-group">
			    <label class="col-md-5 control-label"> SDL</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" readonly value="{{ $payroll->sdl }}">		
			    </div>
			</div>
			@if($payroll->employer_cpf !=0)
			<div class="form-group">
			    <label class="col-md-5 control-label"> Employer CPF</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" readonly value="{{ $payroll->employer_cpf }}">		
			    </div>
			</div>
			@endif
			@if($payroll->employee_cpf != 0)		
			<div class="form-group">
			    <label class="col-md-5 control-label"> Employee CPF</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" readonly  value="{{ $payroll->employee_cpf }}">		
			    </div>
			</div>
			@endif
			@if($payroll->levy != 0)
			<div class="form-group">
			    <label class="col-md-5 control-label"> Levy</label>
			    <div class="col-md-7">
				<input type="text" class="form-control"  readonly value="{{ $payroll->levy }}">		
			    </div>
			</div>
			@endif
			@if($payroll->housing != "")
			<div class="form-group">
			    <label class="col-md-5 control-label"> Housing</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" readonly value="{{ $payroll->housing }}">		
			    </div>
			</div>
			@endif
		    </div>
		</div>
		<div class="row">
		    <div class="col-md-3 col-md-offset-3">
			<div class="form-group">
			    <label class="col-md-5 control-label"> Gross Pay</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" readonly value="{{ $payroll->allowances + $payroll->ot + $payroll->misc + $payroll->commission + $payroll->basic_salary }}" readonly>		
			    </div>
			</div>
		    </div>
		    <div class="col-md-3">
			<div class="form-group">
			    <label class="col-md-5 control-label"> Total Deduction</label>
			    <div class="col-md-7">
				<?php
				 $getpay_per_hour  = $payroll->basic_salary / $payroll->working_days;
				 $get_deduct = $getpay_per_hour * $payroll->unpaid_leave;
				?>
				<input type="text" class="form-control" readonly value="{{ $get_deduct }}" readonly>		
			    </div>
			</div>
		    </div>
		     <div class="col-md-3">
			<div class="form-group">
			    <label class="col-md-5 control-label"> Total Contribution</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" readonly value="{{ $payroll->employer_cpf + $payroll->employee_cpf + $payroll->levy + $payroll->housing + $payroll->sdl }}" readonly>		
			    </div>
			</div>
		    </div>
		</div>
		<hr/>
		<div class="row">		   
		    <div class="col-md-3 col-md-offset-3">
			<div class="form-group">
			    <label class="col-md-5 control-label"> Net Total</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" readonly  value="{{ $payroll->total_salary }}" readonly>		
			    </div>
			</div>
		    </div>
		</div>
		
		<div class="form-group">
                    <div class="col-md-6 col-md-offset-4">			
			<a href="{{ url('/payroll/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
		</form>
          </div>
     
@endsection
