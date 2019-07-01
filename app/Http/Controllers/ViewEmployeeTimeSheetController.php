<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Timesheet;

class ViewEmployeeTimeSheetController extends Controller
{
  /*
   * Show List of Employees Timesheets in the system
   */
	public function index()
    {
		  $loggedInUser = Auth::user()->UserID;

      //Show All Employees Timesheet if it's Admin
      if(Auth::user()->Role == 1) {
        $timesheet_details = DB::select('CALL viewEmployeeTimesheet(0,0)');
      } 
      else {
        //Show All Employees Timesheet, working under logged in Supervisor's projects
        $timesheet_details = DB::select('CALL viewEmployeeTimesheet(?,?)',array($loggedInUser,2));
      }

     	return view('viewemployeetimesheet', ['timesheet_details'=>$timesheet_details]);
  	}

  /*
   * Update Employees Existing Timesheet in the system
   */
  	public function updateTimesheet(Request $request)
    {
      $TimesheetID = $request->input('inputTimesheetID');
    	$UserID = $request->input('inputEmployeeId');
	    $ProjectID = $request->input('inputProjectId');
	    $Date = $request->input('inputDate');
	    $StartTime = $request->input('inputStartTime');
	    $EndTime = $request->input('inputEndTime');

		  Timesheet::where(['TimesheetID'=>$TimesheetID, 'UserID'=> $UserID, 'ProjectID'=> $ProjectID, 'Date'=> $Date])
            ->update(['StartTime' => $StartTime, 'EndTime' => $EndTime]);

    	return redirect('/employee/viewemployeetimesheet');
  	}
}
