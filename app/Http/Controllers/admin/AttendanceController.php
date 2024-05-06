<?php

namespace App\Http\Controllers\admin;

use App\Models\Attendance;
use App\Models\Batch;
use App\Models\Schedule;
use App\Models\Enroll;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('schedule')->orderBy('id','desc')->get();
        return view('admin.attendances.index', compact('attendances'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['course'] = Attendance::find($id);
            $data['title'] = 'Edit';
        }else{
            $data['title'] = 'Create';
        }
        $data['schedules'] = Schedule::with('batch')->where('status',1)->get();
        return view('admin.attendances.create-or-edit',compact('data'));
    }
    public function getScheduleTrainee($id)
    {
        $schedule = Schedule::where('id', $id)->first();
        if($schedule){
            $data = Enroll::with('trainee')->where('schedule_id', $schedule->id)->where('status',1)->get();
        }else{
            $data = [];
        }
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $enrolles = Enroll::with('trainee')->where(['schedule_id'=> $request->schedule_id, 'status'=>1])->get();
        
        foreach ($enrolles as $key => $enroll) {
            $att_status = in_array($enroll->id, $data['attendance_status']) ? 1 : 0;
            $attendance = 
            [
                'schedule_id'=> $enroll->schedule_id,
                'enrolle_id'=> $enroll->id,
                'date'=> $data['date'],
                'attendance_status'=> $att_status,
                'comment'=> $data['comment'][$key],
                'status'=> 1,
                'created_by_id'=> Auth::guard('admin')->user()->id,
            ];
            Attendance::create($attendance);
        }
        return redirect('admin/attendances')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, Attendance $attendance)
    {
        
    }
    public function destroy(Attendance $attendance)
    {

    }
}
