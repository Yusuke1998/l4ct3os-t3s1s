<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::post('auth/login', 'AuthController@login');

Route::group(['middleware' => 'jwt.auth'], function () {

	// Users and auth
	Route::get('auth/user', 'AuthController@user');
	Route::post('auth/logout', 'AuthController@logout');
	Route::post('auth/register', 'AuthController@register');
	Route::get('/users', 'AuthController@index');
	Route::post('/users', 'AuthController@datatable');
	Route::put('/user/update/{user}', 'AuthController@update');
	Route::delete('/user/delete/{user}', 'AuthController@delete');

	//Employees
	Route::post('/employee/register', 'EmployeeController@register');
	Route::post('/employees', 'EmployeeController@datatable');
	Route::get('/employees/{position?}', 'EmployeeController@index');
	Route::get('/employee/ci/{ci}', 'EmployeeController@ci');
	Route::put('/employee/update/{employee}', 'EmployeeController@update');
	Route::delete('/employee/delete/{employee}', 'EmployeeController@delete');

	//Payments
	Route::post('payment/employee/{employee_id}', 'PaymentController@employee');
	Route::post('/payments', 'PaymentController@datatable');
	Route::post('/payment/register', 'PaymentController@register');
	Route::put('/payment/status/{payment}', 'PaymentController@status');
	Route::put('/payment/update/{payment}', 'PaymentController@update');
	Route::delete('/payment/delete/{payment}', 'PaymentController@delete');

	//Account
	Route::get('/accounts/{employee_id}','AccountController@index');
	Route::post('/account/register','AccountController@register');

	//Cows
	Route::post('/cow/register', 'CowController@register');
	Route::post('/cows', 'CowController@datatable');
	Route::get('/cows/total', 'CowController@countTotal');
	Route::get('/cows/statistics', 'CowController@statisticsCows');
	Route::get('/cows/{milking?}', 'CowController@index');
	Route::put('/cow/update/{cow}', 'CowController@update');
	Route::delete('/cow/delete/{cow}', 'CowController@delete');

	//medicines
	Route::get('/medicines/{good?}', 'MedicineController@index');
	Route::post('/medicines', 'MedicineController@datatable');
	Route::post('/medicine/register', 'MedicineController@register');
	Route::put('/medicine/update/{medicine}', 'MedicineController@update');
	Route::delete('/medicine/delete/{medicine}', 'MedicineController@delete');

	//Vaccines
	Route::post('/vaccine/register', 'VaccineController@register');
	Route::get('/vaccines/total/today', 'VaccineController@countTotalToday');
	Route::get('/vaccines', 'VaccineController@index');
	Route::post('/vaccines', 'VaccineController@datatable');
	Route::put('/vaccine/update/{vaccine}', 'VaccineController@update');
	Route::delete('/vaccine/delete/{vaccine}', 'VaccineController@delete');

	//Extractions
	Route::post('/extraction/register', 'ExtractionController@register');
	Route::get('/extractions', 'ExtractionController@index');
	Route::post('/extractions', 'ExtractionController@datatable');
	Route::post('/extractions/stadistics', 'ExtractionController@stadisticsExtractions');
	Route::put('/extraction/update/{extraction}', 'ExtractionController@update');
	Route::delete('/extraction/delete/{extraction}', 'ExtractionController@delete');


	// Reportes pdf 
	Route::get('/payments/pdf/{item?}','HomeController@paymentReports');


});

Route::group(['middleware' => 'jwt.refresh'], function () {
	Route::get('auth/refresh', 'AuthController@refresh');
});
