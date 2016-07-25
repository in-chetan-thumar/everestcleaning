<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Race;
use Validator;

class RaceController extends Controller
{
  public function race_list(){
        $race = Race::all();
	return view('race.list')->with('race',$race);
    }
  
    public function race_create(){
	return view('race/create');
    }
    
    public function race_save(Request $request){	
	$get_request = array(
	    'race_name'=>$request->race_name,
	);
	
	$validator = Validator::make($get_request,[
	    'race_name' => 'required',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('race/create')->withErrors($validator)->withInput();
	}
	
	$race = new Race;
	$race->race_name	   = $request->race_name;
	$race->created_at        = date('Y-m-d H:i:s');
	$race->updated_at        = date('Y-m-d H:i:s');
	$race->post_user         = 1;
	$race->status	          = 1;
	$race->save();
	return redirect('/race/list');
    }
    
    public function race_editsave(Request $request){
	$get_request = array(
	    'race_name'=>$request->race_name,
	);
	
	$validator = Validator::make($get_request,[
	    'race_name' => 'required',
	]);	
	if ($validator->fails())
	{
	    return redirect('race/create')->withErrors($validator)->withInput();
	}
	
	$race = Race::find($request->id);
	$race->race_name	   = $request->race_name;
	$race->updated_at        = date('Y-m-d H:i:s');
	$race->post_user         = 1;
	$race->status		   = 1;
	$race->save();
	return redirect('/race/list');
    }
    
   public function race_edit(Request $request){
	$race = Race::find($request->id);
	return view('race.edit',['race' => $race]);
    }
    
     public function race_delete(Request $request){
	$race = Race::find($request->id);
	$race->delete();
	return redirect('/race/list')->with('status', 'Info Deleted!');
    }
    
}





