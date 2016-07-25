<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Country;
use Validator;

class CountryController extends Controller
{
  public function country_list(){
        $country = Country::all();
	return view('country.list')->with('country',$country);
    }
  
    public function country_create(){
	return view('country/create');
    }
    
    public function country_save(Request $request){	
	$get_request = array(
	    'country_name'=>$request->country_name,
	);
	
	$validator = Validator::make($get_request,[
	    'country_name' => 'required',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('country/create')->withErrors($validator)->withInput();
	}
	
	$country = new Country;
	$country->country_name	   = $request->country_name;
	$country->created_at        = date('Y-m-d H:i:s');
	$country->updated_at        = date('Y-m-d H:i:s');
	$country->post_user         = 1;
	$country->status	          = 1;
	$country->save();
	return redirect('/country/list');
    }
    
    public function country_editsave(Request $request){
	$get_request = array(
	    'country_name'=>$request->country_name,
	);
	
	$validator = Validator::make($get_request,[
	    'country_name' => 'required',
	]);	
	if ($validator->fails())
	{
	    return redirect('country/create')->withErrors($validator)->withInput();
	}
	
	$country = Country::find($request->id);
	$country->country_name	   = $request->country_name;
	$country->updated_at        = date('Y-m-d H:i:s');
	$country->post_user         = 1;
	$country->status		   = 1;
	$country->save();
	return redirect('/country/list');
    }
    
   public function country_edit(Request $request){
	$country = Country::find($request->id);
	return view('country.edit',['country' => $country]);
    }
    
     public function country_delete(Request $request){
	$country = Country::find($request->id);
	$country->delete();
	return redirect('/country/list')->with('status', 'Info Deleted!');
    }
    
}





