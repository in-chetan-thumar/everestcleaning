<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',array('before' => 'auth', 'uses' => 'HomeController@index'));

Route::get('/logout', function () {
    return view('login');
});

Route::auth();

Route::get('/home', 'HomeController@home');
Route::get('/coming', 'HomeController@coming');

Route::get('/user',array('before' => 'auth','uses'=>'UserController@user_list'));
Route::get('/user/create',array('before' => 'auth','uses'=>'UserController@user_create'));
Route::post('/user/save',array('before' => 'auth','uses'=>'UserController@user_save'));
Route::get('/user/list',array('before' => 'auth','uses'=>'UserController@user_list'));
Route::get('/user/view/{id}',array('before' => 'auth','uses'=>'UserController@user_view'));
Route::get('/user/{id}',array('before' => 'auth','uses'=>'UserController@user_profile'));
Route::get('/user/edit/{id}',array('before' => 'auth','uses'=>'UserController@user_edit'));
Route::post('/user/edit',array('before' => 'auth','uses'=>'UserController@user_editsave'));
Route::post('/user/delete',array('before' => 'auth','uses'=>'UserController@user_delete'));


/*user role*/

Route::get('/userrole',array('before' => 'auth','uses'=>'UserroleController@userrole_list'));
Route::get('/userrole/create',array('before' => 'auth','uses'=>'UserroleController@userrole_create'));
Route::post('/userrole/save',array('before' => 'auth','uses'=>'UserroleController@userrole_save'));
Route::get('/userrole/list',array('before' => 'auth','uses'=>'UserroleController@userrole_list'));
Route::get('/userrole/view/{id}',array('before' => 'auth','uses'=>'UserroleController@userrole_view'));
Route::get('/userrole/edit/{id}',array('before' => 'auth','uses'=>'UserroleController@userrole_edit'));
Route::post('/userrole/edit',array('before' => 'auth','uses'=>'UserroleController@userrole_editsave'));
Route::post('/userrole/delete',array('before' => 'auth','uses'=>'UserroleController@userrole_delete'));


Route::get('/cpf',array('before' => 'auth','uses'=>'CPFsettingController@cpf_list'));
Route::get('/cpf/create',array('before' => 'auth','uses'=>'CPFsettingController@cpf_create'));
Route::post('/cpf/save',array('before' => 'auth','uses'=>'CPFsettingController@cpf_save'));
Route::get('/cpf/list',array('before' => 'auth','uses'=>'CPFsettingController@cpf_list'));
Route::get('/cpf/edit/{id}',array('before' => 'auth','uses'=>'CPFsettingController@cpf_edit'));
Route::post('/cpf/edit',array('before' => 'auth','uses'=>'CPFsettingController@cpf_editsave'));
Route::post('/cpf/delete',array('before' => 'auth','uses'=>'CPFsettingController@cpf_delete'));

Route::get('/sdl',array('before' => 'auth','uses'=>'SdlsettingController@sdl_list'));
Route::get('/sdl/create',array('before' => 'auth','uses'=>'SdlsettingController@sdl_create'));
Route::post('/sdl/save',array('before' => 'auth','uses'=>'SdlsettingController@sdl_save'));
Route::get('/sdl/list',array('before' => 'auth','uses'=>'SdlsettingController@sdl_list'));
Route::get('/sdl/edit/{id}',array('before' => 'auth','uses'=>'SdlsettingController@sdl_edit'));
Route::post('/sdl/edit',array('before' => 'auth','uses'=>'SdlsettingController@sdl_editsave'));
Route::get('/sdl/delete/{id}',array('before' => 'auth','uses'=>'SdlsettingController@sdl_delete'));

Route::get('/payroll/list',array('before' => 'auth','uses'=>'PayrollsettingController@proll_list'));
Route::get('/payroll/create',array('before' => 'auth','uses'=>'PayrollsettingController@proll_create'));
Route::post('/payroll/save',array('before' => 'auth','uses'=>'PayrollsettingController@proll_save'));
Route::get('/payroll/edit/{id}',array('before' => 'auth','uses'=>'PayrollsettingController@proll_edit'));
Route::post('/payroll/edit',array('before' => 'auth','uses'=>'PayrollsettingController@proll_editsave'));
Route::post('/payroll/search',array('before' => 'auth','uses'=>'PayrollsettingController@proll_search'));
Route::get('/payroll/search',array('before' => 'auth','uses'=>'PayrollsettingController@getproll_search'));
Route::get('/payroll/view/{id}',array('before' => 'auth','uses'=>'PayrollsettingController@proll_view'));
Route::get('/payroll/export/{id}',array('before' => 'auth','uses'=>'PayrollsettingController@generate_pdf'));
Route::get('/payroll/print/{id}',array('before' => 'auth','uses'=>'PayrollsettingController@print_pdf'));
Route::get('/payroll/{id}',array('before' => 'auth','uses'=>'PayrollsettingController@view_mypayroll'));

Route::get('/agency',array('before' => 'auth','uses'=>'AgencyController@agency_list'));
Route::get('/agency/create',array('before' => 'auth','uses'=>'AgencyController@agency_create'));
Route::post('/agency/save',array('before' => 'auth','uses'=>'AgencyController@agency_save'));
Route::get('/agency/list',array('before' => 'auth','uses'=>'AgencyController@agency_list'));
Route::get('/agency/edit/{id}',array('before' => 'auth','uses'=>'AgencyController@agency_edit'));
Route::post('/agency/edit',array('before' => 'auth','uses'=>'AgencyController@agency_editsave'));
Route::post('/agency/delete',array('before' => 'auth','uses'=>'AgencyController@agency_delete'));

Route::get('/country',array('before' => 'auth','uses'=>'CountryController@country_list'));
Route::get('/country/create',array('before' => 'auth','uses'=>'CountryController@country_create'));
Route::post('/country/save',array('before' => 'auth','uses'=>'CountryController@country_save'));
Route::get('/country/list',array('before' => 'auth','uses'=>'CountryController@country_list'));
Route::get('/country/edit/{id}',array('before' => 'auth','uses'=>'CountryController@country_edit'));
Route::post('/country/edit',array('before' => 'auth','uses'=>'CountryController@country_editsave'));
Route::post('/country/delete',array('before' => 'auth','uses'=>'CountryController@country_delete'));

Route::get('/nationality',array('before' => 'auth','uses'=>'NationalityController@nationality_list'));
Route::get('/nationality/create',array('before' => 'auth','uses'=>'NationalityController@nationality_create'));
Route::post('/nationality/save',array('before' => 'auth','uses'=>'NationalityController@nationality_save'));
Route::get('/nationality/list',array('before' => 'auth','uses'=>'NationalityController@nationality_list'));
Route::get('/nationality/edit/{id}',array('before' => 'auth','uses'=>'NationalityController@nationality_edit'));
Route::post('/nationality/edit',array('before' => 'auth','uses'=>'NationalityController@nationality_editsave'));
Route::post('/nationality/delete',array('before' => 'auth','uses'=>'NationalityController@nationality_delete'));

Route::get('/race',array('before' => 'auth','uses'=>'RaceController@race_list'));
Route::get('/race/create',array('before' => 'auth','uses'=>'RaceController@race_create'));
Route::post('/race/save',array('before' => 'auth','uses'=>'RaceController@race_save'));
Route::get('/race/list',array('before' => 'auth','uses'=>'RaceController@race_list'));
Route::get('/race/edit/{id}',array('before' => 'auth','uses'=>'RaceController@race_edit'));
Route::post('/race/edit',array('before' => 'auth','uses'=>'RaceController@race_editsave'));
Route::post('/race/delete',array('before' => 'auth','uses'=>'RaceController@race_delete'));


Route::get('/workshift',array('before' => 'auth','uses'=>'WorkshiftController@wshift_list'));
Route::get('/workshift/create',array('before' => 'auth','uses'=>'WorkshiftController@wshift_create'));
Route::post('/workshift/save',array('before' => 'auth','uses'=>'WorkshiftController@wshift_save'));
Route::get('/workshift/list',array('before' => 'auth','uses'=>'WorkshiftController@wshift_list'));
Route::get('/workshift/edit/{id}',array('before' => 'auth','uses'=>'WorkshiftController@wshift_edit'));
Route::post('/workshift/edit',array('before' => 'auth','uses'=>'WorkshiftController@wshift_editsave'));
Route::post('/workshift/delete',array('before' => 'auth','uses'=>'WorkshiftController@wshift_delete'));


Route::get('/passstatus',array('before' => 'auth','uses'=>'PassstatusController@pass_list'));
Route::get('/passstatus/create',array('before' => 'auth','uses'=>'PassstatusController@pass_create'));
Route::post('/passstatus/save',array('before' => 'auth','uses'=>'PassstatusController@pass_save'));
Route::get('/passstatus/list',array('before' => 'auth','uses'=>'PassstatusController@pass_list'));
Route::get('/passstatus/edit/{id}',array('before' => 'auth','uses'=>'PassstatusController@pass_edit'));
Route::post('/passstatus/edit',array('before' => 'auth','uses'=>'PassstatusController@pass_editsave'));
Route::post('/passstatus/delete',array('before' => 'auth','uses'=>'PassstatusController@pass_delete'));

Route::get('/client',array('before' => 'auth','uses'=>'ClientController@client_list'));
Route::get('/client/create',array('before' => 'auth','uses'=>'ClientController@client_create'));
Route::post('/client/save',array('before' => 'auth','uses'=>'ClientController@client_save'));
Route::get('/client/list',array('before' => 'auth','uses'=>'ClientController@client_list'));
Route::get('/client/edit/{id}',array('before' => 'auth','uses'=>'ClientController@client_edit'));
Route::post('/client/edit',array('before' => 'auth','uses'=>'ClientController@client_editsave'));
Route::post('/client/delete',array('before' => 'auth','uses'=>'ClientController@client_delete'));

Route::get('/project',array('before' => 'auth','uses'=>'ProjectController@project_list'));
Route::get('/project/create',array('before' => 'auth','uses'=>'ProjectController@project_create'));
Route::post('/project/save',array('before' => 'auth','uses'=>'ProjectController@project_save'));
Route::get('/project/list',array('before' => 'auth','uses'=>'ProjectController@project_list'));
Route::get('/project/edit/{id}',array('before' => 'auth','uses'=>'ProjectController@project_edit'));
Route::post('/project/edit',array('before' => 'auth','uses'=>'ProjectController@project_editsave'));
Route::post('/project/delete',array('before' => 'auth','uses'=>'ProjectController@project_delete'));

Route::get('/invoice',array('before' => 'auth','uses'=>'InvoiceController@invoice_list'));
Route::get('/invoice/create',array('before' => 'auth','uses'=>'InvoiceController@invoice_create'));
Route::post('/invoice/save',array('before' => 'auth','uses'=>'InvoiceController@invoice_save'));
Route::get('/invoice/list',array('before' => 'auth','uses'=>'InvoiceController@invoice_list'));
Route::get('/invoice/edit/{id}',array('before' => 'auth','uses'=>'InvoiceController@invoice_edit'));
Route::post('/invoice/edit',array('before' => 'auth','uses'=>'InvoiceController@invoice_editsave'));
Route::get('/invoice/delete/{id}',array('before' => 'auth','uses'=>'InvoiceController@invoice_delete'));

Route::get('/quotation',array('before' => 'auth','uses'=>'QuotationController@quotation_list'));
Route::get('/quotation/create',array('before' => 'auth','uses'=>'QuotationController@quotation_create'));
Route::post('/quotation/save',array('before' => 'auth','uses'=>'QuotationController@quotation_save'));
Route::get('/quotation/list',array('before' => 'auth','uses'=>'QuotationController@quotation_list'));
Route::get('/quotation/edit/{id}',array('before' => 'auth','uses'=>'QuotationController@quotation_edit'));
Route::post('/quotation/edit',array('before' => 'auth','uses'=>'QuotationController@quotation_editsave'));
Route::get('/quotation/delete/{id}',array('before' => 'auth','uses'=>'QuotationController@quotation_delete'));

Route::get('/letterhead',array('before' => 'auth','uses'=>'LetterheadController@letterhead_list'));
Route::get('/letterhead/create',array('before' => 'auth','uses'=>'LetterheadController@letterhead_create'));
Route::post('/letterhead/save',array('before' => 'auth','uses'=>'LetterheadController@letterhead_save'));
Route::get('/letterhead/list',array('before' => 'auth','uses'=>'LetterheadController@letterhead_list'));
Route::get('/letterhead/edit/{id}',array('before' => 'auth','uses'=>'LetterheadController@letterhead_edit'));
Route::post('/letterhead/edit',array('before' => 'auth','uses'=>'LetterheadController@letterhead_editsave'));
Route::get('/letterhead/delete/{id}',array('before' => 'auth','uses'=>'LetterheadController@letterhead_delete'));

Route::match(['get','post'],'/schedule',array('before' => 'auth','uses'=>'ScheduleController@schedule_show'));
Route::get('/schedule/scheduleemployeelist',array('before' => 'auth','uses'=>'ScheduleController@schedule_employee_list'));
Route::match(['get','post'],'/schedule/delete/{id}',array('before' => 'auth','uses'=>'ScheduleController@schedule_delete'));

Route::match(['get','post'],'/reports',array('before' => 'auth','uses'=>'ReportsController@reports_show'));
Route::get('/reports/export/{type}/{project_id}/{month}/{year}',array('before' => 'auth','uses'=>'ReportsController@reports_export'));

Route::get('/leave',array('before' => 'auth','uses'=>'LeaveController@leave_list'));
Route::post('/leave/create',array('before' => 'auth','uses'=>'LeaveController@leave_create'));
Route::get('/leave/validate',array('before' => 'auth','uses'=>'LeaveController@leave_validate'));