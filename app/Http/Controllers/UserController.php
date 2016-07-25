<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Validator;
use DB;
use App\Country;
use App\Nationality;
use App\Race;
use App\Agency;
use App\Userrole;
use App\Workshift;
use App\Passstatus;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
   
     public function user_list(){
	$user = User::get();
	return view('user.list',['user' => $user]);
		
    }
    
    public function user_create(){
	$country = Country::all();
	$nationality = Nationality::all();
	$race = Race::all();
	$agency = Agency::all();
	$userrole = Userrole::all();
	$wshift = Workshift::all();
	$pass = Passstatus::all();
	return view('user/create')->with('country',$country)->with('nationality',$nationality)->with('race',$race)->with('agency',$agency)->with('userrole',$userrole)->with('wshift',$wshift)->with('pass',$pass);
    }
    
    public function user_save(Request $request){    
	
	$get_request = array(
	    'full_name'=>$request->full_name,
	    'user_name' => $request->user_name,
	    'gender' =>$request->gender,
	   'marital_status'=> $request->marital_status,
	    'dob' => $request->dob,
	     'country_of_birth' =>$request->country_of_birth,
	   'nationality' =>  $request->nationality,
	    'race' =>$request->race,
	    'start_working_date' => $request->start_working_date,
	    'position' =>$request->position,
	    //'email' => $request->email,
	    'password' => $request->password,
	    'cpassword' => $request->cpassword,
	    'phone' => $request->phone,
	    'nirc' => $request->nirc,
	    'address' =>$request->address,
	     'pass_status' =>$request->pass_status,
	    'working_shift' => $request->working_shift,
	    'agency' =>$request->agency,
	    'pay_status' => $request->pay_status,
	    'user_role' =>$request->user_role,
	    'salary' =>$request->salary,
	);
	
	$validator = Validator::make($get_request,[
	    'full_name' => 'required|string',
	     'user_name' => 'required|unique:users|string',
            'gender' => 'required',
	    'marital_status' => 'required',
	     'dob' => 'required',
	    'country_of_birth' => 'required',
	    'nationality' => 'required',
	    'race' => 'required',
	    'start_working_date' => 'required',
	     'position' => 'required',
	   // 'email' => 'required|email|unique:users',
	     'password' => array('regex:/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).+$/','min:8','required'),
	    'cpassword' => 'required|same:password',
	    'phone' => 'required|numeric',
	    'nirc' => 'required|string|unique:users',
	    'address' => 'required|string',
	    'pass_status' => 'required',
	    'working_shift' => 'required',
	    'agency' => 'required',
	     'pay_status' => 'required',
	    'user_role' => 'required',
	    'salary' => 'required|numeric',
	]);
	
       
	if ($validator->fails())
	{
	    return redirect('user/create')->withErrors($validator)->withInput();
	}
	
	$dob = $request->year."-".$request->month."-".$request->day;
	if($request->cpf_status == "on"){
	    $cpf_status = 1;
	}
	else{
	    $cpf_status = 0;
	}
	if($request->levy_status == "on"){
	    $levy_status = 1;
	}
	else{
	    $levy_status = 0;
	}
	function getExtension($str) {
	    $i = strrpos($str,".");
	    if (!$i) { return ""; }
	    $l = strlen($str) - $i;
	    $ext = substr($str,$i+1,$l);
	    return $ext;
	 }

	 $image=$_FILES['photo']['name'];
	 if($image) 
	 {
		 $filename = stripslashes($image);
		 $extension = getExtension($filename);
		 $extension = strtolower($extension);
		 if($extension == "jpg" || $extension == "png" || $extension== "gif"){
			 $imgname = rand().time();
			 $image_name= $imgname.'.'.$extension;
			 $newpath= base_path()."/images/user/".$image_name;
			 $copied = copy($_FILES['photo']['tmp_name'], $newpath);
			 if (!$copied) 
			 {
				 return Redirect::to('products');
			 }
			 else
			 {
				 $get_photo = $image_name;		
			 }
		 }	
		 else{
			 return Redirect::to('user');
		 }	
	 }
	 else{
		 $get_photo = "";
	 }
	$user = new User;
	$user->full_name            = $request->full_name;
	$user->user_name 		 = $request->user_name;
	$user->gender		    = $request->gender;
	$user->maritalstatus	    = $request->marital_status;
	$user->dob		    = $request->dob;
	$user->country_of_birth	    = $request->country_of_birth;
	$user->nationality	    = $request->nationality;
	$user->race		    = $request->race;
	$user->start_employment	    = date('Y-m-d',strtotime($request->start_working_date));
	$user->leave_employment	    = date('Y-m-d',strtotime($request->end_working_date));
	$user->position		    = $request->position;
	$user->email		    = $request->email;
	$user->password		    = bcrypt($request->password);
	$user->phone		    = $request->phone;
	$user->nirc		    = $request->nirc;
	$user->address		    = $request->address;
	$user->pass_status	    = $request->pass_status;
	$user->time_shift	    = $request->working_shift;
	$user->agency		    = $request->agency;
	$user->pay_status	    = $request->pay_status;
	$user->cpf_status	    = $cpf_status;
	$user->levy_status	    = $levy_status;
	if(isset($request->levy_val) && $levy_status == 1){
	    $user->levy_val = $request->levy_val;
	}
	else{
	    $user->levy_val = 0;
	}
	$user->user_role            = $request->user_role;
	$user->housing_fee	    = $request->housing_fee;
	$user->salary		    = $request->salary;
	$user->image		    =  $get_photo;
	$user->remark		    = $request->remark;
	$user->created_at            = date('Y-m-d H:i:s');
	$user->updated_at           = date('Y-m-d H:i:s');
	$user->post_user            = 1;
	$user->remember_token      = $request->_token;
	$user->status		    = 1;
	$user->save();
	$getuser_id = DB::getPdo()->lastInsertId();
	DB::table('payroll_history')->insert(
	    ['user_id' => $getuser_id, 'salary' => $request->salary,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'),'post_user' => 1,'status'=>1]
	);
	
	return redirect('/user/list');
    }
    
    public function user_editsave(Request $request){	
	
	
	$user = User::find($request->id);
	if($user->full_name == $request->full_name){
	    $em_nametype = 'required|string';
	}
	else{
	    $em_nametype = 'required|string';
	}
	/*if($user->email == $request->email){
	    $em_emailtype = 'required|email';
	}
	else{
	    $em_emailtype = 'required|email|unique:users';
	}*/
	if($user->user_name == $request->user_name){
	    $em_usernametype = 'required|string';
	}
	else{
	    $em_usernametype = 'required|unique:users|string';
	}
	if($user->nirc == $request->nirc){
	    $em_nirctype = 'required|string';
	}
	else{
	    $em_nirctype = 'required|string|unique:users';
	}
	
	if($request->password == ""){
	    $pwd = $user->password;
	    $cpwd = $user->password;
	}
	else{
	    $pwd = $request->password;
	    $cpwd = $request->cpassword;
	}
	
	$get_request = array(
	    'full_name'=>$request->full_name,
	    'user_name' => $request->user_name,
	    'gender' =>$request->gender,
	   'marital_status'=> $request->marital_status,
	   'dob'=> $request->dob,
	     'country_of_birth' =>$request->country_of_birth,
	   'nationality' =>  $request->nationality,
	    'race' => $request->race,
	    'start_working_date' => $request->start_working_date,
	    'position' =>$request->position,
	    //'email' => $request->email,
	    'password' => $pwd,
	    'cpassword' => $cpwd,
	    'phone' => $request->phone,
	    'nirc' => $request->nirc,
	    'address' =>$request->address,
	     'pass_status' =>$request->pass_status,
	    'working_shift' => $request->working_shift,
	    'agency' =>$request->agency,
	    'pay_status' => $request->pay_status,
	    'user_role' =>$request->user_role,
	    'salary' =>$request->salary,
	);
	
	$validator = Validator::make($get_request,[
	    'full_name' => $em_nametype,
            'gender' => 'required',
            'user_name' => $em_usernametype,
	    'marital_status' => 'required',
	    'dob'=> 'required',
	    'country_of_birth' => 'required',
	    'nationality' => 'required',
	    'race' => 'required',
	    'start_working_date' => 'required',
	     'position' => 'required',
	    //'email' => $em_emailtype,
	     'password' => array('regex:/^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).+$/','min:8','required'),
	    'cpassword' => 'required|same:password',
	    'phone' => 'required|numeric',
	    'nirc' => $em_nirctype,
	    'address' => 'required|string',
	    'pass_status' => 'required',
	    'working_shift' => 'required',
	    'agency' => 'required',
	     'pay_status' => 'required',
	    'user_role' => 'required',
	    'salary' => 'required|numeric',
	]);
	
       
	if ($validator->fails())
	{
	    return redirect('user/edit/'.$request->id)->withErrors($validator)->withInput();
	}
	
	$dob = $request->year."-".$request->month."-".$request->day;
	if($request->cpf_status == "on"){
	    $cpf_status = 1;
	}
	else{
	    $cpf_status = 0;
	}
	if($request->levy_status == "on"){
	    $levy_status = 1;
	}
	else{
	    $levy_status = 0;
	}
	
	function getExtension($str) {
	    $i = strrpos($str,".");
	    if (!$i) { return ""; }
	    $l = strlen($str) - $i;
	    $ext = substr($str,$i+1,$l);
	    return $ext;
	 }

	 $image=$_FILES['photo']['name'];
	 if($image) 
	 {
		 $unlink_existing_image = $user->image;
		 unlink(base_path()."/images/user/".$unlink_existing_image);
		 $filename = stripslashes($image);
		 $extension = getExtension($filename);
		 $extension = strtolower($extension);
		 if($extension == "jpg" || $extension == "png" || $extension== "gif"){
			 $imgname = rand().time();
			 $image_name= $imgname.'.'.$extension;
			 $newpath= base_path()."/images/user/".$image_name;
			 $copied = copy($_FILES['photo']['tmp_name'], $newpath);
			 if (!$copied) 
			 {
				 return Redirect::to('user');
			 }
			 else
			 {
				 $get_photo = $image_name;		
			 }
		 }	
		 else{
			 return Redirect::to('user');
		 }	
	 }
	 else{
		 $get_photo = "";
	 }

	$user->full_name	    = $request->full_name;
	$user->user_name        = $request->user_name;
	$user->gender		    = $request->gender;
	$user->maritalstatus	    = $request->marital_status;
	$user->dob		    = $request->dob;
	$user->country_of_birth	    = $request->country_of_birth;
	$user->nationality	    = $request->nationality;
	$user->race		    = $request->race;
	$user->start_employment	    = date('Y-m-d',strtotime($request->start_working_date));
	$user->leave_employment	    = date('Y-m-d',strtotime($request->end_working_date));
	$user->position		    = $request->position;
	$user->email		    = $request->email;
	$user->password		    = bcrypt($pwd);
	$user->phone		    = $request->phone;
	$user->nirc		    = $request->nirc;
	$user->address		    = $request->address;
	$user->pass_status	    = $request->pass_status;
	$user->time_shift	    = $request->working_shift;
	$user->agency		    = $request->agency;
	$user->pay_status	    = $request->pay_status;
	$user->cpf_status	    = $cpf_status;
	$user->levy_status	    = $levy_status;
	if(isset($request->levy_val) && $levy_status == 1){
	    $user->levy_val = $request->levy_val;
	}
	else{
	    $user->levy_val = 0;
	}
	$user->user_role	    = $request->user_role;
	$user->housing_fee	    = $request->housing_fee;
	$user->salary		    = $request->salary;
	$user->remark		    = $request->remark;
	$user->image		    = $get_photo;
	$user->updated_at           = date('Y-m-d H:i:s');
	$user->remember_token	    = $request->_token;
	$user->post_user		    = 1;
	
	$user->save();
	$getuser_id = $user->id;
	DB::table('payroll_history')->insert(
	    ['user_id' => $getuser_id, 'salary' => $request->salary,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'),'post_user' => 1,'status'=>1]
	);
	return redirect('/user/edit/'.$user->id)->with('status', 'You information is updated!');
    }
    
    public function user_update(Request $request){
	$user = User::find($request->id);
    }
    
    public function user_view(Request $request){
	$user = User::find($request->id);
	return view('user.view',['user' => $user]);
    }
    
     public function user_profile(Request $request){
	$user = User::find($request->id);
	return view('user.profile',['user' => $user]);
    }
    
   public function user_edit(Request $request){
	$user = User::find($request->id);
	//return view('user.edit',['user' => $user]);
	$country = Country::all();
	$nationality = Nationality::all();
	$race = Race::all();
	$agency = Agency::all();
	$userrole = Userrole::all();
	$wshift = Workshift::all();
	$pass = Passstatus::all();
	return view('user.edit',['user' => $user])->with('country',$country)->with('nationality',$nationality)->with('race',$race)->with('agency',$agency)->with('userrole',$userrole)->with('wshift',$wshift)->with('pass',$pass);
    }
    
     public function user_delete(Request $request){
	$user = User::find($request->id);
	$user->delete();
	return redirect('/user/list')->with('status', 'Info Deleted!');
    }
    
   
}



