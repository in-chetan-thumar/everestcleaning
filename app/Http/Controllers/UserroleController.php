<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Userrole;
use App\Usercredential;
use Validator;

class UserroleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function userrole_list(){
	$userrole = Userrole::all();
	return view('userrole.list',['userrole' => $userrole]);
    }
  
    public function userrole_create(){
	$usercredential = Usercredential::all();
	return view('userrole/create')->with('usercredential',$usercredential);
    }
    
    public function userrole_save(Request $request){	
	$get_request = array(
	    'role_name'=>$request->role_name,
	    'credential_list'=> $request->credential_list,
	);
	
	$validator = Validator::make($get_request,[
	    'role_name' => 'required',
	    'credential_list' => 'required',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('userrole/create')->withErrors($validator)->withInput();
	}
	$credential =	implode(',',$request->credential_list);
	
	
	$userrole = new Userrole;
	$userrole->role_name	     = $request->role_name;
	$userrole->credential_list   = $credential;
	$userrole->created_at        = date('Y-m-d H:i:s');
	$userrole->updated_at        = date('Y-m-d H:i:s');
	$userrole->post_user         = 1;
	$userrole->remember_token    = $request->_token;
	$userrole->status	     = 1;
	$userrole->save();
	return redirect('/userrole/list');
    }
    
    public function userrole_editsave(Request $request){
	$get_request = array(
	    'role_name'=>$request->role_name,
	    'credential_list'=> $request->credential_list,
	);
	
	$validator = Validator::make($get_request,[
	    'role_name' => 'required',
	    'credential_list' => 'required',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('userrole/create')->withErrors($validator)->withInput();
	}
	$credential =	implode(',',$request->credential_list);
	
	
	$userrole = Userrole::find($request->id);
	$userrole->role_name	     = $request->role_name;
	$userrole->credential_list   = $credential;
	$userrole->updated_at        = date('Y-m-d H:i:s');
	$userrole->post_user         = 1;
	$userrole->remember_token    = $request->_token;
	$userrole->status	     = 1;
	$userrole->save();
	return redirect('/userrole/list');
    }
    
    
    public function userrole_view(Request $request){
	$usercredential = Usercredential::all();
	$userrole = Userrole::find($request->id);
	return view('userrole.view',['userrole' => $userrole])->with('usercredential',$usercredential);
    }
    
   public function userrole_edit(Request $request){
       $usercredential = Usercredential::all();
	$userrole = Userrole::find($request->id);
	return view('userrole.edit',['userrole' => $userrole])->with('usercredential',$usercredential);
    }
    
     public function userrole_delete(Request $request){
	$userrole = Userrole::find($request->id);
	$userrole->delete();
	return redirect('/userrole/list')->with('status', 'Info Deleted!');
    }
   
}



