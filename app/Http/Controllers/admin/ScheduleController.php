<?php

namespace App\Http\Controllers\admin;

use App\Models\Schedule;
use App\Models\Batch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DatePeriod;
use DateTime;
use DateInterval;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('batch')->orderBy('id','desc')->get();
        return view('admin.schedules.index', compact('schedules'));
    }
    public function allSchedule()
    {
        $schedules = Schedule::with('batch')->orderBy('id','desc')->where('status',1)->get();
        $data = [];
        $i = 0;
        foreach ($schedules as $schedule_key => $schedule) {
            $period = new DatePeriod(
                new DateTime($schedule->start_date),
                new DateInterval('P1D'),
                new DateTime($schedule->end_date)
            );
            $week_days = explode(',' , $schedule->week_days);
            foreach ($period as $key => $value) {
                $date = $value->format('Y-m-d');
                $dayofweek = date('w', strtotime($date));
                if(in_array($dayofweek,$week_days)){
                    $data[$i]['event_id'] = $i +1;
                    $data[$i]['title'] = $schedule->batch->title ." (" . $schedule->batch->course->title . ")";
                    $data[$i]['start'] = $date;
                    $data[$i]['start_time'] = date('h:i:s a', strtotime($schedule->start_time));
                    $data[$i]['end_time'] = date('h:i:s a', strtotime($schedule->end_time));
                    $i++;
                }
            }
        }

        return response()->json($data, 200);
    }

    public function calendar()
    {
        $schedules = Schedule::with('batch')->orderBy('id','desc')->get();
        return view('admin.schedules.calendar', compact('schedules'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['schedule'] = Schedule::find($id);
            $batch_id = $data['schedule']->batch_id;
            $data['batches'] = Batch::with('course')->where(function ($query) use ($batch_id){
                                              $query->where('is_scheduled', '=', 0)
                                                    ->orWhere('id', '=', $batch_id);
                                        })->where('status',1)->get();
        }else{
            $data['title'] = 'Create';
            $data['batches'] = Batch::with('course')->where('status',1)->where('is_scheduled',0)->get();
        }
        
        return view('admin.schedules.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $days = '';
        foreach ($data['week_days'] as $key => $week_day) $days .= $key==0? $week_day : ','. $week_day;
        $data['week_days'] = $days;
        $data['created_by_id'] = Auth::guard('admin')->user()->id;
        Schedule::create($data);
        Batch::find($data['batch_id'])->update(['is_scheduled'=>1]);
        return redirect('admin/schedule/schedules')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, Schedule $schedule)
    {
        Batch::find($schedule->batch_id)->update(['is_scheduled'=>0]);
        $data = $request->all();
        $days = '';
        foreach ($data['week_days'] as $key => $week_day) $days .= $key==0? $week_day : ','. $week_day;
        $data['week_days'] = $days;
        $data['updated_by_id'] = Auth::guard('admin')->user()->id;
        $schedule->update($data);
        Batch::find($data['batch_id'])->update(['is_scheduled'=>1]);
        return redirect('admin/schedule/schedules')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Deleted Successfully!']);
    }
}
