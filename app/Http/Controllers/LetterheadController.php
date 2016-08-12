<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Letterhead;
use Validator;
use App\Client;
use App\Project;
use PDF;

class LetterheadController extends Controller
{
	public function letterhead_list(){
		$letterhead = Letterhead::whereNull("deleted_at")->orderBy("id", "DESC")->get();
		return view('letterhead.list')->with('letterhead',$letterhead);
    }
  
    public function letterhead_create(){
    	$client = Client::all();
    	$project = Project::all();
		$letterhead_id = Letterhead::orderBy('id','desc')->first(['id']);
		if(isset($letterhead_id->id) and $letterhead_id->id > 0){
			$new_letterhead_id = $letterhead_id->id +1;
		}else{
			$new_letterhead_id = 1;
		}
		
		return view('letterhead/create')->with('client',$client)->with('project',$project)->with('letterhead_id', $new_letterhead_id);
    }
    
    public function letterhead_save(Request $request){	
	$get_request = array(
	    'letterhead_no'		=>$request->letterhead_no,
		'letterhead_subject'	=>$request->letterhead_subject,
	    'letterhead_date' 		=> $request->letterhead_date,
	    'letterhead_description' => $request->letterhead_description,
	    'letterhead_signature' => $request->letterhead_signature,
	);
	$validator = Validator::make($get_request,[
	    'letterhead_no' => 'required',
		'letterhead_subject' => 'required',
	    'letterhead_date' => 'required',
	     'letterhead_description' => 'required',
	     'letterhead_signature' => 'required',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('letterhead/create')->withErrors($validator)->withInput();
	}
	
	$letterhead = new Letterhead;
	$letterhead->letterhead_no	   		= $request->letterhead_no;
	$letterhead->letterhead_subject	  	= $request->letterhead_subject;	
	$letterhead->letterhead_date     	= $request->letterhead_date;
	$letterhead->letterhead_description = $request->letterhead_description;
	$letterhead->letterhead_signature 	= $request->letterhead_signature;
	$letterhead->created_at        		= date('Y-m-d H:i:s');
	$letterhead->updated_at        		= date('Y-m-d H:i:s');
	$letterhead->post_user         		= 1;
	$letterhead->status	          		= 1;
	$letterhead->save();
	
	// Create Letterhead PDF file
	$data['letterhead_no'] = $request->letterhead_no;
	$data['letterhead_subject'] = $request->letterhead_subject;
	$data['letterhead_date'] = $request->letterhead_date;
	$data['letterhead_description'] = $request->letterhead_description;
	$data['letterhead_signature'] = $request->letterhead_signature;
	$this->create_pdf($data);
	
	return redirect('/letterhead/list');
    }
    
    public function letterhead_editsave(Request $request){
	$get_request = array(
	    'letterhead_no'		=>$request->letterhead_no,
		'letterhead_subject'		=>$request->letterhead_subject,
	    'letterhead_date' 		=> $request->letterhead_date,
	    'letterhead_description' => $request->letterhead_description,
	    'letterhead_signature' => $request->letterhead_signature,
	);
	
	$validator = Validator::make($get_request,[
	    'letterhead_no' => 'required',
	    'letterhead_subject' => 'required',
		'letterhead_date' => 'required',
	     'letterhead_description' => 'required',
	     'letterhead_signature' => 'required',
	]);	
	if ($validator->fails())
	{
	    return redirect('letterhead/create')->withErrors($validator)->withInput();
	}
	
	$letterhead = Letterhead::find($request->id);
	$letterhead->letterhead_no	   = $request->letterhead_no;
	$letterhead->letterhead_subject	   = $request->letterhead_subject;
	$letterhead->letterhead_date     = $request->letterhead_date;
	$letterhead->letterhead_description = $request->letterhead_description;
	$letterhead->letterhead_signature = $request->letterhead_signature;
	$letterhead->updated_at        = date('Y-m-d H:i:s');
	$letterhead->post_user         = 1;
	$letterhead->status		   = 1;
	$letterhead->save();
	
	// Create Letterhead PDF file
	$data['letterhead_no'] = $request->letterhead_no;
	$data['letterhead_subject'] = $request->letterhead_subject;
	$data['letterhead_date'] = $request->letterhead_date;
	$data['letterhead_description'] = $request->letterhead_description;
	$data['letterhead_signature'] = $request->letterhead_signature;
	$this->create_pdf($data);
	
	
	return redirect('/letterhead/list');
    }
    
   public function letterhead_edit(Request $request){
	$letterhead = Letterhead::find($request->id);
	$client = Client::all();
    	$project = Project::all();
	return view('letterhead.edit',['letterhead' => $letterhead,'client' => $client, 'project' => $project]);
    }
    
     public function letterhead_delete(Request $request){
		$letterhead = Letterhead::find($request->id);
		$letterhead->deleted_at = date("Y-m-d H:i:s");
		$letterhead->save();
		return redirect('/letterhead/list')->with('status', 'letterhead Deleted!');
    }
    
	
	public function create_pdf($data){
		$letterheadPath = config('constants.LETTERHEAD_STORAGE');
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
							<br>
							Registration No: 44495600W<br>
							Letterhead Subject: '.$data['letterhead_subject'].'<br>
							Created: '.$data['letterhead_date'].'<br>
						</td>
					</tr>
					<tr>
						<td>
							<br><div>
								'.$data['letterhead_description'].'
								</div>
						</td>
					</tr>
					<tr>
						<td>
							<br><div>
								'.$data['letterhead_signature'].'
								</div>
						</td>
					</tr>
				</table>';
	PDF::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false)->save($letterheadPath.$data['letterhead_no'].'.pdf');
	}
	
}





