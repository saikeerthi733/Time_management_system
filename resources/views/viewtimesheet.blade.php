@extends('layouts.app')

@section('content')
<div class="container">
	<h4>Fill Timesheet</h4>
	<br>
	<form role="form" action = "/employee/viewtimesheet" method = "post">
        <input type = "hidden" name = "_token" value = "{{ csrf_token() }}">
		<div class="form-group row">
			<label for="inputDay" class="col-md-2 col-xs-4 text-right">Select Day</label>
			<div class="col-md-4 col-xs-8">
				<div class='input-group'>
					<input type="date" class="form-control" id="inputDay" name="inputDay" placeholder="Enter Day" min="{{ date ( 'Y-m-d' , strtotime ( '-'.(date('w', strtotime(date ( 'Y-m-j')))+7).' day' , strtotime (date ( 'Y-m-j')) )) }}" required />
                    <label class="input-group-addon" for="inputDay">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </label>
                </div>
			</div>
		</div>
		<div class="form-group row">
			<label for="projSelection" class="col-md-2 col-xs-4 text-right">Select Project</label>
			<div class="col-md-4 col-xs-8">
				<select class="form-control" id="projSelection" name="projSelection" required>
					<option value="">Please Select</option>
        			@foreach ($projects as $project)
        			<option value="{{ $project->ProjectID }}">{{ $project->ProjectID }} - {{ $project->ProjectTitle }}</option>
        			@endforeach
				</select>
			</div>
		</div>
		<div class="form-group row">
			<label for="inputStartTime" class="col-md-2 col-xs-4 text-right">Start Time</label>
			<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6">
				<input type="time" class="form-control" step="900" id="inputStartTime" name="inputStartTime" placeholder="Enter Start Time" required />
			</div>
		</div>
		<div class="form-group row">
			<label for="inputEndTime" class="col-md-2 col-xs-4 text-right">End Time</label>
			<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6">
				<input type="time" class="form-control" step="900" id="inputEndTime" name="inputEndTime" placeholder="Enter End Time" required />
			</div>
		</div>
		<br>
		<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<!-- <button type="button" class="btn btn-default col-lg-offset-5 col-lg-3 col-md-offset-5 col-md-3 col-sm-offset-5 col-sm-3 col-xs-offset-5 col-xs-3 pull-left" data-dismiss="modal">Cancel</button> -->
			<button type="submit" class="btn btn-primary col-lg-3 col-md-3 col-sm-offset-1 col-sm-3 col-xs-3 pull-right">Submit</button>
		</div>
	</form>

	<div class="row">
        <div class="col-md-10">
        	<hr>
            <h4>Submitted Timesheets</h4>
        </div>    
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table id="myTimesheetTable" class="table table-bordred table-striped table-hover">
                    <thead>
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
                            <td>{{ $timesheet_detail->ProjectID }}</td>
                            <td>{{ $timesheet_detail->ProjectTitle }}</td>
                            <td>{{ $timesheet_detail->DateFormatted }}</td>
                            <td>{{ $timesheet_detail->StartTimeFormatted}}</td>
                            <td>{{ $timesheet_detail->EndTimeFormatted}}</td> 
                            <td>{{ $timesheet_detail->HoursWorked}}</td>                         
                            <td>
                              <p data-placement="top" data-toggle="tooltip" title="Edit">
                              <button class="edit-modal btn btn-primary btn-xs {{ $timesheet_detail->CanEdit ? '' : 'disabled' }}" data-title="Edit" data-toggle="modal" data-projectid="{{$timesheet_detail->ProjectID}}" data-projecttitle="{{$timesheet_detail->ProjectTitle}}" data-date="{{$timesheet_detail->Date}}" data-starttime="{{$timesheet_detail->StartTime}}" data-endtime="{{$timesheet_detail->EndTime}}" data-hours="{{$timesheet_detail->HoursWorked}}" data-timesheetid="{{$timesheet_detail->TimesheetID}}">
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
    <div class="modal fade" id="updateMyTimesheetModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
          <!-- Modal content-->
            <form role="form" action = "/employee/viewtimesheet/update" method = "post">
                <input type = "hidden" name = "_token" value = "{{ csrf_token() }}">
                <input type = "hidden" id="inputProjectId" name="inputProjectId" />
                <input type = "hidden" id="inputTimesheetID" name="inputTimesheetID" />
                <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Update Timesheet</h4>
                    </div>
                    <div class="modal-body">
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
