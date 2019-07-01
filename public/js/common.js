$(document).ready(function(){
    onChangeTimePeriod($('#reportSelection').val());

    function onChangeTimePeriod(selectedVal) {
        $('#inputStartDate, #fromDateSection, #inputEndDate, #endDateSection, #yearSection').hide();
        $('#inputEndDate').removeAttr('readonly');
        $('#inputStartDate, #inputEndDate').removeAttr('required');

       if(selectedVal == 2) {
            $('#inputStartDate').attr('required','');
            $('#inputEndDate').attr('readonly','');
            $('#inputStartDate, #fromDateSection, #inputEndDate, #endDateSection').show();
       } else if(selectedVal == 3) {
            $('#yearSection').show();
       } else if(selectedVal == 4) {
            $('#inputStartDate, #fromDateSection, #inputEndDate, #endDateSection').show();
            $('#inputStartDate, #inputEndDate').attr('required','');
       }
    }
    $('#reportSelection').on('change', function(e) {
       var selectedVal = $(e.target).val();

        onChangeTimePeriod(selectedVal);
    });
    $('#inputStartDate').on('change', function(e) {
        if($('#reportSelection').val() == 2) {
            var lastWeek=new Date(new Date($('#inputStartDate').val()).getTime() + 7 * 24 * 60 * 60 * 1000);
            var day = ("0" + lastWeek.getDate()).slice(-2);
            var month = ("0" + (lastWeek.getMonth() + 1)).slice(-2);
            $('#inputEndDate').val(lastWeek.getFullYear()+'-'+month+'-'+day);
        }
    });
    /*
        $('#prjTable [data-toggle="popover"]').popover({
            trigger: 'focus',
            placement : 'top',
            html : true,
            content: function() {
                if($(this).next().html()) {
                    return $(this).next().html();
                }
                return "No Employee Found";
            }
        });
    */
    //Maintain Employee - Load data in Modal on Edit Employee
    $(document).on('click', '#empTable .edit-modal', function() {
        $('#updateEmpModal').modal('show');

        $('#updateEmpModal #inputUserID').val($(this).data('id'));
        $('#updateEmpModal #inputFullName').val($(this).data('fullname'));
        $('#updateEmpModal #inputAddress').val($(this).data('address'));
        $('#updateEmpModal #inputEmail').val($(this).data('emailid'));
        $('#updateEmpModal #inputJobTitle').val($(this).data('jobtitle'));
        $('#updateEmpModal #inputSalary').val($(this).data('salary'));
        if($(this).data('role')==2) {
            $('#updateEmpModal #inputSupervisor').prop('checked',true);
        } else {
            $('#updateEmpModal #inputSupervisor').prop('checked',false);
        }
    });

    //Maintain Employee - Delete Record Modal
    $(document).on('click', '#empTable .delete-modal', function() {
        $('#removeEmpModal').modal('show');

        $('#removeEmpModal #removeEmp').text($(this).data('id') + " " + $(this).data('fullname'));
        $('#removeEmpModal #InputRemoveEmp').val($(this).data('id'));

    });

    //Maintain Project - Load data in Modal on Edit Project
    $(document).on('click', '#prjTable .edit-modal', function() {
        var supervisorID = $(this).data('supervisor') != "Not Assigned" ? $(this).data('supervisor') : '';
        $('#updatePrjModal').modal('show');

        $('#updatePrjModal #inputProjectID').val($(this).data('id'));
        $('#updatePrjModal #inputTitle').val($(this).data('projecttitle'));
        $('#updatePrjModal #SupervisorSelection').val(supervisorID);
        $('#updatePrjModal #inputBudget').val($(this).data('budget'));
        $('#updatePrjModal #inputCustomerName').val($(this).data('customer'));
        if($(this).data('empids')) {
            var data = $(this).data('empids').toString().split(',');
            $('#updatePrjModal #EmployeeSelection').val(data);
        }
    });

    //Maintain Project - Delete Record Modal
    $(document).on('click', '#prjTable .delete-modal', function() {
        $('#removePrjModal').modal('show');

        $('#removePrjModal #removePrj').text($(this).data('id') + " " + $(this).data('projecttitle'));
        $('#removePrjModal #InputRemovePrj').val($(this).data('id'));

    });

    //Manage Project - Delete Record Modal
    $(document).on('click', '#managePrjtable .delete-modal', function() {
        $('#removePrjEmpModal').modal('show');

        $('#removePrjEmpModal #removePrjEmp').text($(this).data('id') + " " + $(this).data('fullname'));
        $('#removePrjEmpModal #InputRemovePrjEmp').val($(this).data('id'));

    });

    //Create jQuery DataTable   -  gives Filter, Pagination, Sort features
    $('#empTable').DataTable();
    $('#prjTable').DataTable();
    $('#myTimesheetTable').DataTable({
        aaSorting: [[2, 'desc']]
    });
    $('#timesheetTable').DataTable({
        aaSorting: [[4, 'desc']]
    });

    //Update MY Timesheet - Load data in Modal on Update Timesheet
    $(document).on('click', '#myTimesheetTable .edit-modal:not(".disabled")', function() {
        $('#updateMyTimesheetModal').modal('show');        


        $('#updateMyTimesheetModal #inputTimesheetID').val($(this).data('timesheetid'));
        $('#updateMyTimesheetModal #inputProjectId').val($(this).data('projectid'));
        $('#updateMyTimesheetModal #inputProject').val($(this).data('projectid') + " - " + $(this).data('projecttitle'));
        $('#updateMyTimesheetModal #inputDate').val($(this).data('date'));
        $('#updateMyTimesheetModal #inputStartTime').val($(this).data('starttime'));
        $('#updateMyTimesheetModal #inputEndTime').val($(this).data('endtime'));
    });

    //Update Employee Timesheet - Load data in Modal on Update Timesheet
    $(document).on('click', '#timesheetTable .edit-modal:not(".disabled")', function() {
        $('#updateEmpTimesheetModal').modal('show');        

        $('#updateEmpTimesheetModal #inputTimesheetID').val($(this).data('timesheetid'));
        $('#updateEmpTimesheetModal #inputEmployeeId').val($(this).data('id'));
        $('#updateEmpTimesheetModal #inputProjectId').val($(this).data('projectid'));
        $('#updateEmpTimesheetModal #inputEmployee').val($(this).data('id') + " - "+ $(this).data('fullname'));
        $('#updateEmpTimesheetModal #inputProject').val($(this).data('projectid') + " - " + $(this).data('projecttitle'));
        $('#updateEmpTimesheetModal #inputDate').val($(this).data('date'));
        $('#updateEmpTimesheetModal #inputStartTime').val($(this).data('starttime'));
        $('#updateEmpTimesheetModal #inputEndTime').val($(this).data('endtime'));
    });
});