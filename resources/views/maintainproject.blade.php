@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-md-10">
          <h4>List of Projects</h4>
      </div>
      <div class="col-md-2 right">
          <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#addNewProjectModal">Add New Project</button>
      </div>
  </div>
  <br>
  <div class="row">
      <div class="col-md-12">
          <div class="table-responsive">
              <table id="prjTable" class="table table-bordred table-striped table-hover">
                  <thead>
                      <th>Project ID</th>
                      <th>Project Title</th>
                      <th>Supervisor ID</th>
                      <th>Supervisor Name</th>
                      <th>Budget</th>
                      <th>Customer Name</th>
                      <th>Employees</th>
                      <th class="sorting-disabled">Edit</th>
                      <th class="sorting-disabled">Delete</th>
                  </thead>
                  <tbody>
                      @foreach ($projects as $project)
                      <tr>
                          <td>{{ $project->ProjectID }}</td>
                          <td>{{ $project->ProjectTitle }}</td>
                          <td>{{ $project->SupervisorID or "Not Assigned"}}</td>
                          <td>{{ $project->SupervisorName or "Not Assigned"}}</td>
                          <td>${{ $project->Budget }}</td>
                          <td>{{ $project->CustomerName}}</td>
                          <td>
                            <!-- <button type="button" class="btn btn-primary btn-xs" data-container="body" data-toggle="popover" data-placement="top" data-popover-content=".popover-body">
                              View
                            </button> -->
                              <div class="popover-body">
                                <?php $empIds = []; ?>
                                
                                @foreach ($employeeProjectList as $employee)
                                  @if ($employee->ProjectID == $project->ProjectID)
                                    <?php array_push($empIds, $employee->UserID); ?>
                                    <div>
                                      {{ $employee->UserID }}- {{ $employee->FullName }}
                                    </div>
                                  @endif
                                @endforeach
                              </div>
                          </td>
                          <td>
                            <p data-placement="top" data-toggle="tooltip" title="Edit">
                              <button class="edit-modal btn btn-primary btn-xs" data-id="{{$project->ProjectID}}" data-projecttitle="{{ $project->ProjectTitle }}" data-supervisor="{{ $project->SupervisorID }}" data-empids="{{ implode(',', $empIds) }}" data-budget="{{ $project->Budget }}" data-customer="{{ $project->CustomerName }}">
                              <span class="glyphicon glyphicon-edit"></span></button>
                              </p>
                          </td>
                          <td>
                            <p data-placement="top" data-toggle="tooltip" title="Delete">
                              <button class="delete-modal btn btn-danger btn-xs" data-title="Delete" data-id="{{ $project->ProjectID }}" data-projecttitle="{{ $project->ProjectTitle }}" >
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

  <!--  Add New Project Modal  -->
  <div class="modal fade" id="addNewProjectModal" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <form role="form" action = "/maintain/project" method = "post">
          <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
          <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Project</h4>
              </div>
              <div class="modal-body">
                <div class="form-group row">
                    <label for="inputTitle" class="col-sm-3 text-right">Project Title</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputTitle" name='inputTitle' placeholder="Enter Project Title" required />
                    </div>
                </div>
                <div class="form-group row">
                  <label for="inputTitle" class="col-sm-3 text-right">Select Supervisor</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="SupervisorSelection" name="SupervisorSelection" required>
                      <option value="">Please Select</option>
                      @foreach ($supervisorlist as $supervisorlist)
                      <option value="{{ $supervisorlist->UserID}}">{{$supervisorlist->UserID}} - {{$supervisorlist->FullName}} 
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputTitle" class="col-sm-3 text-right">Select Employee</label>
                  <div class="col-sm-9">
                    <select multiple class="form-control" id="EmployeeSelection" name="EmployeeSelection[]" required>
                      @foreach ($employeelist as $employeelist)
                      <option value="{{ $employeelist->UserID}}">{{$employeelist->UserID}} - {{$employeelist->FullName}} 
                      </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                    <label for="inputBudget" class="col-sm-3 text-right">Budget</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control hide-input-spinner" id="inputBudget" name='inputBudget' placeholder="Enter Budget" min="0" required />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputCustomerName" class="col-sm-3 text-right">Customer Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputCustomerName" name='inputCustomerName' placeholder="Enter Customer Name" required />
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
  <div class="modal fade" id="removePrjModal" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <!-- Modal content-->
          <form role="form" action = "/maintain/project/delete" method = "post">
              <input type = "hidden" name = "_token" value = "{{ csrf_token() }}">
              <input type = "hidden" id = "InputRemovePrj" name = "InputRemovePrj" value = "" />
              <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Remove Project</h4>
                  </div>
                  <div class="modal-body">
                      <div>
                          <p>Are you sure you want to remove <b><span id="removePrj"></span></b> from the system? This process can not be undone.</p>
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

  <!--  Update Project Modal  -->
  <div class="modal fade" id="updatePrjModal" role="dialog" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-md">
        <!-- Modal content-->
          <form role="form" action = "/maintain/project/update" method = "post">
              <input type = "hidden" name = "_token" value = "{{ csrf_token() }}">
              <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Project</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                        <label for="inputProjectID" class="col-sm-3 text-right">Project ID</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputProjectID" name='inputProjectID'
                            placeholder="Enter Project ID" readonly />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputTitle" class="col-sm-3 text-right">Project Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputTitle" name='inputTitle' placeholder="Enter Project Title" required />
                        </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputTitle" class="col-sm-3 text-right">Select Supervisor</label>
                      <div class="col-sm-9">
                        <select class="form-control" id="SupervisorSelection" name="SupervisorSelection" required>
                          <option value="">Please Select</option>
                          @foreach ($supervisorlistUpdate as $supervisorlist)
                          <option value="{{ $supervisorlist->UserID}}">{{$supervisorlist->UserID}} - {{$supervisorlist->FullName}} 
                          </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputTitle" class="col-sm-3 text-right">Select Employee</label>
                      <div class="col-sm-9">
                        <select multiple class="form-control" id="EmployeeSelection" name="EmployeeSelection[]" required>
                          @foreach ($employeelistUpdate as $employeelist)
                          <option value="{{ $employeelist->UserID}}">{{$employeelist->UserID}} - {{$employeelist->FullName}} 
                          </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputBudget" class="col-sm-3 text-right">Budget</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control hide-input-spinner" id="inputBudget" name='inputBudget' placeholder="Enter Budget" min="0" required />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputCustomerName" class="col-sm-3 text-right">Customer Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputCustomerName" name='inputCustomerName' placeholder="Enter Customer Name" required />
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