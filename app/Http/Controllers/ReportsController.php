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
use App;

class ReportsController extends Controller
{
	public function reports_show(Request $request){

		$calendarData = array("project_id" => "", "month" => "", "year" => "");
		$projects = Project::all();
		$months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
		$years = array();
		for($i=2016; $i<(date("Y")+2); $i++){
			$years[$i] = $i;
		}
		
		$project_name = $report_month = $report_data = "";
		if($request->month && $request->year && $request->project_id){
			$calendarData['project_id'] = $project_id = $request->project_id;
			$calendarData['month'] = $month = $request->month;
			$calendarData['year'] = $year = $request->year;
			$calendarDate = $request->year."-".$request->month."-01";
			
			$project = Project::find($project_id);
			$project_name = $project->project_name;
			$report_month = $months[$month]." ". $year;
			$timestamp    = strtotime('01'.'-'.$month.'-'.$year);
			$startDate = date('Y-m-01', $timestamp);
			$endDate  = date('Y-m-t', $timestamp);
			
			$report_data = EmployeeSchedule::where('project_id', '=', $project_id)->where('date', '>=', $startDate)->where('date', '<=', $endDate)
						->leftjoin('users','users.id', '=', 'employee_schedule.employee_id')
						->select('employee_schedule.date', 'employee_schedule.start_time', 'employee_schedule.end_time', 'employee_schedule.rate', 'users.full_name')
						->orderBy('employee_schedule.date', 'ASC')->orderBy('employee_schedule.start_time', 'ASC')
						->get();
		}
		
		return view('reports.show')->with('calendarData',$calendarData)->with('projects',$projects)->with('months', $months)->with('years', $years)->with('project_name', $project_name)->with('report_month', $report_month)->with('report_data', $report_data)->with('report_data', $report_data);
    }
	
	public function reports_export(Request $request){
		$project_id = $request->project_id;
		$month = $request->month;
		$year = $request->year;
		$export_type = $request->type;
		$pdf = App::make('dompdf.wrapper');
		
		$months = array('01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
		$timestamp = strtotime('01'.'-'.$month.'-'.$year);
		$startDate = date('Y-m-01', $timestamp);
		$endDate  = date('Y-m-t', $timestamp);
		$project = Project::find($project_id);
		$project_name = $project->project_name;
		$report_month = $months[$month]." ". $year;
		$report_data = EmployeeSchedule::where('project_id', '=', $project_id)->where('date', '>=', $startDate)->where('date', '<=', $endDate)
						->leftjoin('users','users.id', '=', 'employee_schedule.employee_id')
						->select('employee_schedule.date', 'employee_schedule.start_time', 'employee_schedule.end_time', 'employee_schedule.rate', 'users.full_name')
						->orderBy('employee_schedule.date', 'ASC')->orderBy('employee_schedule.start_time', 'ASC')
						->get();
		$g_total = 0;
		$html = '
			<div style="padding:10px;">
				<div style="padding:5px;"><b>Project Name: </b>'.$project_name.'</div>
				<div style="padding:5px;"><b>Report for the month of: </b>'.$report_month.'</div>
			</div>

			<div style="padding:10px;">
				<table cellpadding="5" cellspacing="5">
					<tr>
						<th>#</th>
						<th align="left" width="100">Date</th>
						<th align="left" width="100">time</th>
						<th align="left" width="150">Worker</th>
						<th align="left" width="50">Paid amount</th>
					</tr>';
					foreach($report_data as $key => $data){
						$html .= '<tr>
							<th>'.($key + 1) .'</th>
							<td>'.$data->date.'</td>
							<td>'.$data->start_time.' to '.$data->end_time.'</td>
							<td>'.$data->full_name.'</td>
							<td>$'.$data->rate.'</td>
						</tr>';
						$g_total = $g_total + $data->rate;
					}
					
					$html .= '<tr>
						<th> </th>
						<th> </th>
						<th> </th>
						<th align="left"> Total Amount </th>
						<th align="left">$ '.$g_total.' </th>
					</tr>
				</table>
			</div>';

		$pdf_name = $project_name." ".$report_month.".pdf";
    	$pdf->loadHTML($html);
		if($export_type == "pdf")
			return $pdf->download($pdf_name);
		else
			return $pdf->stream($pdf_name);
	}
	
}