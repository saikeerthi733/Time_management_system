<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\project;
use App\Team;
use Input;
use Auth;

class GenerateReportController extends Controller
{
    public function index()
    {
      $loggedInUser = Auth::user()->UserID;

      if(Auth::user()->Role == 1) {
        $projects = project::all();
      } else {
        $projects = DB::select('CALL selectProjBySupervisor(?)', array($loggedInUser));
      }
     	return view('generatesummary',
          ['projects'=>$projects, 
          'getselectedproj'=>0, 
          'getselectedreport'=>0, 
          'reports'=>[]]);
  	}

  	public function generatereport(Request $request)
    {	
    	$loggedInUser = Auth::user()->UserID;

      if(Auth::user()->Role == 1) {
        $projects = project::all();
      } else {
        $projects = DB::select('CALL selectProjBySupervisor(?)', array($loggedInUser));
      }

    	$getselectedproj = Input::get('projSelection');
    	$getreporttype = Input::get('reportSelection');
    	$getstartdate = Input::get('inputStartDate') ? Input::get('inputStartDate') : "2018-04-14";
    	$getenddate = Input::get('inputEndDate') ? Input::get('inputEndDate') : "2018-04-14";
      $getmonth = Input::get('month');
      $getyear = Input::get('year');

      //Get the reports based on ReportType
 			$reports = DB::select('CALL generateReport(?,?,?,?,?,?)',array($getselectedproj, $getreporttype, 
        $getstartdate, $getenddate, $getmonth, $getyear));

      return view('generatesummary',
        array('projects'=>$projects, 
        'getselectedproj'=>$getselectedproj,
        'getselectedreport'=>$getreporttype,
        'reports'=>$reports));
  	}
}
