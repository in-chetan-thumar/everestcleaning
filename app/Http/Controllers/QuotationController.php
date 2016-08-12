<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Quotation;
use Validator;
use App\Client;
use App\Project;
use PDF;

class QuotationController extends Controller
{
	public function quotation_list(){
		$quotation = Quotation::whereNull("deleted_at")->orderBy("id", "DESC")->get();
		$clients = Client::all();
		$clients_name = array();
		foreach($clients as $client){
			$clients_name[$client->id] = $client->cli_com_name;
		}
		$projects = Project::all();
		$projects_name = array();
		foreach($projects as $project){
			$projects_name[$project->id] = $project->project_name;
		}
		return view('quotation.list')->with('quotation',$quotation)->with('projects_name', $projects_name)->with('clients_name', $clients_name);
    }
  
    public function quotation_create(){
    	$client = Client::all();
    	$project = Project::all();
		$quotation_id = Quotation::orderBy('id','desc')->first(['id']);
		if(isset($quotation_id->id) and $quotation_id->id > 0){
			$new_quotation_id = $quotation_id->id +1;
		}else{
			$new_quotation_id = 1;
		}
		
		return view('quotation/create')->with('client',$client)->with('project',$project)->with('quotation_id', $new_quotation_id);
    }
    
    public function quotation_save(Request $request){	
	$get_request = array(
	    'quotation_no'		=>$request->quotation_no,
	    'quotation_date' 		=> $request->quotation_date,
	    'client_id' 		=> $request->client_id,
	    'project_id' 		=> $request->project_id,
	    'quotation_description' => $request->quotation_description,
	    'quotation_signature' => $request->quotation_signature,
	);
	
	$validator = Validator::make($get_request,[
	    'quotation_no' => 'required',
	    'quotation_date' => 'required',
	    'client_id' => 'required',
	    'project_id' => 'required',
	     'quotation_description' => 'required',
	     'quotation_signature' => 'required',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('quotation/create')->withErrors($validator)->withInput();
	}
	
	$quotation = new Quotation;
	$quotation->quotation_no	   = $request->quotation_no;
	$quotation->quotation_date     = $request->quotation_date;
	$quotation->client_id        = $request->client_id;
	$quotation->project_id       = $request->project_id;
	$quotation->quotation_description = $request->quotation_description;
	$quotation->quotation_remark = $request->quotation_remark;
	$quotation->quotation_signature = $request->quotation_signature;
	$quotation->created_at        = date('Y-m-d H:i:s');
	$quotation->updated_at        = date('Y-m-d H:i:s');
	$quotation->post_user         = 1;
	$quotation->status	          = 1;
	$quotation->save();
	
	// Create Quotation PDF file
	$data['client_id'] = $request->client_id;
	$data['quotation_no'] = $request->quotation_no;
	$data['quotation_date'] = $request->quotation_date;
	$data['quotation_description'] = $request->quotation_description;
	$data['quotation_remark'] = $request->quotation_remark;
	$data['quotation_signature'] = $request->quotation_signature;
	$this->create_pdf($data);
	
	return redirect('/quotation/list');
    }
    
    public function quotation_editsave(Request $request){
	$get_request = array(
	    'quotation_no'		=>$request->quotation_no,
	    'quotation_date' 		=> $request->quotation_date,
	    'client_id' 		=> $request->client_id,
	    'project_id' 		=> $request->project_id,
	    'quotation_description' => $request->quotation_description,
	    'quotation_signature' => $request->quotation_signature,
	);
	
	$validator = Validator::make($get_request,[
	    'quotation_no' => 'required',
	    'quotation_date' => 'required',
	    'client_id' => 'required',
	    'project_id' => 'required',
	     'quotation_description' => 'required',
	     'quotation_signature' => 'required',
	]);	
	if ($validator->fails())
	{
	    return redirect('quotation/create')->withErrors($validator)->withInput();
	}
	
	$quotation = Quotation::find($request->id);
	$quotation->quotation_no	   = $request->quotation_no;
	$quotation->quotation_date     = $request->quotation_date;
	$quotation->client_id        = $request->client_id;
	$quotation->project_id       = $request->project_id;
	$quotation->quotation_description = $request->quotation_description;
	$quotation->quotation_remark = $request->quotation_remark;
	$quotation->quotation_signature = $request->quotation_signature;
	$quotation->updated_at        = date('Y-m-d H:i:s');
	$quotation->post_user         = 1;
	$quotation->status		   = 1;
	$quotation->save();
	
	// Create Quotation PDF file
	$data['client_id'] = $request->client_id;
	$data['quotation_no'] = $request->quotation_no;
	$data['quotation_date'] = $request->quotation_date;
	$data['quotation_description'] = $request->quotation_description;
	$data['quotation_remark'] = $request->quotation_remark;
	$data['quotation_signature'] = $request->quotation_signature;
	$this->create_pdf($data);
	
	return redirect('/quotation/list');
    }
    
   public function quotation_edit(Request $request){
	$quotation = Quotation::find($request->id);
	$client = Client::all();
    	$project = Project::all();
	return view('quotation.edit',['quotation' => $quotation,'client' => $client, 'project' => $project]);
    }
    
    public function quotation_delete(Request $request){
		$quotation = Quotation::find($request->id);
		$quotation->deleted_at = date("Y-m-d H:i:s");
		$quotation->delete();
	return redirect('/quotation/list')->with('status', 'Quotation Deleted!');
    }
    
	public function create_pdf($data){
		$client = Client::find($data['client_id']);
		$quotationPath = config('constants.QUOTATION_STORAGE');
		$html = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			
			<div style="max-width:800px; margin:auto; padding:30px; font-size:16px; line-height:24px; color:#555;">
				<table cellpadding="0" cellspacing="0" width="100%">
					<tr class="top">
						<td>
							<table width="100%">
								<tr>
									<td class="title">
										<img src="'.env('APP_URL').'/images/everest-logo.png" style="height:100px; width:300px;">
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<br><br>
							<table width="100%">
								<tr>
									<td>
										'.$client->cli_com_name.'<br>
										'.$client->cli_com_address.'<br>
									</td>
									
									<td style="text-align:right;">
										Quotation No: '.$data['quotation_no'].'<br>
										Created: '.$data['quotation_date'].'<br>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<br><div>
								'.$data['quotation_description'].'
								</div>
						</td>
					</tr>
					<tr>
						<td>
							<div>
								'.$data['quotation_remark'].'
								</div>
						</td>
					</tr>
					<tr>
						<td>
							<br><div>
								'.$data['quotation_signature'].'
								</div>
						</td>
					</tr>
				</table>';
		$quotation_no = str_replace("/", "", str_replace(":", "", $data['quotation_no']));
		PDF::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false)->save($quotationPath.$quotation_no.'.pdf');
	}
	
}





