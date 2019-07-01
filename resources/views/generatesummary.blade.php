@extends('layouts.app')

@section('content')
<div class="container">
	<form id="generateForm" action = "/generatereport" method="get">
	<div>
		<h4>Generate Summary</h4>
		<br>
	    <div class="form-group row">
		    <label for="projSelection" class="col-lg-2 col-md-2 col-sm-4 col-xs-3 text-right">Select Project</label>
		    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-6">
		      <select class="form-control" id="projSelection" name="projSelection" required>
		        <option value="">Please Select</option>
		       	@foreach ($projects as $project)
		        <option value="{{ $project->ProjectID }}" {{$getselectedproj == $project->ProjectID ? "selected" : ""}}>{{ $project->ProjectTitle }}</option>
		        @endforeach
		      </select>
		    </div>
	  	</div>
	  	<div class="form-group row">
		    <label for="projSelection" class="col-lg-2 col-md-2 col-sm-4 col-xs-3 text-right">Time Period</label>
		    <div class="col-lg-4 col-md-4 col-sm-5 col-xs-6">
				<select class="form-control" id="reportSelection" name="reportSelection" required>
					<option value="">Please Select</option>
					<option value="1" {{$getselectedreport == "1" ? "selected" : ""}}>Daily</option>
					<option value="2" {{$getselectedreport == "2" ? "selected" : ""}}>Weekly</option>
					<option value="3" {{$getselectedreport == "3" ? "selected" : ""}}>Monthly</option>
					<option value="4" {{$getselectedreport == "4" ? "selected" : ""}}>Custom</option>
				</select>
		    </div>
	  	</div>
	  	<div class="form-group row" id="fromDateSection">
			<label for="inputStartTime" class="col-lg-2 col-md-2 col-sm-4 col-xs-3 text-right">From Date</label>
			<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6">
				<input type="date" class="form-control" id="inputStartDate" name="inputStartDate" placeholder="Enter Start Date" value="{{ Request::get('inputStartDate') }}" />
			</div>
	    </div>
	  	<div class="form-group row" id="endDateSection">
			<label for="inputEndTime" class="col-lg-2 col-md-2 col-sm-4 col-xs-3 text-right">To Date</label>
			<div class="col-lg-4 col-md-4 col-sm-5 col-xs-6">
				<input type="date" class="form-control" id="inputEndDate" name="inputEndDate" placeholder="Enter End Date" value="{{ Request::get('inputEndDate') }}" />
			</div>
	  	</div>
	  	<div class="form-group row" id="yearSection">
	  		<label for="yearSection" class="col-lg-2 col-md-2 col-sm-4 col-xs-3 text-right">Month & Year</label>
			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
				{{ Form::selectMonth('month', date('m'), ['class' => 'form-control']) }}
			</div>
			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
				{{ Form::selectYear('year', date('Y'), date('Y')-10, date('Y'), ['class' => 'form-control']) }}
			</div>
	  	</div>

	  	<br>
	  	<div class="row">
			<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<button type="button" class="hidden btn btn-default col-lg-offset-5 col-lg-3 col-md-offset-5 col-md-3 col-sm-offset-5 col-sm-3 col-xs-offset-5 col-xs-3 pull-left" data-dismiss="modal">Reset</button>
				<button type="submit" class="btn btn-primary col-lg-3 col-md-3 col-sm-offset-1 col-sm-3 col-xs-3 pull-right">Generate</button>
			</div>
		</div>
	</div>
	</form>
	<div id="projectDetails" class="{{ $getselectedproj != 0 ? '' : 'hidden'}}">
	<div id="getselectedreport" class="{{ $getselectedreport != 0 ? '' : 'hidden'}}">

  	<hr>
	<h4>Summary Report</h4>
	<br>
	<div class="container" style="background-color: #e1f5fe63;">
		<div class="row">
			<h4>
				<div class="text-center">
					@if (count($reports) <= 0)
					<label>No result found</label>
					@else
					<label> {{ $reports[0]->ProjectTitle }}</label>
					
				</div>
			</h4>
		</div>
		<div class="row">
			<h4 class="text-center"></h4>
		</div>
		<br>
	  	<div class="form-group row">
		    <div class="col-md-12">
				<div class="table-responsive">
					<table id="mytable" class="table table-bordred table-striped">
						<thead>
							<th>Date</th>
							<th>Employee ID</th>
							<th>Full Name</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>Hours Worked</th>
						</thead>
					  	<tbody>
					  	@foreach ($reports as $report)
					    <tr>
					    	<td>{{ $report->DateFormatted }}</td>
							<td>{{ $report->UserID }}</td>
							<td>{{ $report->FullName }}</td>
							<td>{{ $report->StartTime }}</td>
							<td>{{ $report->EndTime }}</td>
							<td>{{ $report->HoursWorked }}</td>
					    </tr>
					    @endforeach
					    @endif
					  </tbody>
					</table>
				</div>
			</div>
	  	</div>
  	</div>
</div>
@endsection
