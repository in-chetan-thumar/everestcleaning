<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Client;
use App\Clientcontactperson;
use Validator;
use DB;

class ClientController extends Controller
{
  public function client_list(){
       $client = Client::all();
	return view('client.list')->with('client',$client);
    }
  
    public function client_create(){
	return view('client/create');
    }
    
    public function client_save(Request $request){	
	$get_request = array(
	    'cli_com_name'=>$request->cli_com_name,
	    'cli_com_address' => $request->cli_com_address,
	);
	
	$validator = Validator::make($get_request,[
	    'cli_com_name' => 'required',
	    'cli_com_address' => 'required'
	]);	
       
	if ($validator->fails())
	{
	    return redirect('client/create')->withErrors($validator)->withInput();
	}
	
	$client = new Client;
	$client->cli_com_name	   = $request->cli_com_name;
	$client->cli_com_address 	= $request->cli_com_address;
	$client->cli_com_phone     = $request->cli_com_phone;
	$client->created_at        = date('Y-m-d H:i:s');
	$client->updated_at        = date('Y-m-d H:i:s');
	$client->post_user         = 1;
	$client->status	          = 1;
	$client->save();
	$getlast_instertid = DB::getPdo()->lastInsertId();

	
	for($i=0;$i<count($request->getall_contact);$i++){
		if($request->cname[$i] != "" && $request->cemail[$i] != "" && $request->cphone[$i] != "" && $request->cposition[$i] != ""){
		$id = DB::table('client_contactperson')->insert(['cli_companyid' => $getlast_instertid,'cli_cname' => $request->cname[$i],'cli_cemail' => $request->cemail[$i],'cli_cphone' => $request->cphone[$i],'cli_cposition' => $request->cposition[$i]]
		);
		}
	}
	   return redirect('/client/list');
    }
    
    public function client_editsave(Request $request){
	$get_request = array(
	    'cli_com_name'=>$request->cli_com_name,
	    'cli_com_address' => $request->cli_com_address,
	);
	
	$validator = Validator::make($get_request,[
	    'cli_com_name' => 'required',
	    'cli_com_address' => 'required'
	]);	
	if ($validator->fails())
	{
	    return redirect('client/create')->withErrors($validator)->withInput();
	}
	
	$client = Client::find($request->id);
	$client->cli_com_name	   = $request->cli_com_name;
	$client->cli_com_address 	= $request->cli_com_address;
	$client->cli_com_phone     = $request->cli_com_phone;
	$client->updated_at        = date('Y-m-d H:i:s');
	$client->post_user         = 1;
	$client->status		   = 1;
	$client->save();
	return redirect('/client/list');
    }
    
   public function client_edit(Request $request){
	$client = Client::find($request->id);
	$client_contactperson = Clientcontactperson::where('cli_companyid',$request->id)->get();
	return view('client.edit',['client' => $client],['client_contactperson' => $client_contactperson]);
    }
    
     public function client_delete(Request $request){
	$client = Client::find($request->id);
	$client->delete();
	return redirect('/client/list')->with('status', 'Info Deleted!');
    }
    
}





