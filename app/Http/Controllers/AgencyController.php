<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Agency;
use Validator;

class AgencyController extends Controller
{
  public function agency_list(){
        $agency = Agency::all();
	return view('agency.list')->with('agency',$agency);
    }
  
    public function agency_create(){
	return view('agency/create');
    }
    
    public function agency_save(Request $request){	
	$get_request = array(
	    'agency_name'=>$request->agency_name,
	    'agency_fund'=> $request->agency_fund,
	);
	
	$validator = Validator::make($get_request,[
	    'agency_name' => 'required',
	    'agency_fund' => 'required',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('agency/create')->withErrors($validator)->withInput();
	}
	
	$agency = new Agency;
	$agency->agency_name	   = $request->agency_name;
	$agency->agency_fund	   = $request->agency_fund;
	$agency->agency_description= $request->agency_des;
	$agency->created_at        = date('Y-m-d H:i:s');
	$agency->updated_at        = date('Y-m-d H:i:s');
	$agency->post_user         = 1;
	$agency->status	          = 1;
	$agency->save();
	return redirect('/agency/list');
    }
    
    public function agency_editsave(Request $request){
	$get_request = array(
	    'agency_name'=>$request->agency_name,
	    'agency_fund'=> $request->agency_fund,
	);
	
	$validator = Validator::make($get_request,[
	    'agency_name' => 'required',
	    'agency_fund' => 'required',
	]);	
	if ($validator->fails())
	{
	    return redirect('agency/create')->withErrors($validator)->withInput();
	}
	
	$agency = Agency::find($request->id);
	$agency->agency_name	   = $request->agency_name;
	$agency->agency_fund	   = $request->agency_fund;
	$agency->agency_description= $request->agency_des;
	$agency->updated_at        = date('Y-m-d H:i:s');
	$agency->post_user         = 1;
	$agency->status		   = 1;
	$agency->save();
	return redirect('/agency/list');
    }
    
   public function agency_edit(Request $request){
	$agency = Agency::find($request->id);
	return view('agency.edit',['agency' => $agency]);
    }
    
     public function agency_delete(Request $request){
	$agency = Agency::find($request->id);
	$agency->delete();
	return redirect('/agency/list')->with('status', 'Info Deleted!');
    }
    
}





