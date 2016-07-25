<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Workshift;
use Validator;

class WorkshiftController extends Controller
{
  public function wshift_list(){
        $workshift = Workshift::all();
	return view('workshift.list')->with('workshift',$workshift);
    }
  
    public function wshift_create(){
	return view('workshift/create');
    }
    
    public function wshift_save(Request $request){	
	$get_request = array(
	    'wshift_name'=>$request->wshift_name,
	    'total_working_days' => $request->total_working_days,
	    'working_hour' => $request->working_hour,
	);
	
	$validator = Validator::make($get_request,[
	    'wshift_name' => 'required|unique:ec_workshift|string',
	    'total_working_days' => 'required',
	    'working_hour' => 'required',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('workshift/create')->withErrors($validator)->withInput();
	}
	
	$workshift = new Workshift;
	$workshift->wshift_name		= $request->wshift_name;
	$workshift->total_working_days	= $request->total_working_days;
	$workshift->working_hours_perday = $request->working_hour;
	$workshift->created_at		= date('Y-m-d H:i:s');
	$workshift->updated_at		= date('Y-m-d H:i:s');
	$workshift->post_user		= 1;
	$workshift->status	        = 1;
	$workshift->save();
	return redirect('/workshift/list');
    }
    
    public function wshift_editsave(Request $request){
	$get_request = array(
	    'wshift_name'=>$request->wshift_name,
	    'total_working_days' => $request->total_working_days,
	    'working_hour' => $request->working_hour,
	);
	
	$validator = Validator::make($get_request,[
	    'wshift_name' => 'required',
	    'total_working_days' => 'required',
	    'working_hour' => 'required',
	]);		
	if ($validator->fails())
	{
	    return redirect('workshift/edit/'.$request->id)->withErrors($validator)->withInput();
	}
	
	$workshift = Workshift::find($request->id);
	
	$workshift->wshift_name		= $request->wshift_name;
	$workshift->total_working_days	= $request->total_working_days;
	$workshift->working_hours_perday = $request->working_hour;
	$workshift->updated_at        = date('Y-m-d H:i:s');
	$workshift->post_user         = 1;
	$workshift->status		   = 1;
	$workshift->save();
	return redirect('/workshift/list');
    }
    
   public function wshift_edit(Request $request){
	$workshift = Workshift::find($request->id);
	return view('workshift.edit',['workshift' => $workshift]);
    }
    
     public function wshift_delete(Request $request){
	$workshift = Workshift::find($request->id);
	$workshift->delete();
	return redirect('/workshift/list')->with('status', 'Info Deleted!');
    }
    
}





