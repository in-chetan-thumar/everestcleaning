<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Invoice;
use Validator;
use App\Client;
use App\Project;
use PDF;

class InvoiceController extends Controller
{
	public function invoice_list(){
		$invoice = Invoice::whereNull("deleted_at")->orderBy("id", "DESC")->get();
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
		return view('invoice.list')->with('invoice',$invoice)->with('projects_name', $projects_name)->with('clients_name', $clients_name);
    }
  
    public function invoice_create(){
    	$client = Client::all();
    	$project = Project::all();
		$invoice_id = Invoice::orderBy('id','desc')->first(['id']);
		return view('invoice/create')->with('client',$client)->with('project',$project)->with('invoice_id', $invoice_id->id +1);
    }
    
    public function invoice_save(Request $request){	
	$get_request = array(
	    'invoice_no'		=>$request->invoice_no,
	    'invoice_date' 		=> $request->invoice_date,
	    'client_id' 		=> $request->client_id,
	    'project_id' 		=> $request->project_id,
	    'invoice_description' => $request->invoice_description,
	    'invoice_signature' => $request->invoice_signature,
	);
	
	$validator = Validator::make($get_request,[
	    'invoice_no' => 'required',
	    'invoice_date' => 'required',
	    'client_id' => 'required',
	    'project_id' => 'required',
	     'invoice_description' => 'required',
	     'invoice_signature' => 'required',
	]);	
       
	if ($validator->fails())
	{
	    return redirect('invoice/create')->withErrors($validator)->withInput();
	}
	
	$invoice = new Invoice;
	$invoice->invoice_no	   = $request->invoice_no;
	$invoice->invoice_date     = $request->invoice_date;
	$invoice->client_id        = $request->client_id;
	$invoice->project_id       = $request->project_id;
	$invoice->invoice_description = $request->invoice_description;
	$invoice->invoice_remark = $request->invoice_remark;
	$invoice->invoice_signature = $request->invoice_signature;
	$invoice->created_at        = date('Y-m-d H:i:s');
	$invoice->updated_at        = date('Y-m-d H:i:s');
	$invoice->post_user         = 1;
	$invoice->status	          = 1;
	$invoice->save();
	
	// Create Invoice PDF file
	$data['client_id'] = $request->client_id;
	$data['invoice_no'] = $request->invoice_no;
	$data['invoice_date'] = $request->invoice_date;
	$data['invoice_description'] = $request->invoice_description;
	$data['invoice_remark'] = $request->invoice_remark;
	$data['invoice_signature'] = $request->invoice_signature;
	$this->create_pdf($data);
	
	return redirect('/invoice/list');
    }
    
    public function invoice_editsave(Request $request){
	$get_request = array(
	    'invoice_no'		=>$request->invoice_no,
	    'invoice_date' 		=> $request->invoice_date,
	    'client_id' 		=> $request->client_id,
	    'project_id' 		=> $request->project_id,
	    'invoice_description' => $request->invoice_description,
	    'invoice_signature' => $request->invoice_signature,
	);
	
	$validator = Validator::make($get_request,[
	    'invoice_no' => 'required',
	    'invoice_date' => 'required',
	    'client_id' => 'required',
	    'project_id' => 'required',
	     'invoice_description' => 'required',
	     'invoice_signature' => 'required',
	]);	
	if ($validator->fails())
	{
	    return redirect('invoice/create')->withErrors($validator)->withInput();
	}
	
	$invoice = Invoice::find($request->id);
	$invoice->invoice_no	   = $request->invoice_no;
	$invoice->invoice_date     = $request->invoice_date;
	$invoice->client_id        = $request->client_id;
	$invoice->project_id       = $request->project_id;
	$invoice->invoice_description = $request->invoice_description;
	$invoice->invoice_remark = $request->invoice_remark;
	$invoice->invoice_signature = $request->invoice_signature;
	$invoice->updated_at        = date('Y-m-d H:i:s');
	$invoice->post_user         = 1;
	$invoice->status		   = 1;
	$invoice->save();
	
	// Create Invoice PDF file
	$data['client_id'] = $request->client_id;
	$data['invoice_no'] = $request->invoice_no;
	$data['invoice_date'] = $request->invoice_date;
	$data['invoice_description'] = $request->invoice_description;
	$data['invoice_remark'] = $request->invoice_remark;
	$data['invoice_signature'] = $request->invoice_signature;
	$this->create_pdf($data);
	
	return redirect('/invoice/list');
    }
    
   public function invoice_edit(Request $request){
		$invoice = Invoice::find($request->id);
		$client = Client::all();
		$project = Project::all();
		return view('invoice.edit',['invoice' => $invoice,'client' => $client, 'project' => $project]);
    }
    
    public function invoice_delete(Request $request){
		$invoice = Invoice::find($request->id);
		$invoice->deleted_at = date("Y-m-d H:i:s");
		$invoice->save();
		return redirect('/invoice/list')->with('status', 'Invoice Deleted!');
    }
    
	public function create_pdf($data){
		$client = Client::find($data['client_id']);
		$invoicePath = config('constants.INVOICE_STORAGE');
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
										Quotation No: '.$data['invoice_no'].'<br>
										Created: '.$data['invoice_date'].'<br>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<br><div>
								'.$data['invoice_description'].'
								</div>
						</td>
					</tr>
					<tr>
						<td>
							<div>
								'.$data['invoice_remark'].'
								</div>
						</td>
					</tr>
					<tr>
						<td>
							<br><div>
								'.$data['invoice_signature'].'
								</div>
						</td>
					</tr>
				</table>';
		$invoice_no = str_replace("/", "", str_replace(":", "", $data['invoice_no']));
		PDF::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false)->save($invoicePath.$invoice_no.'.pdf');
	}
	
}