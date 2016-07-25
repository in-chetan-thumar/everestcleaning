<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Invoice;
use Validator;
use App\Client;
use App\Project;

class InvoiceController extends Controller
{
  public function invoice_list(){
        $invoice = Invoice::all();
	return view('invoice.list')->with('invoice',$invoice);
    }
  
    public function invoice_create(){
    	$client = Client::all();
    	$project = Project::all();
		return view('invoice/create')->with('client',$client)->with('project',$project);
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
	$invoice->delete();
	return redirect('/invoice/list')->with('status', 'Info Deleted!');
    }
    
}





