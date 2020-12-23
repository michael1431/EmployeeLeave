<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Leave;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public  function  index(){
        $employees=Employee::all();
        $leaves=Leave::all();
        return view('create',compact('employees','leaves'));
    }
    public function getData($employee_id){
        $employeeInfo=Employee::find($employee_id);
        return response()->json(['employee'=>$employeeInfo]);
    }
    public function  getLeaveInfo($leave_id){
        $leaveInfo=Leave::where('id',$leave_id)->with('Employee')->first();
        $leave_start='';

        return response()->json(['leaveInfo'=>$leaveInfo,'leave_start'=>$leave_start]);
    }
    public function store(Request $request){

        $this->validate($request,[
           'emp_id' => 'required',
           'leave_id'=>'required',
            'start_date' => 'required',
            'end_date'=>'required',
            ],
            [
                'emp_id.required'=>'Please select employee id',
                'leave_id.required'=>'Please select leave field',
                'start_date.required'=>'Please select start date',
                'end_date.required' => 'Please select end date',

        ]);

        $employee_leave=Employee::find($request->emp_id);
        $employee_leave->Leave()->attach($request->leave_id,['leave_start' => $request->start_date,'leave_end'=>$request->end_date]);
        $employee_leave->save();
        session()->flash('success','Data inserted successfully!');
        return redirect()->back();
    }
}
