<?php

namespace App\Http\Controllers\admin;

use App\Models\Enroll;
use App\Models\Schedule;
use App\Models\Trainee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class EnrollController extends Controller
{
    public function index()
    {
        $enrolles = Enroll::with(['schedule','trainee'])->orderBy('id','desc')->get();
        return view('admin.enrolles.index', compact('enrolles'));
    }
    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['enroll'] = Enroll::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['schedules'] = Schedule::with('batch')->where('status',1)->get();
        $data['trainees'] = Trainee::where('status',1)->get();
        return view('admin.enrolles.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $trainee_id = $request->trainee_id;
        $note = $request->note;
        $status = $request->status; 
        foreach ($trainee_id as $key => $t_id) {
            $enroll = 
            [
                'schedule_id'=> $request->schedule_id,
                'trainee_id'=> $trainee_id[$key],
                'enroll_date'=> $request->enroll_date,
                'note'=> $note[$key],
                'status'=> $status[$key],
                'created_by_id'=> Auth::guard('admin')->user()->id,
            ];
            $enroll['certificate_no'] = Enroll::orderBy('certificate_no', 'desc')->value('certificate_no') + 1;
            Enroll::create($enroll);
        }
        return redirect('admin/enrolles')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, $enroll)
    {
        $enroll = Enroll::find($enroll);
        $data = $request->all();
        $data['updated_by_id'] = Auth::guard('admin')->user()->id;
        
        if($request->status){
            $data['certificate_no'] = Enroll::orderBy('certificate_no', 'desc')->value('certificate_no') + 1;
        }

        $enroll->update($data);
        return redirect('admin/enrolles')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy($enroll)
    {
        Enroll::find($enroll)->delete();
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Deleted Successfully!']);
    }
}
