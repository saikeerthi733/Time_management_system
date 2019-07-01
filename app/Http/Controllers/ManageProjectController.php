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

class ManageProjectController extends Controller
{
    public function index()
    {
      $loggedInUser = Auth::user()->UserID;

      if(Auth::user()->Role == 1) {
        $projects = project::all();
      } else {
        $projects = DB::select('CALL selectProjBySupervisor(?)', array($loggedInUser));
      }
     	return view('manageproject',
        ['projects'=>$projects,
        'getselectedproj'=>0,
        'show_projects'=>[], 
        'employees'=>[], 
        'addemployees'=>[]]);
  	}

  	public function showprojectdetails(Request $request)
    {	
      $loggedInUser = Auth::user()->UserID;

    	if(Auth::user()->Role == 1) {
        $projects = project::all();
      } else {
        $projects = DB::select('CALL selectProjBySupervisor(?)', array($loggedInUser));
      }

    	$getselectedproj = Input::get('projSelection');
    	$show_projects = DB::select('CALL showProjectDetails(?)', array($getselectedproj));
    	$employees = DB::select('CALL showEmployeesByProject(?)',array($getselectedproj));
    	$addemployees = DB::select('CALL addEmployeesByProject(?)',array($getselectedproj));

		  return view('manageproject',
        ['projects'=>$projects,
        'getselectedproj'=>$getselectedproj,
        'show_projects'=>$show_projects,
        'employees'=>$employees, 
        'addemployees'=>$addemployees]);
  	}

  	public function addEmployee(Request $request)
    {	
    	$getselectedemp = Input::get('addEmployeesList');
      $getselectedproj = Input::get('getselectedproj');

      if($getselectedemp && count($getselectedemp) > 0)
      {
        foreach ($getselectedemp as $id)
        {
          DB::select('CALL insertEmployeeIntoTeam(?,?)',array($id, $getselectedproj));
        }
      }
    	return redirect("/manage/project/showdetails?projSelection=$getselectedproj");
  	}

  /*
   * Remove Existing Employee from the project
   */
  public function removeEmployee(Request $request) 
  {
    $employeeId = $request->input('InputRemovePrjEmp');
    $getselectedproj = Input::get('getselectedproj');
    //Remove from Team Table
    Team::where('UserID', $employeeId)
      ->delete();

    return redirect("/manage/project/showdetails?projSelection=$getselectedproj");
  }
}
