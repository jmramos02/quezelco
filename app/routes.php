<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


/*-----Sentry Authentication-----*/
/*Consumer*/
Route::filter('consumer', function()
{	
	$user = Sentry::getUser();
	if($user == null){
		return "User not logged in";
	}else if(!$user->hasAccess('consumer')){
    	return "Access Forbidden";
    }
});

/*Cashier*/
Route::filter('cashier',function(){
	$user = Sentry::getUser();
	if($user == null){
		return "User not logged in";
	}else if(!$user->hasAccess('cashier')){
    	return "Access Forbidden";
    }
});

/*Area Manager*/
Route::filter('manager',function(){
	$user = Sentry::getUser();
	if($user == null){
		return "User not logged in";
	}else if(!$user->hasAccess('manager')){
    	return "Access Forbidden";
    }
});

/*IT Personnel*/
Route::filter('personnel',function(){
	$user = Sentry::getUser();
	if($user == null){
		return "User not logged in";
	}else if(!$user->hasAccess('personnel')){
    	return "Access Forbidden";
    }
});

/*Consumer Area Development*/
Route::filter('cad',function(){
	$user = Sentry::getUser();
	if($user == null){
		return "User not logged in";
	}else if(!$user->hasAccess('cad')){
    	return "Access Forbidden";
    }
});

/*System Admin*/
Route::filter('admin',function(){
	$user = Sentry::getUser();
	if($user == null){
		return "User not logged in";
	}else if(!$user->hasAccess('admin')){
    	return "Access Forbidden";
    }
});

/*System Admin*/
Route::filter('collector',function(){
	$user = Sentry::getUser();
	if($user == null){
		return "User not logged in";
	}else if(!$user->hasAccess('collector')){
    	return "Access Forbidden";
    }
});

/*----Attaching filters to routes----*/
Route::when('cashier/*', 'cashier');
Route::when('manager/*', 'manager');
Route::when('it-personnel/*', 'personnel');
Route::when('consumer-area-development/*', 'cad');
Route::when('admin/*', 'admin');

/*-----Routing------*/
Route::get('/','AuthController@showLoginForm');
Route::get('/index','AuthController@showLoginForm');

/* Controller Routes */
Route::post('/index','AuthController@validateLogin');
//Admin Routes
Route::get('/admin/home','AdminController@showIndex');
Route::get('/admin/logout','AuthController@logout');
Route::get('/admin/report','AdminController@showReports');
Route::get('/admin/user-maintenance','UserMaintenanceController@showUserMaintenance');
Route::get('/admin/add-customer','UserMaintenanceController@showAddCustomer');
Route::get('/admin/monitoring','AdminController@showMonitoring');
Route::get('/admin/cashier','AdminController@showCashier');
Route::get('/admin/disconnected-bills','AdminController@showDisconnectedBills');
Route::get('/admin/wheeling-rates','AdminController@showWheelingRates');
Route::get('/admin/add-user','UserMaintenanceController@showAddUser');
Route::get('/admin/home','AdminController@searchLogs');
Route::get('/admin/my-account','UserMaintenanceController@showMyAccount');
Route::post('/admin/my-account','UserMaintenanceController@updatePassword');

//crud ng users
Route::put('/admin/update-user/{id}','UserMaintenanceController@modifyUser');
Route::get('/admin/activation-user/{id}','UserMaintenanceController@activation');
Route::post('/admin/add-user','UserMaintenanceController@saveUser');
Route::get('/admin/search-user','UserMaintenanceController@searchUser');
Route::get('/admin/edit-user/{search_key}','UserMaintenanceController@showEditUser');
Route::post('/admin/wheeling-rates','AdminController@saveWheelingRates');

Route::get('/test','TestController@test');
Route::get('/admin/location/search','LocationController@search');
Route::get('/admin/routes/search','RoutesController@search');
Route::get('/admin/account/search','CustomerController@search');
Route::get('/admin/add-location/{userId}','UserMaintenanceController@showAddLocation');
Route::post('/admin/add-location/{userId}', 'UserMaintenanceController@addLocationToUser');
Route::get('/admin/add-account/{userId}','CustomerController@showCreateForm');
Route::get('/admin/change-status/{id}','CustomerController@changeStatus');
Route::get('/admin/enter-reading/{id}','BillingController@showEnterReadingForm');
Route::post('/admin/billing/{id}','BillingController@enterReading');
Route::get('/admin/billing/search','BillingController@search');
Route::get('/admin/adjust-billing/{id}','BillingController@adjustReading');
Route::get('/admin/update-billing/{id}','BillingController@updateReading');
Route::get('/admin/print-billing-statement/{id}','BillingController@showPdf');
Route::get('/admin/reports/user-list','ReportController@generateUserList');
Route::get('/admin/reports/location-list','ReportController@generateLocationList');
Route::get('/admin/reports/route-list', 'ReportController@generateRouteList');
Route::get('/admin/reports/consumer-list','ReportController@generateAccountList');
Route::post('/admin/accounts/textblast','CustomerController@textblast');
Route::get('admin/reports/sms-list','ReportController@generateSmsList');
Route::get('admin/reports/others','AdminController@showOtherReports');

/*Resource Controller*/
Route::resource('admin/location','LocationController');
Route::resource('admin/routes','RoutesController');
Route::resource('admin/account','CustomerController');
Route::resource('admin/billing','BillingController');

/*CASHIERING*/
Route::get('cashier/home','CashierController@showHome');
Route::get('cashier/logout', 'AuthController@logout');
Route::get('cashier/payment/search-oebr','CashierController@showOEBR');
Route::post('cashier/accept-payment/{id}','CashierController@acceptPayment');
Route::get('cashier/my-account', 'CadController@showMyAccount');
Route::post('cashier/my-account', 'CadController@updatePassword');


/*COLLECTOR*/
Route::get('collector/home','CollectorController@showHome');
Route::get('collector/my-account', 'CollectorController@showMyAccount');
Route::post('collector/my-account', 'CollectorController@updatePassword');

Route::get('collector/payment/search-oebr','CollectorController@showOEBR');
Route::post('collector/accept-payment/{id}','CollectorController@acceptPayment');

Route::get('collector/logout', 'AuthController@logout');

/*Cashiering*/
Route::get('consumer/home','ConsumerController@showHome');
Route::get('consumer/enroll/{id}','ConsumerController@showEnroll');
Route::post('consumer/enroll/{id}','ConsumerController@enroll');
Route::get('consumer/my-account', 'ConsumerController@showMyAccount');
Route::post('consumer/my-account', 'ConsumerController@updatePassword');
Route::get('consumer/logout','AuthController@logout');

/*CAD*/
Route::get('cad/home', 'CadController@showHome');
Route::get('cad/monitoring', 'CadController@showMonitoring');
Route::get('cad/reports/location-list','ReportController@generateLocationList');
Route::get('cad/reports/route-list','ReportController@generateRouteList');
Route::get('cad/reports/consumer-list','ReportController@generateAccountList');
Route::get('cad/reports/sms-list','CadController@smsList');
Route::get('cad/report', 'CadController@showReports');
Route::get('cad/my-account', 'CadController@showMyAccount');
Route::post('cad/my-account', 'CadController@updatePassword');
Route::get('cad/billing/search','CadController@search');
Route::get('cad/logout','AuthController@logout');
Route::get('cad/print-billing-statement/{id}','BillingController@showPdf');

/*Ajax routes*/
Route::get('admin/ajax/payments-annual/{year}','AjaxController@paymentsAnnual');
Route::get('admin/ajax/customer-status','AjaxController@customerStatus');
Route::get('admin/ajax/bill-status','AjaxController@billingStatus');

Route::get('manager/ajax/payments-annual/{year}','AjaxController@paymentsAnnualManager');
Route::get('manager/ajax/customer-status','AjaxController@customerStatusManager');
Route::get('manager/ajax/bill-status','AjaxController@billingStatusManager');

Route::get('cad/ajax/customer-status','AjaxController@customerStatus');
Route::get('cad/ajax/bill-status','AjaxController@billingStatus');


/*Manager Routes*/
Route::get('manager/home','ManagerController@showIndex');
Route::get('manager/logout','AuthController@logout');
Route::get('manager/change-status/{id}','ManagerController@changeStatus');
Route::get('manager/search/','ManagerController@search');
Route::get('manager/reports/customer-list','ManagerController@generateAccountList');
Route::get('manager/print-billing-statement/{id}','ManagerController@printBillingStatement');
Route::get('manager/reports/disconnected-list','ManagerController@generateDisconnectedList');
Route::get('manager/reports/sms-list','ManagerController@generateSmsList');
Route::get('manager/my-account', 'ManagerController@showMyAccount');
Route::post('manager/my-account', 'ManagerController@updatePassword');

Route::get('manager/monitoring','ManagerController@showMonitoring');


/*Test Routes*/

Route::get('test/sms','ReportController@generateSmsList');