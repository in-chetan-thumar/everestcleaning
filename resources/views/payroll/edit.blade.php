@extends('layouts.app')

@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Edit Payroll</h2>
	   <div class="pull-right" style="margin-top:20px;">			
		    <a href="{{ url('/payroll/list') }}" class="em_btn_back_onlystyle">Back</a>
		</div>
		 @if (session('status'))
		<div class="alert alert-success em_error_msg" role="alert">		   
		    {{ session('status') }}
		</div>
		@endif
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/payroll/edit') }}">
                        {!! csrf_field() !!}
		<input type="hidden" name="id" value="{{ $payroll->id }}"/>
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
				<input type="number" step="any" min="0" class="form-control get_workingdays" name="working_days" value="{{ $payroll->working_days }}">		
				@if ($errors->has('working_days'))
				    <span class="help-block">
					<strong>{{ $errors->first('working_days') }}</strong>
				    </span>
				@endif	
			    </div>
			</div>	
			<div class="form-group">
			    <label class="col-md-5 control-label"> Remark</label>
			    <div class="col-md-7">
				<textarea class="form-control" name="remark" >{{ $payroll->remark }}</textarea>		
			    </div>
			</div>
			<div class="form-group">
			    <label class="col-md-5 control-label"> Cheque no</label>
			    <div class="col-md-7">
				<input type="text" class="form-control" name="cheque_no" value="{{ $payroll->cheque_no }}">
			    </div>
			</div>
			<div class="form-group">
			    <label class="col-md-5 control-label"> Agency</label>
			    <div class="col-md-7">
				<label class="col-md-5 control-label"> {{ $agency_name }} </label>
			    </div>
			</div>
		    </div>
		    <div class="col-md-3">
			<h3>Gross Pay</h3>
			<div class="form-group">
			    <label class="col-md-5 control-label"> Basic Salary</label>
			    <div class="col-md-7">
				<input type="text" class="form-control get_basicsalary"  name="basic_salary" value="{{ $payroll->basic_salary }}" readonly>		
			    </div>
			</div>
			<div class="form-group">
			    <label class="col-md-5 control-label"> OT</label>
			    <div class="col-md-7">
				<input type="number" step="any" min="0" class="form-control get_ot" name="ot" value="{{ $payroll->ot }}">		
			    </div>
			</div>
			<div class="form-group">
			    <label class="col-md-5 control-label"> MISC</label>
			    <div class="col-md-7">
				<input type="number" step="any" min="0" class="form-control get_misc" name="misc" value="{{ $payroll->misc }}">		
			    </div>
			</div>
			<div class="form-group">
			    <label class="col-md-5 control-label"> Commission</label>
			    <div class="col-md-7">
				<input type="number" step="any" min="0" class="form-control get_commission" name="commission" value="{{ $payroll->commission }}">		
			    </div>
			</div>
			<div class="form-group">
			    <label class="col-md-5 control-label"> Allowances</label>
			    <div class="col-md-7">
				<input type="number" step="any" min="0" class="form-control get_allowances" name="allowances" value="{{ $payroll->allowances }}">		
			    </div>
			</div>
			
		    </div>
		    <div class="col-md-3">
			<h3>Deduction</h3>
			<div class="form-group">
			    <label class="col-md-5 control-label"> Unpaid Leave</label>
			    <div class="col-md-7">
				<input type="number" step="any" min="0" class="form-control get_unpaidleave" name="unpaid_leave" value="{{ $payroll->unpaid_leave }}">		
			    </div>
			</div>
		    </div>
		    <div class="col-md-3">
			<h3>Contribution</h3>
			<div class="form-group">
			    <label class="col-md-5 control-label"> SDL</label>
			    <div class="col-md-7">
				<input type="number"  step="any" min="0" class="form-control get_sdl" name="sdl" value="{{ $payroll->sdl }}">		
			    </div>
			</div>
			@if($payroll->employer_cpf !=0)
			<div class="form-group">
			    <label class="col-md-5 control-label"> Employer CPF</label>
			    <div class="col-md-7">
				<input type="number" step="any" min="0" class="form-control get_employercpf" name="employer_cpf" value="{{ $payroll->employer_cpf }}">		
			    </div>
			</div>
			@endif
			@if($payroll->employee_cpf != 0)		
			<div class="form-group">
			    <label class="col-md-5 control-label"> Employee CPF</label>
			    <div class="col-md-7">
				<input type="number" step="any" min="0" class="form-control get_employeecpf" name="employee_cpf"  value="{{ $payroll->employee_cpf }}">		
			    </div>
			</div>
			@endif
			@if($payroll->levy != 0)
			<div class="form-group">
			    <label class="col-md-5 control-label"> Levy</label>
			    <div class="col-md-7">
				<input type="number" step="any" min="0" class="form-control get_levy"  name="levy" value="{{ $payroll->levy }}">		
			    </div>
			</div>
			@endif
			@if($payroll->housing != "")
			<div class="form-group">
			    <label class="col-md-5 control-label"> Housing</label>
			    <div class="col-md-7">
				<input type="number" step="any" min="0" class="form-control get_housing" name="housing" value="{{ $payroll->housing }}">		
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
				<input type="number" step="any" min="0" class="form-control get_grosspay" name="gross_pay" value="{{ $payroll->allowances + $payroll->ot + $payroll->misc + $payroll->commission + $payroll->basic_salary }}" readonly>		
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
				<input type="number" step="any" min="0" class="form-control get_totaldeduction" name="total_deduction" value="{{ $get_deduct }}" readonly>		
			    </div>
			</div>
		    </div>
		     <div class="col-md-3">
			<div class="form-group">
			    <label class="col-md-5 control-label"> Total Contribution</label>
			    <div class="col-md-7">
				<input type="number" step="any" min="0" class="form-control get_totalcontribution" name="total_contribution" value="{{ $payroll->employer_cpf + $payroll->employee_cpf + $payroll->levy + $payroll->housing + $payroll->sdl }}" readonly>		
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
				<input type="number" step="any" min="0" class="form-control get_totalsalary" name="total_salary"  value="{{ $payroll->total_salary }}" readonly>				
			    </div>
			</div>
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
			<a href="{{ url('/payroll/list') }}" class="em_btn_back_onlystyle">Back</a>
		    </div>
		</div>
		</form>
          </div>
     
@endsection
