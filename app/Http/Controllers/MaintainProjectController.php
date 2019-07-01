<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Timesheet;
use App\Team;
use App\Project;

class MaintainProjectController extends Controller
{
	/*
	 * Show List of Project in the system
	 */
    public function index()
    {

     	$supervisorlist = DB::select('CALL mpSelectSupervisor()');
     	$employeelist = DB::select('CALL mpSelectEmployee()');
    	$projects = DB::select('CALL mpSelectProject()');
    	$employeeProjectList = DB::select('CALL mpSelectEmpProj()');

     	$supervisorlistUpdate = $supervisorlist;	//Need seperate variable for Update Modal loops
    	$employeelistUpdate = $employeelist;	//Conflicts with Add Modal loops

     	return view('maintainproject',
     		['projects'=>$projects, 
     		'supervisorlist'=>$supervisorlist, 
     		'employeelist'=>$employeelist, 
     		'employeeProjectList'=> $employeeProjectList, 
     		'supervisorlistUpdate'=>$supervisorlistUpdate, 
     		'employeelistUpdate'=>$employeelistUpdate]);
  	}

	/*
	 * Insert New Project in the system
	 */
   	public function insert(Request $request)
    {
	    $ProjectTitle = $request->input('inputTitle');
	    $SupervisorID = $request->input('SupervisorSelection');
		$Budget = $request->input('inputBudget');
	    $CustomerName = $request->input('inputCustomerName');
	    
	    $ProjectID = DB::table('project')->insertGetId(
		    ['ProjectTitle' => $ProjectTitle, 'Budget' => $Budget, 'CustomerName' => $CustomerName, 'SupervisorID' => $SupervisorID]
		);

	    if(!empty($_POST['EmployeeSelection']))
		{
			foreach ($_POST['EmployeeSelection'] as $Selected)
			{
					DB::select('CALL insertEmployeeIntoTeam(?,?)',array($Selected, $ProjectID));
	    	}
	    }
	    return $this->index();
	}

	/*
	 * Update Existing Project in the system
	 */
	public function updateProject(Request $request) 
	{
		$ProjectID = $request->input('inputProjectID');
	    $ProjectTitle = $request->input('inputTitle');
	    $SupervisorID = $request->input('SupervisorSelection');
		$Budget = $request->input('inputBudget');
	    $CustomerName = $request->input('inputCustomerName');

		Project::where('ProjectID', $ProjectID)
            ->update(['ProjectTitle' => $ProjectTitle, 'SupervisorID' => $SupervisorID, 'Budget' => $Budget, 'CustomerName' => $CustomerName]);
		
		Team::where('ProjectID', $ProjectID)
           ->delete();

        if(!empty($_POST['EmployeeSelection']))
		{
			foreach ($_POST['EmployeeSelection'] as $Selected)
			{
					DB::select('CALL insertEmployeeIntoTeam(?,?)',array($Selected, $ProjectID));
	    	}
	    }
	    return redirect('/maintain/project');
	}

	/*
	 * Remove Existing Project from the system
	 */
	public function removeProject(Request $request) 
	{
		$ProjectID = $request->input('InputRemovePrj');
		//Remove from Team Table (FOREIGN KEY)
		Team::where('ProjectID', $ProjectID)
           ->delete();
        //Remove from Timesheet Table (FOREIGN KEY)
		Timesheet::where('ProjectID', $ProjectID)
            ->delete();
        //Remove from Project Table
        Project::where('ProjectID',$ProjectID)
        	->delete();

		return redirect('/maintain/project');
	}
}
