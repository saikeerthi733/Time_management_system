@extends('layouts.app')

@section('content')
<div class="container">
  <h4>List of Projects</h4>
  <br>
  <form action = "/manage/project/showdetails" method="get">
    <div class="form-group row">
      <label for="projSelection" class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-right">Select Project</label>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <select class="form-control" id="projSelection" name="projSelection" required>
          <option value="">Please Select</option>
          @foreach ($projects as $project)
          <option value="{{ $project->ProjectID }}" {{$getselectedproj == $project->ProjectID ? "selected" : ""}}>{{ $project->ProjectTitle }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary btn-md">Go</button>
    </div>
  </form>
  <hr>
  <div id="projectDetails" class="{{ $getselectedproj != 0 ? '' : 'hidden'}}">
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
            <h4>Project Details</h4>
        </div>
    </div>

  
    @foreach ($show_projects as $show_projects)
    <div class="row">
      <label class="col-lg-2 col-md-2 col-sm-2 col-xs-3 text-right">Project ID</label><div class="col-lg-2 col-md-2 col-sm-2 col-xs-3" name="inputProjectID">{{ $show_projects->ProjectID }}</div>
      <label class="col-lg-2 col-md-2 col-sm-2 col-xs-3 text-right">Project Title</label><div class="col-lg-2 col-md-2 col-sm-2 col-xs-3">{{ $show_projects->ProjectTitle }}</div>
      <label class="col-lg-2 col-md-2 col-sm-2 col-xs-3 text-right">Customer Name</label><div class="col-col-lg-2 col-md-2 col-sm-2 col-xs-3">{{ $show_projects->CustomerName }}</div>
    </div>
    @endforeach

    <br><br>
    <div class="row">
        <div class="col-lg-offset-10 col-md-offset-10 col-sm-offset-10 col-xs-offset-8 col-lg-2 col-md-2 col-sm-2 col-xs-4 text-right">
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#addEmpModal">Add Employee</button>
        </div>
    </div>
    <br/>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table id="managePrjtable" class="table table-bordred table-striped">
            <thead>
              <th>Employee ID</th>
              <th>Full Name</th>
              <th>Address</th>
              <th>Email</th>
              <th>Job Title</th>
              <th>Remove</th>
            </thead>
            <tbody>
            @foreach ($employees as $employee)
              <tr>
                <td>{{ $employee->UserID }}</td>
                <td>{{ $employee->FullName }}</td>
                <td>{{ $employee->Address }}</td>
                <td>{{ $employee->EmailID}}</td>
                <td>{{ $employee->JobTitle}}</td> 
                <td>
                  <p data-placement="top" data-toggle="tooltip" title="Delete">
                    <button class="delete-modal btn btn-danger btn-xs" data-title="Delete" data-id="{{ $employee->UserID }}" data-fullname="{{ $employee->FullName }}" >
                    <span class="glyphicon glyphicon-remove"></span></button>
                  </p>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
  <div class="modal fade" id="addEmpModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <form role="form" action = "/manage/project/addemployee" method = "post">
        <input type = "hidden" name = "_token" value = "{{ csrf_token() }}">
        <input type = "hidden" name = "getselectedproj" value = "{{ $getselectedproj }}">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add New Employee</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                  <div class="table-responsive">
                      <table id="mytable" class="table table-bordred table-striped table-hover">
                          <thead>
                              <th><!-- <input type="checkbox" id="checkall" /> --></th> 
                              <th>Employee ID</th>
                              <th>Full Name</th>
                              <th>Address</th>
                              <th>Email</th>
                              <th>Job Title</th>
                          </thead>
                          <tbody>                              
                              @foreach ($addemployees as $addemployee)
                              <tr>
                                  <td><input type="checkbox" name="addEmployeesList[]" value="{{ $addemployee->UserID }}" /></td>
                                  <td>{{ $addemployee->UserID }}</td>
                                  <td>{{ $addemployee->FullName }}</td>
                                  <td>{{ $addemployee->Address }}</td>
                                  <td>{{ $addemployee->EmailID }}</td>
                                  <td>{{ $addemployee->JobTitle }}</td> 
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!--  Remove Project from the system  -->
  <div class="modal fade" id="removePrjEmpModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <!-- Modal content-->
        <form role="form" action = "/manage/project/deleteemployee" method = "post">
            <input type = "hidden" name = "_token" value = "{{ csrf_token() }}">
            <input type = "hidden" id = "InputRemovePrjEmp" name = "InputRemovePrjEmp" value = "" />
            <input type = "hidden" name = "getselectedproj" value = "{{ $getselectedproj }}">
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Remove Project</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <p>Are you sure you want to remove <b><span id="removePrjEmp"></span></b> from the system? This process can not be undone.</p>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-danger">Remove</button>
                </div>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection
