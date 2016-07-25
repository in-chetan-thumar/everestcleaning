<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Passstatus;
use Validator;

class PassstatusController extends Controller
{
  public function pass_list(){
        $pass = Passstatus::all();
	return view('passstatus.list')->with('pass',$pass);
    }
  
    public function pass_create(){
	return view('passstatus/create');
    }
    
    public function pass_save(Request $request){	
	$get_request = array(
	    'pass_name'=>$request->pass_name,
	);
	
	$validator = Validator::make($get_request,[
	    'pass_name' => 'required|unique:pass_status|string',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('passstatus/create')->withErrors($validator)->withInput();
	}
	
	$pass = new Passstatus;
	$pass->pass_name	= $request->pass_name;
	$pass->pass_remark	= $request->pass_remark;
	$pass->created_at        = date('Y-m-d H:i:s');
	$pass->updated_at        = date('Y-m-d H:i:s');
	$pass->post_user         = 1;
	$pass->status	     = 1;
	$pass->save();
	return redirect('/passstatus/list');
    }
    
    public function pass_editsave(Request $request){
	$get_request = array(
	    'pass_name'=>$request->pass_name,
	);
	
	$validator = Validator::make($get_request,[
	    'pass_name' => 'required'
	]);	
       
	if ($validator->fails())
	{
	    return redirect('passstatus/create')->withErrors($validator)->withInput();
	}
	
	$pass = Passstatus::find($request->id);
	$pass->pass_name	= $request->pass_name;
	$pass->pass_remark      = $request->pass_remark;
	$pass->updated_at        = date('Y-m-d H:i:s');
	$pass->post_user         = 1;
	$pass->status	     = 1;
	$pass->save();
	return redirect('/passstatus/list');
    }
    
   public function pass_edit(Request $request){
	$pass = Passstatus::find($request->id);
	return view('passstatus.edit',['pass' => $pass]);
    }
    
     public function pass_delete(Request $request){
	$pass = Passstatus::find($request->id);
	$pass->delete();
	return redirect('/passstatus/list')->with('status', 'Info Deleted!');
    }
    
}





