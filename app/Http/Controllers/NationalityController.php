<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Nationality;
use Validator;

class NationalityController extends Controller
{
  public function nationality_list(){
        $nationality = Nationality::all();
	return view('nationality.list')->with('nationality',$nationality);
    }
  
    public function nationality_create(){
	return view('nationality/create');
    }
    
    public function nationality_save(Request $request){	
	$get_request = array(
	    'nationality_name'=>$request->nationality_name,
	);
	
	$validator = Validator::make($get_request,[
	    'nationality_name' => 'required',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('nationality/create')->withErrors($validator)->withInput();
	}
	
	$nationality = new Nationality;
	$nationality->nationality_name	   = $request->nationality_name;
	$nationality->created_at        = date('Y-m-d H:i:s');
	$nationality->updated_at        = date('Y-m-d H:i:s');
	$nationality->post_user         = 1;
	$nationality->status	          = 1;
	$nationality->save();
	return redirect('/nationality/list');
    }
    
    public function nationality_editsave(Request $request){
	$get_request = array(
	    'nationality_name'=>$request->nationality_name,
	);
	
	$validator = Validator::make($get_request,[
	    'nationality_name' => 'required',
	]);	
	if ($validator->fails())
	{
	    return redirect('nationality/create')->withErrors($validator)->withInput();
	}
	
	$nationality = Nationality::find($request->id);
	$nationality->nationality_name	   = $request->nationality_name;
	$nationality->updated_at        = date('Y-m-d H:i:s');
	$nationality->post_user         = 1;
	$nationality->status		   = 1;
	$nationality->save();
	return redirect('/nationality/list');
    }
    
   public function nationality_edit(Request $request){
	$nationality = Nationality::find($request->id);
	return view('nationality.edit',['nationality' => $nationality]);
    }
    
     public function nationality_delete(Request $request){
	$nationality = Nationality::find($request->id);
	$nationality->delete();
	return redirect('/nationality/list')->with('status', 'Info Deleted!');
    }
    
}





