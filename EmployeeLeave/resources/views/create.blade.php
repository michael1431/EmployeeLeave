<html>

<head>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>

</head>

<body>
<div class="container mt-3">
    <div class="card">
        <div class="card-header">
            @include('messages')
            <h3 class="text-success" style="text-align: center;">Employee Leave Management System</h3>
        </div>

        <form action="{{route('employee.leave.apply')}}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="Employee Id">Employee ID : </label>

                            <select class="form-control " name="emp_id" id="employeeId">
                                <option value="">Please Select Employee ID</option>
                                  @foreach($employees as $emp)
                                        <option value="{{$emp->id}}">{{$emp->name}}( {{$emp->id}} )</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group" >
                            <label for="name">Name : </label>
                            <input type="text" class="form-control" name="name"  id="Employee_name" readonly>
                        </div>
                    </div>

                    <div class="col-sm-4">

                        <div class="form-group" >
                            <label for="name">Designation : </label>
                            <input type="text" class="form-control " name="designation"  id="Employee_Designation" readonly>
                        </div>
                    </div>
                </div>



                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="Employee Id">Leave : </label>

                            <select  class="form-control " name="leave_id" id="LeaveId">
                                <option  value="">Select Leave</option>
                                @foreach($leaves as $leave)
                                  <option value="{{$leave->id}}">{{$leave->leave_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">

                        <div class="form-group" >
                            <label for="name">Maximum Leave : </label>
                            <input type="text" class="form-control " name="max_leave"  id="max_leave" readonly>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group" >
                            <label for="name">Leave Remaining :</label>
                            <input type="text" class="form-control " name="leave_remain"   id="leave_remain" readonly>
                            <small id="recentRemainingDate" class="form-text text-muted"></small>
                        </div>
                    </div>
                  </div>





                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="start_date">Leave Start : </label>
                            <input class="form-control date" id="startDate" placeholder="Leave Start From (dd-mm-yyyy)" name="start_date" type="text">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="end_date">Leave End : </label>
                            <input class="form-control date" id="endDate"  placeholder="Leave End (dd-mm-yyyy)" name="end_date" type="text">
                        </div>
                    </div>

                </div>
                <button type="submit" class="btn btn-primary btn-lg" style="margin-left: 400px;">Apply Now</button>

            </div>

        </form>

    </div>


</div>


<script type="text/javascript">

    $('.date').datepicker({

        format: 'yyyy-mm-dd'

    });

</script>

</body>


</html>
<script>
    $("#employeeId").change(function(){
        let employee_id = $("#employeeId").val();
        let Employee_name = $("#Employee_name");
        let Employee_Designation = $("#Employee_Designation");
        let url = "{{ url('/')}}";
        $.get(url+"/employee/get/data/"+employee_id, function(data){
            Employee_name.val(data.employee.name);
            Employee_Designation.val(data.employee.designation);
        });
    });

    $("#LeaveId").change(function(){
        let LeaveId = $("#LeaveId").val();
        let leave_remain = $("#leave_remain");
        let url = "{{ url('/')}}";
        $.get(url+"/leaveInfo/get/"+LeaveId, function(data){
            let maxLeave = $("#max_leave");
            maxLeave.val(data.leaveInfo.leave_day)
            // console.log(data.leaveInfo);
          let leaveInfo = data.leaveInfo.employee;
            let maxLeaveDay = data.leaveInfo.leave_day;
            let Difference_In_Days=0;

            let lastStartDate=[];
            let lastEndDate=[];
            let employee_id = $("#employeeId").val();
            leaveInfo.forEach(function (data) {
                if(data.pivot.employee_id==employee_id){
                    lastStartDate.push(data.pivot.leave_start);
                    lastEndDate.push(data.pivot.leave_end);
                    let startDate = new Date(data.pivot.leave_start);
                    let endDate = new Date(data.pivot.leave_end);

                    let Difference_In_Time = endDate.getTime() - startDate.getTime();
                    // console.log(Difference_In_Time);
                    // To calculate the no. of days between two dates
                    Difference_In_Days += Difference_In_Time / (1000 * 3600 * 24);
                    // console.log(Difference_In_Days);
                }
          });
            //console.log(lastStartDate);
            //console.log(lastEndDate);


           // console.log('last start',lastStart);
            //console.log('last end',lastEnd);


            if(maxLeaveDay < Difference_In_Days){
                console.log('invalid');
            }else{
                let remain = maxLeaveDay - Difference_In_Days;
                leave_remain.val(remain);

                let lastStart = lastStartDate[lastStartDate.length - 1];
                let lastEnd = lastEndDate[lastEndDate.length - 1];
                $('#recentRemainingDate').text('Recent Remaining Date: '+lastStart+' To '+lastEnd);

            }
          // console.log(leaveInfo);
        });




    })

    $("#endDate").change(function(){
        let startDate = $("#startDate").val();
        let endDate = $("#endDate").val();

        let remainDays = $("#leave_remain").val();
        let finalStartDate = new Date(startDate);
        let finalEndDate = new Date(endDate);

        let Time = finalEndDate.getTime() - finalStartDate.getTime();
        // console.log(Difference_In_Time);
        // To calculate the no. of days between two dates
        let diffDays = Time / (1000 * 3600 * 24);
        if (remainDays < diffDays ){
            alert('You can not take leave more than ' + remainDays + ' days');
        }else{
            console.log('you are genious');
        }

    });

</script>


<!--
<script>

    $("#emp_id").change(function(){
        // individual employee id tar value ta asteche
        var emp_id = $("#emp_id").val();
        // name field er id ta niye astechi
        var inputValue1 = $("#inputValue1");
        // designation field er id ta niye astechi
        var inputValue2 = $("#inputValue2");
        // remain field er id ta dortechi
        var leave_remain = $("#leave_remain");
        // leave field ta nicchi
        var leave = $("#leave");
        var url = "{{ url('/')}}";
        $.get(url+"/employee/get/data/"+emp_id, function(data){
            //console.log(data);
            // datar modde sob value asteche
            var employee = data.employee;
            // employee data ta niye astechi
            var register = data.register;
            // register er data gulo niye astechi
            employee.forEach(function(element){
                // name field er value ta niye astechi
                inputValue1.val(element.name);
                // designation field er value ta niye astechi
                inputValue2.val(element.designation);

                // loop calanor jonno variable nibo
                var el =element.leave;
                el.forEach(elee=>{
                    //leave name gulo niye asbo
                    leave.html(`<option value="${elee.leave_day}">${elee.leave_name}</option>`);
                })
            });
            var leaveinfo = $("#leave").val();
            // console.log(register);
            var maxLeave = $("#max_leave");
            //var leave_remain = $("#leave_remain");
            register.forEach(function (reg) {
                if(reg.leave_name == leaveinfo){
                    maxLeave.val(reg.max_leave);
                    // start date ta niye nicchi
                    var date1 = reg.start_date;
                    // end date ta niye nicchi
                    var date2 = reg.end_date;
                    // Date er object banalam
                    var date3 = new Date(date1);
                    var date4 = new Date(date2);
                    // To calculate the time difference of two dates
                    var Difference_In_Time = date4.getTime() - date3.getTime();
                    // To calculate the no. of days between two dates
                    var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                    // max leave niye aslam
                    var max_leave = reg.max_leave;
                    // diffference ta ber korlam
                    var remain = max_leave - Difference_In_Days;
                    //leave er value ta print kortechi
                    leave_remain.val(remain);
                    // console.log(remain);

                    if(remain==0){
                        alert("You do not have any vacation");
                    }

                    //console.log(remain);
                    /*To display the final no. of days (result)
                     document.write("Total number of days between dates  <br>"
                         + date3 + "<br> and <br>"
                         + date4 + " is: <br> "
                         + Difference_In_Days);*/
                }
            })
        });
    })


    $("#leave").change(function(){

        var leave = $("#leave").val();
        var maxLeave = $("#max_leave");
        //var leave_remain = $("#leave_remain");
        maxLeave.val(leave);
        //leave_remain.val(leave);
    })


</script>
-->
