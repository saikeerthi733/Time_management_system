<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\employee;
use App\Timesheet;
use App\Team;
use App\Project;
use Response;
use Illuminate\Support\Facades\Hash;

class MaintainEmployeeController extends Controller
{
	/*
	 * Show List of Employees in the system
	 */
    public function index()
    {
    	$employees = employee::all();
    	return view('maintainemployee', ['employees'=>$employees]);
  	}

	/*
	 * Insert New Employee in the system
	 */
   	public function insert(Request $request)
    {
	    $EmailID = $request->input('inputEmail');
	    $Password = Hash::make(explode('@',$EmailID)[0]);	//Default Temporary Password same as Email ID
	    $FullName = $request->input('inputFullName');
	    $Address = $request->input('inputAddress');
	    $JobTitle = $request->input('inputJobTitle');
	    $Salary = $request->input('inputSalary');
	    $IsSupervisor = $request->input('inputSupervisor') ? 2 : 3;	//Supervisor Role: 2

	    $UserID = DB::table('employee')->insertGetId(
		    ['Password' => $Password, 'FullName' => $FullName, 'Address' => $Address, 'EmailID' => $EmailID, 'JobTitle' => $JobTitle, 'Salary' => $Salary, 'Role' => $IsSupervisor]
		);
	    return $this->index();
	}

	/*
	 * Update Existing Employee in the system
	 */
	public function updateEmployee(Request $request) 
	{
		$EmailID = $request->input('inputEmail');
	    $Password = Hash::make(explode('@',$EmailID)[0]);	//Default Temporary Password same as Email ID
		$UserID = $request->input('inputUserID');
	    $FullName = $request->input('inputFullName');
	    $Address = $request->input('inputAddress');
	    $JobTitle = $request->input('inputJobTitle');
	    $Salary = $request->input('inputSalary');
	    $IsSupervisor = $request->input('inputSupervisor') ? 2 : 3;	//Supervisor Role: 2

		Employee::where('UserID', $UserID)
            ->update(['Password' => $Password, 'FullName' => $FullName, 'Address' => $Address, 'EmailID' => $EmailID, 'JobTitle' => $JobTitle, 'Salary' => $Salary, 'Role' => $IsSupervisor]);

	    return redirect('/maintain/employee');
	}

	/*
	 * Remove Existing Employee from the system
	 */
	public function removeEmployee(Request $request) 
	{
		$employeeId = $request->input('InputRemoveEmp');
		//Remove from Team Table (FOREIGN KEY)
		Team::where('UserID', $employeeId)
           ->delete();
        //Remove from Timesheet Table (FOREIGN KEY)
		Timesheet::where('UserID', $employeeId)
            ->delete();
        //Remove from Project Table
        Project::where('SuperVisorID',$employeeId)
        	->update(array('SuperVisorID'=>'0'));
        //Remove from Employee Table
        Employee::where('UserID', $employeeId)
        	->delete();

		return redirect('/maintain/employee');
	}
}
