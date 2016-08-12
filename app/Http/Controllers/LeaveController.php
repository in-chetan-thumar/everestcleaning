<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;
use App\Leave;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
	public function leave_list(){

		$employeeList = User::all();
		
		//$leaveList = Leave::all()->sortByDesc("created_at");
		
		$leaveList = Leave::leftjoin('users','users.id', '=', 'leave.employee_id')
						->select('leave.date', 'leave.is_paid', 'leave.leave_type', 'users.full_name')
						->orderBy('leave.id', 'DESC')
						->get();
		
		return view('leave.list')->with('employeeList',$employeeList)->with('leaveList', $leaveList);
    }
	
	public function leave_create(Request $request){
		$get_request = array(
			'employee_id'		=> $request->employee_id,
			'leave_date' 		=> $request->leave_date,
			'leave_type' 		=> $request->leave_type,
		);
		
		$validator = Validator::make($get_request,[
			'employee_id' => 'required',
			'leave_date' => 'required',
			'leave_type' => 'required',
		]);	
		   
		if ($validator->fails())
		{
			return redirect('leave')->withErrors($validator)->withInput();
		}
		$leave = new Leave();
		$leave->employee_id 	= $request->employee_id;
		$leave->date 			= $request->leave_date;
		$leave->leave_type 		= $request->leave_type;
		if(isset($request->is_paid) AND $request->is_paid != "")
			$leave->is_paid 		= $request->is_paid;
		else
			$leave->is_paid 		= "Y";
		
		$leave->created_at      = date('Y-m-d H:i:s');
		$leave->save();
		
		return redirect('/leave');
    }
	
	public function leave_validate(Request $request){

		$employee_id = $request->employee_id;
		$leave_date = $request->leave_date;
		
		$Annual_leave = array('0' => '7', '1' => '7', '2' => '8', '3' => '9', '4' => '10', '5' => '11', '6' => '12', '7' => '13', '8' => '14');
		$medical_non_hospitalisation_leave = array('0' => '5','1' => '5', '2' => '5', '3' => '5', '4' => '8', '5' => '11', '6' => '14');
		$medical_hospitalisation_leave = array('0' => '15','1' => '15', '2' => '15', '3' => '15', '4' => '30', '5' => '45', '6' => '40');
		
		//Get employee business year and completed years / months
		$employeeServiceAge = User::select('id', 'full_name', 'start_employment', DB::raw('TIMESTAMPDIFF(YEAR, start_employment, "'.date("Y-m-d").'") years_of_service, TIMESTAMPDIFF(MONTH, start_employment, "'.date("Y-m-d").'") months_of_service'))->where('id', '=', $employee_id)->first();
		
		if(!is_null($employeeServiceAge->start_employment) OR $employeeServiceAge->start_employment != "" ){
			$start_employment = $employeeServiceAge->start_employment;
			
			$employeeServiceYear = $employeeServiceAge->years_of_service;
			$employeeServiceMonth = $employeeServiceAge->months_of_service;
			
			$timestamp    = strtotime($start_employment);
			$currentYearEmpStartDate = date("Y").date('-m-d', $timestamp);
			
			if(strtotime($currentYearEmpStartDate) < strtotime(date('Y-m-d'))){
				$startDate = $currentYearEmpStartDate;
				$endDate = (date("Y")+1) . date('-m-d', $timestamp);
			}else{
				$startDate = (date("Y")-1) . date('-m-d', $timestamp);
				$endDate = $currentYearEmpStartDate;
			}
			
			if(strtotime($leave_date) > strtotime($endDate)){
				$startDate = (date("Y")) . date('-m-d', $timestamp);
				$endDate = (date("Y")+1) . date('-m-d', $timestamp);
			}
			
			// calculate employee leave for year
			//SELECT employee_id, leave_type, COUNT(*) FROM `leave` WHERE employee_id = 14 AND DATE BETWEEN '2016-01-01' AND '2016-11-01' GROUP BY leave_type
			$empTotalLeavetaken = Leave::select('employee_id', 'leave_type', DB::raw('COUNT(*) tot_leave'))
										->where('employee_id', '=', $employee_id)->whereBetween('date', array($startDate, $endDate))
										->groupBy('leave_type')->get();
			$empLeaveTaken = array('annual' => '0', 'compensation' => '0', 'medical_non_hospitalisation' => '0', 'medical_hospitalisation' => '0', 'urgent' => '0');
			foreach($empTotalLeavetaken as $leave){
				$empLeaveTaken[$leave->leave_type] = $leave->tot_leave;
			}
			
			$disabled_annual = $disabled_medical_non_hospitalisation_leave = $disabled_medical_hospitalisation_leave = ' disabled style="background:#ccc" ';
			
			if($Annual_leave[$employeeServiceYear] > $empLeaveTaken['annual'])
				$disabled_annual = "";
			
			
			if($medical_non_hospitalisation_leave[$employeeServiceMonth] > $empLeaveTaken['medical_non_hospitalisation'])
				$disabled_medical_non_hospitalisation_leave = "";
			
			
			if($medical_hospitalisation_leave[$employeeServiceMonth] > $empLeaveTaken['medical_hospitalisation'])
				$disabled_medical_hospitalisation_leave = "";
			
			
			$leave_type = '<option value="">Leave type</option>';
			$urgent = '<option value="urgent">Urgent(Paid or Unpaid)</option>';
			$annual = '<option '.$disabled_annual.'value="annual">Annual</option>';
			$medical_hospitalisation_leave = '<option '.$disabled_medical_hospitalisation_leave.'value="medical_hospitalisation">Medical Hospitalisation</option>';
			$medical_non_hospitalisation_leave = '<option '.$disabled_medical_non_hospitalisation_leave.'value="medical_non_hospitalisation">Medical Non Hospitalisation</option>';
			$compensation = '<option value="compensation">Compensation</option>';
			
			$result['response'] = "success";
			$result['data'] = $leave_type.$urgent.$annual.$medical_hospitalisation_leave.$medical_non_hospitalisation_leave.$compensation;
			
		}else{			
			$result['response'] = "fails";
			$result['message'] = "Employee start date not setted.";
		}
		
		return response()->json($result)->header('Content-Type', 'json');
    }
	
}