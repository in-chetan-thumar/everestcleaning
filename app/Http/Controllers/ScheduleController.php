<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Client;
use App\Project;
use App\User;
use App\EmployeeSchedule;

class ScheduleController extends Controller
{
	public function schedule_show(Request $request){	  

		$calendarData = array("project_id" => "", "month" => "", "year" => "");
		$calendarDate = date('Y-m-d');
		$projects = Project::all();
		$users = User::get();
		$months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
		$years = array();
		for($i=2016; $i<(date("Y")+2); $i++){
			$years[$i] = $i;
		}
		if($request->month && $request->year && $request->project_id){
			$calendarData['project_id'] = $request->project_id;
			$calendarData['month'] = $request->month;
			$calendarData['year'] = $request->year;
			$calendarDate = $request->year."-".$request->month."-01";
		}
		
		$month_list = array();
		$month = date('n');
		$max = (12-$month) + 13; 
		for ($x = 0; $x < $max; $x++) {
			$month_list[date('m-Y', mktime(0,0,0,$month + $x,1))] = date('M (Y)', mktime(0,0,0,$month + $x,1));
		}
		
		$time_list = array("00:01","00:30","01:00","01:30","02:00","02:30","03:00","03:30","04:00","04:30","05:00","05:30","06:00","06:30","07:00","07:30","08:00","08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00","12:30","13:00","13:30","14:00","14:30","15:00","15:30","16:00","16:30","17:00","17:30","18:00","18:30","19:00","19:30","20:00","20:30","21:00","21:30","22:00","22:30","23:00","23:30");
		
		
		if(isset($_POST['save_schedule'])){
		//	print_r($_POST);
			$calendarDate = $schedule_date = $_POST['schedule_date'];
			$selected_month = $request->selected_month;
			$employee_ids = $request->employee_id;
			$project_id = $request->project_id;
			$start_time = $request->start_time;
			$end_time = $request->end_time;
			$rate = $request->rate;			
			
			$str_schedule_date = strtotime($schedule_date);
			$schedule_day = date('l', $str_schedule_date);
			$start_month = date('m', $str_schedule_date);
			$start_year = date('Y', $str_schedule_date);
			
			$calendarData['project_id'] = $request->project_id;
			$calendarData['month'] = $start_month;
			$calendarData['year'] = $start_year;
			
			$schedule_days = array();
			foreach($selected_month AS $month2){
				list($month, $year) = explode("-", $month2);
				
				$timestamp    = strtotime('01'.'-'.$month.'-'.$year);
				$startDate = date('Y-m-01', $timestamp);
				$endDate  = date('Y-m-t', $timestamp);
				
				if($start_month == $month AND $start_year == $year){
					$days = $this->getDateForSpecificDayBetweenDates($schedule_date, $endDate, $schedule_day);
					$schedule_days = array_merge($schedule_days, $days);
					
				}else{
					$days = $this->getDateForSpecificDayBetweenDates($startDate, $endDate, $schedule_day);
					$schedule_days = array_merge($schedule_days, $days);
				}
			}
			
			foreach($schedule_days AS $schedule_day){
				foreach($employee_ids as $key => $employee_id){
					$employeeSchedule = new EmployeeSchedule;
					$employeeSchedule->project_id = $project_id;
					$employeeSchedule->employee_id = $employee_id;
					$employeeSchedule->date = $schedule_day;
					$employeeSchedule->start_time = $start_time[$key];
					$employeeSchedule->end_time = $end_time[$key];
					$employeeSchedule->rate = $rate[$key];
					$employeeSchedule->created_at        = date('Y-m-d H:i:s');
					$employeeSchedule->save();					
					
				}
			}
		}
		
		
		
		return view('schedule.show')->with('calendarData',$calendarData)->with('projects',$projects)->with('months', $months)->with('years', $years)->with('users', $users)->with('month_list', $month_list)->with('time_list', $time_list)->with('calendarDate', $calendarDate);
    }
	
	public function schedule_employee_list(Request $request){
		$start = $request->start;
		$end = $request->end;
		$project_id = $request->project_id;
		
		$employeeSchedules = EmployeeSchedule::where('date', '>=', $start)->where('date', '<=', $end);
		if(isset($project_id) AND $project_id > 0){
			$employeeSchedules->where('project_id', $project_id);
		}
		$employeeSchedules = $employeeSchedules->get();
		$schedules = array();
		
		foreach($employeeSchedules as $employeeSchedule){
			$id = $employeeSchedule->id;
			$user = User::find($employeeSchedule->employee_id);
			$title = $user->full_name;
			$start = $employeeSchedule->date."T".str_replace("","", str_replace("","",$employeeSchedule->start_time)).":00-05:00";
			$end = $employeeSchedule->date."T".str_replace("","", str_replace("","",$employeeSchedule->end_time)).":00-05:00";
			$schedules[] = array("id"=>$id, "title" => $title, "start" => $start, "end" => $end);
		}
		
		return response()->json($schedules)->header('Content-Type', 'json');
	}
	
	public function getDateForSpecificDayBetweenDates($startDate, $endDate, $day){
	
		$startDate = strtotime($startDate);
		$endDate = strtotime($endDate);

		$days = array();
		for($i = strtotime($day, $startDate); $i <= $endDate; $i = strtotime('+1 week', $i)){
			$day = date('Y-m-d', $i);
			$days[] = $day;
		}
		
		return $days;
	}
	
	public function schedule_delete(Request $request){
		$schedule_id = $request->id;
		
		$employeeSchedules = EmployeeSchedule::find($schedule_id);
		$employeeSchedules->delete();
	}
	
}