<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Timesheet;

class ViewTimeSheetController extends Controller
{
	/*
	* Show List of Timesheets in the system
	*/
	public function index()
    {
    	$loggedInUser = Auth::user()->UserID;
      	$projects = DB::select('CALL viewProjects(?)', array($loggedInUser));
      	$projects1 = [];
      	if(Auth::user()->Role == 2) {
  			$projects1 = DB::select('select * from project where SupervisorID=?',[$loggedInUser]);
      	}
      	$projects = array_merge($projects ,$projects1);
      	$timesheet_details = DB::select('CALL viewEmployeeTimesheet(?,?)',array($loggedInUser,0));
 
      	return view('viewtimesheet', 
     		['projects'=>$projects, 
     		'timesheet_details'=>$timesheet_details]);
 	}

	/*
	* Insert timesheet in the system
	*/
	public function insert(Request $request)
    {
    	$loggedInUser = Auth::user()->UserID;
	    $ProjectID = $request->input('projSelection');
	    $Date = $request->input('inputDay');
		$StartTime = $request->input('inputStartTime');
	    $EndTime = $request->input('inputEndTime');
	    
	    $filltimesheet = DB::select('CALL fillTimesheet(?,?,?,?,?)', array($loggedInUser, $ProjectID, $Date, $StartTime, $EndTime));
	    return $this->index();
	}

	/*
	* Update own Timesheets in the system
	*/
  	public function updateTimesheet(Request $request)
    {
    	$TimesheetID = $request->input('inputTimesheetID');
    	$UserID = Auth::user()->UserID;
	    $ProjectID = $request->input('inputProjectId');
	    $Date = $request->input('inputDate');
	    $StartTime = $request->input('inputStartTime');
	    $EndTime = $request->input('inputEndTime');

		Timesheet::where(['TimesheetID'=>$TimesheetID,'UserID'=> $UserID, 'ProjectID'=> $ProjectID, 'Date'=> $Date])
            ->update(['StartTime' => $StartTime, 'EndTime' => $EndTime]);
            
    	return redirect('/employee/viewtimesheet');
  	}
}
