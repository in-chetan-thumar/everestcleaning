<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Cpfsetting;
use Validator;

class CpfsettingController extends Controller
{
  public function cpf_list(){
        $cpf = Cpfsetting::all();
	return view('cpf.list')->with('cpf',$cpf);
    }
  
    public function cpf_create(){
	return view('cpf/create');
    }
    
    public function cpf_save(Request $request){	
	$get_request = array(
	    'aged_from'=>$request->aged_from,
	    'aged_to'=> $request->aged_to,
	    'employer_rate' => $request->employer_rate,
	    'employee_rate' => $request->employee_rate,
	);
	
	$validator = Validator::make($get_request,[
	    'aged_from' => 'required|numeric',
	    'aged_to' => 'required|numeric',
	    'employer_rate' => 'required|numeric',
	    'employee_rate' => 'required|numeric',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('cpf/create')->withErrors($validator)->withInput();
	}
	
	$cpf = new Cpfsetting;
	$cpf->aged_from		= $request->aged_from;
	$cpf->aged_to		= $request->aged_to;
	$cpf->cpf_type		= $request->cpf_type;
	$cpf->employer_rate	= $request->employer_rate;
	$cpf->employee_rate	= $request->employee_rate;
	$cpf->created_at        = date('Y-m-d H:i:s');
	$cpf->updated_at        = date('Y-m-d H:i:s');
	$cpf->post_user         = 1;
	$cpf->status	     = 1;
	$cpf->save();
	return redirect('/cpf/list');
    }
    
    public function cpf_editsave(Request $request){
	$get_request = array(
	    'aged_from'=>$request->aged_from,
	    'aged_to'=> $request->aged_to,
	    'employer_rate' => $request->employer_rate,
	    'employee_rate' => $request->employee_rate,
	);
	
	$validator = Validator::make($get_request,[
	    'aged_from' => 'required|numeric',
	    'aged_to' => 'required|numeric',
	    'employer_rate' => 'required|numeric',
	    'employee_rate' => 'required|numeric',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('cpf/create')->withErrors($validator)->withInput();
	}
	
	$cpf = Cpfsetting::find($request->id);
	$cpf->aged_from		= $request->aged_from;
	$cpf->aged_to		= $request->aged_to;
	$cpf->cpf_type		= $request->cpf_type;
	$cpf->employer_rate	= $request->employer_rate;
	$cpf->employee_rate	= $request->employee_rate;
	$cpf->updated_at        = date('Y-m-d H:i:s');
	$cpf->post_user         = 1;
	$cpf->status	     = 1;
	$cpf->save();
	return redirect('/cpf/list');
    }
    
   public function cpf_edit(Request $request){
	$cpf = Cpfsetting::find($request->id);
	return view('cpf.edit',['cpf' => $cpf]);
    }
    
     public function cpf_delete(Request $request){
	$cpf = Cpfsetting::find($request->id);
	$cpf->delete();
	return redirect('/cpf/list')->with('status', 'Info Deleted!');
    }
    
}





