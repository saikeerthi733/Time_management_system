<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    // Define Application Routes

	Route::get('/home', function () {
	    return view('home');
	});
	Route::get('maintain/employee','MaintainEmployeeController@index');
	Route::post('maintain/employee','MaintainEmployeeController@insert');
	Route::post('maintain/employee/update','MaintainEmployeeController@updateEmployee');
	Route::post('maintain/employee/delete','MaintainEmployeeController@removeEmployee');

	Route::get('maintain/project','MaintainProjectController@index');
	Route::post('maintain/project','MaintainProjectController@insert');
	Route::post('maintain/project/update','MaintainProjectController@updateProject');
	Route::post('maintain/project/delete','MaintainProjectController@removeProject');

	Route::get('manage/project','ManageProjectController@index');
	Route::get('manage/project/showdetails','ManageProjectController@showprojectdetails');
	Route::post('manage/project/addemployee','ManageProjectController@addEmployee');
	Route::post('manage/project/deleteemployee','ManageProjectController@removeEmployee');

	Route::get('manage/generatesummary','GenerateReportController@index');
	Route::get('generatereport','GenerateReportController@generatereport');

	Route::get('employee/viewtimesheet', 'ViewTimeSheetController@index');
	Route::post('employee/viewtimesheet', 'ViewTimeSheetController@insert');
	Route::post('employee/viewtimesheet/update', 'ViewTimeSheetController@updateTimesheet');

	Route::get('employee/viewemployeetimesheet', 'ViewEmployeeTimeSheetController@index');
	Route::post('employee/viewemployeetimesheet/update', 'ViewEmployeeTimeSheetController@updateTimesheet');
});