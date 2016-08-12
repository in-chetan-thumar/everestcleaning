<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Sdlsetting;
use Validator;

class SdlsettingController extends Controller
{
  public function sdl_list(){
        $sdl = Sdlsetting::all();
	return view('sdl.list')->with('sdl',$sdl);
    }
  
    public function sdl_create(){
	return view('sdl/create');
    }
    
    public function sdl_save(Request $request){	
	$get_request = array(
	    'total_wages'=>$request->total_wages,
	    'sdl_payable'=> $request->sdl_payable,
	);
	
	$validator = Validator::make($get_request,[
	    'total_wages' => 'required|numeric',
	    'sdl_payable' => 'required|numeric',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('sdl/create')->withErrors($validator)->withInput();
	}
	
	$sdl = new Sdlsetting;
	$sdl->total_wages		= $request->total_wages;
	$sdl->sdl_payable		= $request->sdl_payable;
	$sdl->created_at        = date('Y-m-d H:i:s');
	$sdl->updated_at        = date('Y-m-d H:i:s');
	$sdl->post_user         = 1;
	$sdl->status	     = 1;
	$sdl->save();
	return redirect('/sdl/list');
    }
    
    public function sdl_editsave(Request $request){
	$get_request = array(
	    'total_wages'=>$request->total_wages,
	    'sdl_payable'=> $request->sdl_payable,
	);
	
	$validator = Validator::make($get_request,[
	    'total_wages' => 'required|numeric',
	    'sdl_payable' => 'required|numeric',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('sdl/create')->withErrors($validator)->withInput();
	}
	
	$sdl = Sdlsetting::find($request->id);
	$sdl->total_wages		= $request->total_wages;
	$sdl->sdl_payable		= $request->sdl_payable;
	$sdl->updated_at        = date('Y-m-d H:i:s');
	$sdl->post_user         = 1;
	$sdl->status	     = 1;
	$sdl->save();
	return redirect('/sdl/list');
    }
    
	public function sdl_edit(Request $request){
		$sdl = Sdlsetting::find($request->id);
		return view('sdl.edit',['sdl' => $sdl]);
    }
    
    public function sdl_delete(Request $request){
		$sdl = Sdlsetting::find($request->id);
		$sdl->delete();
		return redirect('/sdl/list')->with('status', 'SDL Deleted!');
    }
    
}





