<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Payrollsetting;
use Validator;
use App\User;
use App\CPfsetting;
use DateTime;
use DB;
use App;
use App\Workshift;
use App\Agency;
use App\Sdlsetting;
use App\Leave;

class PayrollsettingController extends Controller
{
    protected $redirectTo = '/';
  public function proll_list(){
        $countuser= DB::table('users')->count();
        $payroll = Payrollsetting::orderBy('pay_day', 'desc')->take($countuser)->get();
	return view('payroll.list')->with('payroll',$payroll);
    }
  
    public function proll_create(){
	return view('payroll/create');
    }
    
    public function proll_save(Request $request){	
	$get_request = array(
	    'd_payday'=>$request->d_payday,
	    'm_payday'=>$request->m_payday,
	    'y_payday'=>$request->y_payday,
	);
	
	$validator = Validator::make($get_request,[
	    'd_payday' => 'required',
	    'm_payday' => 'required',
	    'y_payday' => 'required',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('payroll/create')->withErrors($validator)->withInput();
	}
        $payday = $request->d_payday."-".$request->m_payday."-".$request->y_payday;	
	$getalluser = User::all();
	foreach($getalluser as $value){
	    $pay = new Payrollsetting();
	    $pay->user_id = $value->id;
		$pay->agency_id = $value->agency;
	    $pay->basic_salary = $value->salary;
	    $getdays = Workshift::where('id',$value->time_shift)->first();
	    $pay->working_days = $getdays->total_working_days;
	    $pay->actual_working_days= $getdays->total_working_days;
		
		$startDate = $request->y_payday."-".$request->m_payday."-01";
		$endDate = $request->y_payday."-".$request->m_payday."-31";
		$employeeLeave = Leave::where('employee_id', '=', $value->id)->whereBetween('date', array($startDate, $endDate))
			->Select(DB::raw('SUM(IF(is_paid = "Y", 1,0)) AS tot_paid_leave, SUM(IF(is_paid = "N", 1,0)) AS tot_unpaid_leave'))->first();
		
	    $pay->paid_leave = is_null($employeeLeave->tot_paid_leave) ? 0 : $employeeLeave->tot_paid_leave;
		$pay->unpaid_leave = is_null($employeeLeave->tot_unpaid_leave) ? 0 : $employeeLeave->tot_unpaid_leave;
			
	    if($value->levy_status != 0){
		$levy_val = $value->levy_val;
	    }
	    else{
		$levy_val = 0;
	    }
	    $pay->levy = $levy_val;
	    $pay->housing = $value->housing_fee;
	    $pay->ot = 0;
	    $pay->misc = 0;
	    $pay->commission = 0;
	    $pay->allowances = 0;
	    
		/*if($value->salary < 800){
		$sdl_val = 2;
	    }
	    else if($value->salary > 800 && 2000 > $value->salary ){		
		$sdl_val = $value->salary * 0.0025 ;
	    }
	    else{
		$sdl_val = 11.25;
	    }
		$pay->sdl = $sdl_val;*/
		
		$sdlsetting = Sdlsetting::where('total_wages', '<=', $value->salary)->orderBy('total_wages', 'DESC')->first();
		
	    $pay->sdl = $sdlsetting->sdl_payable;		
	    $user_dob = $value->dob;
            $udate = new DateTime($user_dob);
	    $current_date = new DateTime();
	    $get_age = $current_date->diff($udate);
	    $user_aged = $get_age->y;
	    $getallcpf = Cpfsetting::get();
	    if($value->cpf_status == 1){
		foreach($getallcpf as $cvalue){
		if($cvalue->cpf_type == "andbelow" && $cvalue->aged_to == 0 && $cvalue->aged_from >= $user_aged){
		    $pay->employee_cpf = $cvalue->employee_rate;
		    $pay->employer_cpf = $cvalue->employer_rate;
		}
		else if($cvalue->cpf_type == "to" && $cvalue->aged_to > $user_aged && $cvalue->aged_from < $user_aged){
		    $pay->employee_cpf = $cvalue->employee_rate;
		    $pay->employer_cpf = $cvalue->employer_rate;
		}
		else if($cvalue->cpf_type == "andabove" && $cvalue->aged_to == 0 && $cvalue->aged_from <= $user_aged){
		    $pay->employee_cpf = $cvalue->employee_rate;
		    $pay->employer_cpf = $cvalue->employer_rate;
		}
	    }
	    }	    
	    $pay->total_salary = $value->salary;
	    $pay->pay_day = new DateTime($payday);
	    $pay->status = 1;
	    $pay->created_at = date('Y-m-d H:i:s');
	    $pay->updated_at = date('Y-m-d H:i:s');
	    $pay->post_user = 1;
	    $pay->remember_token = $request->_token;    
	  $pay->save();
	}	
	return redirect('payroll/list')->with('status','Save');
	//return redirect('/payroll/list')->with('status', 'Coming Soon! We are working on it');
    }
    
    public function proll_editsave(Request $request){
	
	
	$keep_proll = Payrollsetting::find($request->id);
	$keep_proll->working_days   = $request->working_days;
	$keep_proll->unpaid_leave   = $request->unpaid_leave;
	$keep_proll->levy	    = $request->levy;
	$keep_proll->housing	    = $request->housing;
	$keep_proll->ot		    = $request->ot;
	$keep_proll->misc	    = $request->misc;
	$keep_proll->commission	    = $request->commission;
	$keep_proll->allowances	    = $request->allowances;
	$keep_proll->sdl	    = $request->sdl;
	$keep_proll->employer_cpf   = $request->employer_cpf;
	$keep_proll->employee_cpf   = $request->employee_cpf;
	$keep_proll->remark	    = $request->remark;
	$keep_proll->cheque_no	    = $request->cheque_no;
	$keep_proll->actual_working_days = $request->working_days - $request->unpaid_leave;
	$keep_proll->total_salary   = $request->total_salary;
	$keep_proll->created_at        = date('Y-m-d H:i:s');
	$keep_proll->updated_at        = date('Y-m-d H:i:s');
	$keep_proll->post_user         = 1;
	$keep_proll->status	       = 1;
	$keep_proll->save();
	return redirect('/payroll/edit/'.$request->id	)->with('status','Updated!');
    }
    
    public function proll_edit(Request $request){
		$payroll = Payrollsetting::find($request->id);
		$agency_name = "";
		if(!is_null($payroll->agency_id)){
			$agency = Agency::find($payroll->agency_id);
			$agency_name = $agency->agency_name;
		}
	return view('payroll.edit',['payroll' => $payroll, 'agency_name' => $agency_name]);
    }
    
     public function proll_search(Request $request){	
	
	$get_request = array(
	    'm_search'=>$request->m_search,
	    'y_search'=>$request->y_search,
	);
	
	$validator = Validator::make($get_request,[
	    'm_search' => 'required',
	    'y_search' => 'required',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('payroll/create')->withErrors($validator)->withInput();
	}
	
	$m_search = $request->m_search;
	$y_search = $request->y_search;
	
	$search_payroll = DB::table('ec_payroll_setting')->where(DB::raw('YEAR(pay_day)'),'=',$y_search)->where(DB::raw('MONTH(pay_day)'),'=',$m_search)->where('status','=',1)->get();
	
	
	return view('payroll.search')->with('payroll',$search_payroll);
     }
     
     public function getproll_search(Request $request){
	 return view('payroll.search');
     } 
     
     public function getproll_search_byid(Request $request){
	$payroll = Payrollsetting::find($request->id);
	return view('payroll.searchlist',['payroll' => $payroll]);
     } 
     
      public function view_mypayroll(Request $request){
	$payroll = Payrollsetting::find($request->id);
	return view('payroll.my_payroll',['payroll' => $payroll]);
     } 
     
     public function proll_view(Request $request){
		$payroll = Payrollsetting::find($request->id);
		$agency_name = "";
		if(!is_null($payroll->agency_id)){
			$agency = Agency::find($payroll->agency_id);
			$agency_name = $agency->agency_name;
		}
	return view('payroll.view',['payroll' => $payroll, 'agency_name' => $agency_name]);
    }
    
    public function generate_pdf(Request $request){
	    $getuser_proll = Payrollsetting::find($request->id);
	   
	$pdf = App::make('dompdf.wrapper');
	$gettime = date('d F Y',strtotime($getuser_proll->pay_day));
	$unpaid_days = $getuser_proll->unpaid_leave;
	$total_working_days = $getuser_proll->working_days;
	$pay_per_day = $getuser_proll->basic_salary / $total_working_days;
	$unpaidleave = $pay_per_day * $unpaid_days;
	$getuser = User::where('id','=',$getuser_proll->user_id)->first();
	$name = $getuser->full_name;
	$designation = $getuser->position;
	$commission = $getuser_proll->commission;
	$basicpay = $getuser_proll->basic_salary;
	$allowances = $getuser_proll->allowances;
	$total_deduction = $unpaidleave;
	$grosspay = $getuser_proll->basic_salary + $getuser_proll->commission + $getuser_proll->commission + $getuser_proll->ot;
	$employer_cpf = $getuser_proll->employer_cpf;
	$employee_cpf = $getuser_proll->employee_cpf;
	$totalcpf = $getuser_proll->employer_cpf + $getuser_proll->employee_cpf;
	$nettotal = $grosspay - $total_deduction;
	$overtime= $getuser_proll->ot;
	$levy = $getuser_proll->levy;
	$housing  = $getuser->housing_fee;
	$remark = $getuser_proll->remark;
	$cheque_no = $getuser_proll->cheque_no;
	$agency_name = "";
	if(!is_null($getuser_proll->agency_id)){
		$agency = Agency::find($getuser_proll->agency_id);
		$agency_name = $agency->agency_name;
	}
	$total_contribution = $levy + $housing;
	if($housing == ""){
	    $housing = "-";
	}
	$print_name= $getuser->full_name;
	if($employer_cpf == "" && $employee_cpf == ""){
	    $cpforlevy = '<div class=row_style><span class="txt_label2">Levy</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$levy.'</span></div>
								<div class=row_style><span class="txt_label2">Housing</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$housing.'</span></div>
								<div class=net_total row_style><span class="txt_label2" >TOTAL Contribution</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$total_contribution.'</span></div>	
								<div style="height:30px">&nbsp;</div>';
	}
	else{	    
	
	$cpforlevy = '<div class=row_style><span class="txt_label2">EMPLOYER CPF</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$employer_cpf.'</span></div>
								<div class=row_style><span class="txt_label2">EMPLOYEE CPF</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$employee_cpf.'</span></div>
								<div class=net_total row_style><span class="txt_label2">TOTAL Contribution<</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$totalcpf.'</span></div>	
								<div style="height:30px">&nbsp;</div>';
	}
	$path = base_path();
		$html ='<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
			<title>Title</title>
			<style type="text/css" media="all">
			body, html {			
				font-family:Helvetica;
				font-size:14px;
				text-transform:uppercase;
			}			
			div.nobreak {
				page-break-inside:avoid;
			}
			
			.wrapper{
				width:700px;
			}
			.addwidthx72{
				width:600px;
			}
			.wrapper h1{
				text-align:center;
			}
			.add_border{
				border:1px solid #000;
				padding:10px !important;
			}	
			.add_border1{
				border-top:1px solid #000;
				border-left:1px solid #000;
				border-right:1px solid #000;
				padding:10px !important;
			}
			.add_border_left{
				border-left:1px solid #000;
				padding:10px !important;
			}
			.add_border_right{
				border-right:1px solid #000;
				padding:10px !important;
			}
			.txt_label{
				width:100px;
				display:inline-block;
				height:25px;
			}
			
			.txt_label1{
				width:200px;
				display:inline-block;
				height:25px;
			}
			.txt_label2{
				width:160px;
				display:inline-block;
				height:25px;
			}
			.txt_label3{
				width:150px;
				display:inline-block;
				height:25px;
			}
			.txt_value{
				width:100px;
				display:inline-block !important;
				height:25px;
				text-align:right;
			}
			.txt_value1{
				width:130px;
				display:inline-block;
				height:25px;
				text-align:right;
			}
			.add_height{
				height:200px;
			}
			.add_height1{
				height:80px;
			}
			.net_total{
				font-weight:bold;
				
			}
			.leave_days{
				width:50px;
				display:inline-block;
				text-align:right;
			}
			.leave_days1{
				width:20px;
				display:inline-block;
			}
			.deduct_txt{
				display:inline-block;width:132px;text-align:right;padding-right:8px;
			}
			.space_txt{
				display:inline-block;width:150px;
			}
			.dot{
				width:7px;
				display:inline-block;
				height:25px;
			}
			.name_style{
				text-transform:capitalize;
			}
			.row_style{				
				height:50px;
			}
			</style>
			</head>
			<body>
				<div class="nobreak">
					<div class="wrapper">
					<table border="0" cellpadding="0" cellspacing="0" class="addwidthx72">
					<tr><td><img src="'.$path.'/images/everest-logo.png" width="250px"/></td></tr>
					<tr><td><h1>PAYSLIP</h1></td></tr>
					
					<tr><td class="add_border1">						
						<div class=row_style><span class="txt_label">NAME</span><span class="dot">:</span><span class="txt_label1 name_style">'.$name.'</span><span style=display:inline-block;width:45px></span><span class="txt_label">PERIOD</span><span class="dot">:</span><span class="txt_label3">'.$gettime.'</span></div>
						<div class=row_style><span class="txt_label">DESIGNATION</span><span class="dot">:</span><span class="txt_label1 name_style">'.$designation.'</span><span style=display:inline-block;width:45px></span><span class="txt_label">AGENCY</span><span class="dot">:</span><span class="txt_label3">'.$agency_name.'</span></div>	
						<div class=row_style><span class="txt_label">Cheque no</span><span class="dot">:</span><span class="txt_label1 name_style">'.$cheque_no.'</span></div>
					</td><td>
					</tr>
					<tr><td>
						<table border="0" cellpadding="0" cellspacing="0" class="addwidthx72">
							<tr><td class="add_border" style="width:330px;">
								<div class=row_style><span class="txt_label2">Basic Pay</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$basicpay.'</span></div>
								<div class=row_style>	<span class="txt_label2">Overtime</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$overtime.'</span></div>
								<div class=row_style><span class="txt_label2">Commission</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$commission.'</span></div>
								<div class=row_style><span class="txt_label2">Allowances</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$allowances.'</span></div>
								
								<div class=net_total><span class="txt_label2 ">Gross Pay</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$grosspay.'</span></div>
							</td>
							</td><td class="add_border" style="width:330px">						    
								<div class=row_style><span class="txt_label2">Unpaid Leave</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$unpaidleave.'</span></div>
								<div class=row_style style="height:150px">&nbsp;</div>
								
								<div class=net_total row_style><span class="txt_label2">Total decduction</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$total_deduction.'</span></div>
						    </td></tr>		
						    <tr><td class="add_border" style="width:330px;">
								'.$cpforlevy.'						
							</td>
							</td><td class="add_border" style="width:330px">							   
								<div style="height:100px">&nbsp;</div>
								<div class=net_total row_style><span class="txt_label2 ">Net Total</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$nettotal.'</span></div>
								<div style="height:30px">&nbsp;</div>
						    </td></tr>	

						</table>
					</tr></td>
					<tr>
							<td class="add_border1" style="border-bottom:1px solid #000;">
								<div class=row_style><span class="txt_label">Remark</span><span class="dot"></span><span class="txt_label1 name_style"></span><span style=display:inline-block;width:45px></span><span class="txt_label"></span><span class="dot"></span><span style="width:200px">employee signature</span></div>
								<div class=row_style><span class="txt_label" style="width:400px; text-transform:non;"> '.$remark.'</span></div>
							</td>
						</tr>
				</table>
			    </div>
				</div>
				</body>
			</html>';
		$print_name = strtolower($print_name);
		$pdf_name = $print_name."_".$gettime."_paylip.pdf";
    	$pdf->loadHTML($html);
		return $pdf->download($pdf_name);
    }
       
	public function print_pdf(Request $request){
	  $getuser_proll = Payrollsetting::find($request->id);
	   
	$pdf = App::make('dompdf.wrapper');
	$gettime = date('d F Y',strtotime($getuser_proll->pay_day));
	$unpaid_days = $getuser_proll->unpaid_leave;
	$total_working_days = $getuser_proll->working_days;
	$pay_per_day = $getuser_proll->basic_salary / $total_working_days;
	$unpaidleave = $pay_per_day * $unpaid_days;
	$getuser = User::where('id','=',$getuser_proll->user_id)->first();
	$name = $getuser->full_name;
	$designation = $getuser->position;
	$commission = $getuser_proll->commission;
	$basicpay = $getuser_proll->basic_salary;
	$allowances = $getuser_proll->allowances;
	$total_deduction = $unpaidleave;
	$grosspay = $getuser_proll->basic_salary + $getuser_proll->commission + $getuser_proll->commission + $getuser_proll->ot;
	$employer_cpf = $getuser_proll->employer_cpf;
	$employee_cpf = $getuser_proll->employee_cpf;
	$totalcpf = $getuser_proll->employer_cpf + $getuser_proll->employee_cpf;
	$nettotal = $grosspay - $total_deduction;
	$overtime= $getuser_proll->ot;
	$levy = $getuser_proll->levy;
	$housing  = $getuser->housing_fee;
	$remark = $getuser_proll->remark;
	$cheque_no = $getuser_proll->cheque_no;
	$agency_name = "";
	if(!is_null($getuser_proll->agency_id)){
		$agency = Agency::find($getuser_proll->agency_id);
		$agency_name = $agency->agency_name;
	}
	$total_contribution = $levy + $housing;
	if($housing == ""){
	    $housing = "-";
	}
	$print_name= $getuser->full_name;
	if($employer_cpf == "" && $employee_cpf == ""){
	    $cpforlevy = '<div class=row_style><span class="txt_label2">Levy</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$levy.'</span></div>
								<div class=row_style><span class="txt_label2">Housing</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$housing.'</span></div>
								<div class=net_total row_style><span class="txt_label2" >TOTAL Contribution</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$total_contribution.'</span></div>	
								<div style="height:30px">&nbsp;</div>';
	}
	else{	    
	
	$cpforlevy = '<div class=row_style><span class="txt_label2">EMPLOYER CPF</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$employer_cpf.'</span></div>
								<div class=row_style><span class="txt_label2">EMPLOYEE CPF</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$employee_cpf.'</span></div>
								<div class=net_total row_style><span class="txt_label2">TOTAL Contribution<</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$totalcpf.'</span></div>	
								<div style="height:30px">&nbsp;</div>';
	}
	$path = base_path();
		$html ='<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
			<title>Title</title>
			<style type="text/css" media="all">
			body, html {			
				font-family:Helvetica;
				font-size:14px;
				text-transform:uppercase;
			}			
			div.nobreak {
				page-break-inside:avoid;
			}
			
			.wrapper{
				width:700px;
			}
			.addwidthx72{
				width:600px;
			}
			.wrapper h1{
				text-align:center;
			}
			.add_border{
				border:1px solid #000;
				padding:10px !important;
			}	
			.add_border1{
				border-top:1px solid #000;
				border-left:1px solid #000;
				border-right:1px solid #000;
				padding:10px !important;
			}
			.add_border_left{
				border-left:1px solid #000;
				padding:10px !important;
			}
			.add_border_right{
				border-right:1px solid #000;
				padding:10px !important;
			}
			.txt_label{
				width:100px;
				display:inline-block;
				height:25px;
			}
			
			.txt_label1{
				width:200px;
				display:inline-block;
				height:25px;
			}
			.txt_label2{
				width:160px;
				display:inline-block;
				height:25px;
			}
			.txt_label3{
				width:150px;
				display:inline-block;
				height:25px;
			}
			.txt_value{
				width:100px;
				display:inline-block !important;
				height:25px;
				text-align:right;
			}
			.txt_value1{
				width:130px;
				display:inline-block;
				height:25px;
				text-align:right;
			}
			.add_height{
				height:200px;
			}
			.add_height1{
				height:80px;
			}
			.net_total{
				font-weight:bold;
				
			}
			.leave_days{
				width:50px;
				display:inline-block;
				text-align:right;
			}
			.leave_days1{
				width:20px;
				display:inline-block;
			}
			.deduct_txt{
				display:inline-block;width:132px;text-align:right;padding-right:8px;
			}
			.space_txt{
				display:inline-block;width:150px;
			}
			.dot{
				width:7px;
				display:inline-block;
				height:25px;
			}
			.name_style{
				text-transform:capitalize;
			}
			.row_style{				
				height:50px;
			}
			</style>
			</head>
			<body>
				<div class="nobreak">
					<div class="wrapper">
					<table border="0" cellpadding="0" cellspacing="0" class="addwidthx72">
						<tr><td><img src="'.$path.'/images/everest-logo.png" width="250px"/></td></tr>
						<tr><td><h1>PAYSLIP</h1></td></tr>
					
						<tr><td class="add_border1">						
							<div class=row_style><span class="txt_label">NAME</span><span class="dot">:</span><span class="txt_label1 name_style">'.$name.'</span><span style=display:inline-block;width:45px></span><span class="txt_label">PERIOD</span><span class="dot">:</span><span class="txt_label3">'.$gettime.'</span></div>
							<div class=row_style><span class="txt_label">DESIGNATION</span><span class="dot">:</span><span class="txt_label1 name_style">'.$designation.'</span><span style=display:inline-block;width:45px></span><span class="txt_label">AGENCY</span><span class="dot">:</span><span class="txt_label3">'.$agency_name.'</span></div>	
							<div class=row_style><span class="txt_label">Cheque no</span><span class="dot">:</span><span class="txt_label1 name_style">'.$cheque_no.'</span></div>
						</td></tr>
						
						<tr>
						<td>
							<table border="0" cellpadding="0" cellspacing="0" class="addwidthx72">
								<tr>
									<td class="add_border" style="width:330px;">
										<div class=row_style><span class="txt_label2">Basic Pay</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$basicpay.'</span></div>
										<div class=row_style>	<span class="txt_label2">Overtime</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$overtime.'</span></div>
										<div class=row_style><span class="txt_label2">Commission</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$commission.'</span></div>
										<div class=row_style><span class="txt_label2">Allowances</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$allowances.'</span></div>
									
										<div class=net_total><span class="txt_label2 ">Gross Pay</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$grosspay.'</span></div>
									</td>
									<td class="add_border" style="width:330px">						    
										<div class=row_style><span class="txt_label2">Unpaid Leave</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$unpaidleave.'</span></div>
										<div class=row_style style="height:150px">&nbsp;</div>
									
										<div class=net_total row_style><span class="txt_label2">Total decduction</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$total_deduction.'</span></div>
									</td>
								</tr>		
								<tr>
									<td class="add_border" style="width:330px;">
										'.$cpforlevy.'						
									</td>
									<td class="add_border" style="width:330px">							   
										<div style="height:100px">&nbsp;</div>
										<div class=net_total row_style><span class="txt_label2 ">Net Total</span><span class="leave_days1">&nbsp;</span><span class="txt_value">'.$nettotal.'</span></div>
										<div style="height:30px">&nbsp;</div>
									</td>
								</tr>
						</table>
						</td>
						</tr>
						<tr>
							<td class="add_border1" style="border-bottom:1px solid #000;">
								<div class=row_style><span class="txt_label">Remark</span><span class="dot"></span><span class="txt_label1 name_style"></span><span style=display:inline-block;width:45px></span><span class="txt_label"></span><span class="dot"></span><span style="width:200px">employee signature</span></div>
								<div class=row_style><span class="txt_label" style="width:400px; text-transform:non;"> '.$remark.'</span></div>
							</td>
						</tr>						
					</table>
			    </div>
				</div>
				</body>
			</html>';
		$print_name = strtolower($print_name);
		$pdf_name = $print_name."_".$gettime."_paylip.pdf";
		$pdf->loadHTML($html);
		return $pdf->stream($pdf_name);
    }
    
}





