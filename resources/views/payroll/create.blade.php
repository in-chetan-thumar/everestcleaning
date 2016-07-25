@extends('layouts.app')
@section('content')   
         <div class="col-sm-9 col-md-9 content_wrapper">
	     <h2 class="sub-header">Generate Payroll</h2>
	     <div class="payroll_generate_wrapper">
             <form class="form-horizontal" role="form" method="POST" action="{{ url('/payroll/save') }}">
                        {!! csrf_field() !!}
		<div class="form-group">
		    <label class="col-md-2 control-label">Pay Date <span class="add_redcolor">*</span></label>		   
			<?php $pdate = DB::table('ec_payroll_setting')->groupBy('pay_day')->orderBy('pay_day', 'desc')->get();
			    $month_array =array();
			    foreach($pdate as $value){
				 $get_m = date('m',strtotime($value->pay_day));
				 array_push($month_array,$get_m);
			    }
			?>
		     <div class="col-md-2">
			<select class="form-control" name="d_payday">
			    <option value="">Day</option>
			   <?php for($i=1;$i<=31;$i++){
			   ?>
			    <option value="<?php echo $i;?>"><?php echo $i; ?></option>
			   <?php
			   } ?>
			</select>
			 @if ($errors->has('d_payday'))
			    <span class="help-block">
				<strong>{{ $errors->first('d_payday',"This field is required") }}</strong>
			    </span>
			@endif	
		     </div>
		     <div class="col-md-2">			 
			<select class="form-control col-md-2" name="m_payday">
			    <option value="">Month</option>
			    <?php 
			     for($i=1;$i<=12;$i++){
				 if($i<10){ $m =  "0".$i;} else{ $m=  $i; }
				 if(in_array($m,$month_array)){}else{
		            ?>
			    <option value="<?php echo $m; ?>"><?php echo $m; ?></option>
			    <?php
				 }
			     }
			    ?>
			</select>
			 @if ($errors->has('m_payday'))
			    <span class="help-block">
				<strong>{{ $errors->first('m_payday',"This field is required") }}</strong>
			    </span>
			@endif	
		     </div>
		     <div class="col-md-2">
			<select class="form-control col-md-2" name="y_payday">
			    <option value="">Year</option>
			    <option value="2016">2016</option>
			    <option value="2017">2017</option>
			</select>
			 @if ($errors->has('y_payday'))
			    <span class="help-block">
				<strong>{{ $errors->first('y_payday',"This field is required") }}</strong>
			    </span>
			@endif	
		    </div>
		    <div class="col-md-2">
			<button type="submit" class="btn btn-primary">
			    Generate
			</button>
		    </div>
		</div>
		
		</form>
	     </div>
	   
          </div>
     
@endsection
