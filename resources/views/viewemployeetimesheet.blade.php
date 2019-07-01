@extends('layouts.app')

@section('content')
<div class="container">
	<h4>View Employee Timesheet</h4>
	<br>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="timesheetTable" class="table table-bordred table-striped table-hover">
                    <thead>
                        <th>Employee ID</th>
                        <th>Employee Name</th>
                        <th>Project ID</th>
                        <th>Project Name</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Hours Worked</th>
                        <th class="sorting-disabled">Edit</th>
                    </thead>
                    <tbody> 
                        @foreach ($timesheet_details as $timesheet_detail)
                        <tr>
                            <td>{{ $timesheet_detail->UserID }}</td>
                            <td>{{ $timesheet_detail->FullName }}</td>
                            <td>{{ $timesheet_detail->ProjectID }}</td>
                            <td>{{ $timesheet_detail->ProjectTitle }}</td>
                            <td>{{ $timesheet_detail->DateFormatted }}</td>
                            <td>{{ $timesheet_detail->StartTimeFormatted }}</td>
                            <td>{{ $timesheet_detail->EndTimeFormatted }}</td> 
                            <td>{{ $timesheet_detail->HoursWorked }}</td>                         
                            <td>
                              <p data-placement="top" data-toggle="tooltip" title="Edit">
                              <button class="edit-modal btn btn-primary btn-xs {{ $timesheet_detail->CanEdit ? '' : 'disabled' }}" data-title="Edit" data-toggle="modal" data-id="{{$timesheet_detail->UserID}}" data-fullname="{{$timesheet_detail->FullName}}" data-projectid="{{$timesheet_detail->ProjectID}}" data-projecttitle="{{$timesheet_detail->ProjectTitle}}" data-date="{{$timesheet_detail->Date}}" data-starttime="{{$timesheet_detail->StartTime}}" data-endtime="{{$timesheet_detail->EndTime}}" data-hours="{{$timesheet_detail->HoursWorked}}" data-timesheetid="{{$timesheet_detail->TimesheetID}}" >
                              <span class="glyphicon glyphicon-edit"></span></button></p>
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--  Update Employee Modal  -->
    <div class="modal fade" id="updateEmpTimesheetModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
          <!-- Modal content-->
            <form role="form" action = "/employee/viewemployeetimesheet/update" method = "post">
                <input type = "hidden" name = "_token" value = "{{ csrf_token() }}">
                <input type = "hidden" id="inputEmployeeId" name="inputEmployeeId" />
                <input type = "hidden" id="inputProjectId" name="inputProjectId" />
                <input type = "hidden" id="inputTimesheetID" name="inputTimesheetID" />
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Update Employee Timesheet</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="inputEmployee" class="col-sm-3 text-right">Employee</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="inputEmployee" name='inputEmployee' placeholder="Enter Employee" readonly />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputProject" class="col-sm-3 text-right">Project</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="inputProject" name='inputProject' placeholder="Enter Project" readonly />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputDate" class="col-sm-3 text-right">Date</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="inputDate" name='inputDate' placeholder="Enter Date" readonly />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputStartTime" class="col-sm-3 text-right">Start Time</label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" id="inputStartTime" name='inputStartTime' placeholder="Enter Start Time" step="900" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEndTime" class="col-sm-3 text-right">End Time</label>
                            <div class="col-sm-9">
                                <input type="time" class="form-control" id="inputEndTime" name='inputEndTime' placeholder="Enter End Time" step="900" required />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
