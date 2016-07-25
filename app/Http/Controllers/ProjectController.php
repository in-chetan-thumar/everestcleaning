<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Project;
use Validator;
use App\Client;

class ProjectController extends Controller
{
  public function project_list(){
        $project = Project::all();
	return view('project.list')->with('project',$project);
    }
  
    public function project_create(){
    	$clientlist = Client::all();
			return view('project/create')->with('client',$clientlist);
    }
    
    public function project_save(Request $request){	
	$get_request = array(
		'client_id' => $request->client_id,
	    'project_name'=> $request->project_name,
	    'project_shortname' => $request->project_shortname,
	);
	
	$validator = Validator::make($get_request,[
		'client_id' => 'required',
	    'project_name' => 'required',
	    'project_shortname' => 'required',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('project/create')->withErrors($validator)->withInput();
	}
	
	$project = new Project;
	$project->client_id        = $request->client_id;
	$project->project_name	   = $request->project_name;
	$project->project_shortname_for_invoice = $request->project_shortname;
	$project->created_at       = date('Y-m-d H:i:s');
	$project->updated_at       = date('Y-m-d H:i:s');
	$project->post_user        = 1;
	$project->status	       = 1;
	$project->save();
	return redirect('/project/list');
    }
    
    public function project_editsave(Request $request){
	$get_request = array(
	    'client_id' => $request->client_id,
	    'project_name'=> $request->project_name,
	    'project_shortname' => $request->project_shortname,

	);
	
	$validator = Validator::make($get_request,[
	    'project_name' => 'required',
	    'client_id' => 'required',
	    'project_shortname' => 'required',
	]);	
	if ($validator->fails())
	{
	    return redirect('project/create')->withErrors($validator)->withInput();
	}
	
	$project = Project::find($request->id);
	$project->client_id        = $request->client_id;
	$project->project_name	   = $request->project_name;
	$project->project_shortname_for_invoice = $request->project_shortname;
	$project->updated_at        = date('Y-m-d H:i:s');
	$project->post_user         = 1;
	$project->status		   = 1;
	$project->save();
	return redirect('/project/list');
    }
    
    public function project_edit(Request $request){
	$project = Project::find($request->id);
	$client = Client::all();
	return view('project.edit',['project' => $project,'client' => $client]);
    }
    
    public function project_delete(Request $request){
	$project = Project::find($request->id);
	$project->delete();
	return redirect('/project/list')->with('status', 'Info Deleted!');
    }
    
}





