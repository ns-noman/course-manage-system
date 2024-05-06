<?php

namespace App\Http\Controllers\admin;

use App\Models\Evaluation;
use App\Models\Schedule;
use App\Models\Enroll;
use App\Models\Trainee;
use App\Models\EvaluationDetails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::leftJoin('schedules', 'evaluations.schedule_id', '=', 'schedules.id')
                            ->leftJoin('batches', 'schedules.batch_id', '=', 'batches.id')
                            ->leftJoin('courses', 'batches.course_id', '=', 'courses.id')
                            ->leftJoin('trainers', 'batches.trainer_id', '=', 'trainers.id')
                            ->select('evaluations.*','courses.title as course_title','batches.title','trainers.name as trainer')             
                            ->orderBy('id','desc')->get();
        return view('admin.results.index', compact('evaluations'));
    }

    public function certificates()
    {
        $schedules = Schedule::with('batch')->where('status',1)->get();
        return view('admin.results.certificates', compact('schedules'));
    }
    public function certificatePrint(Request $request)
    {
        $schedule_id = $request->schedule_id;
        $certificate_type = $request->certificate_type;
        $print_type = $request->print_type;
        $trainee_id = $request->trainee_id;
        
        $schedule = Schedule::where('id', $schedule_id)->with('batch')->first();
        $certificate_no = Enroll::where(['schedule_id'=>$schedule->id, 'trainee_id'=> $trainee_id])->first()->certificate_no;
        $data['srl_no'] = $this->formatSrl(($certificate_no));
        $data['start_date'] = $schedule->start_date;
        $data['end_date'] = $schedule->end_date;
        $data['course_title'] = $schedule->batch->course->title;
        $data['trainee_name'] = Trainee::find($trainee_id)->name;
        $data['print_type'] = $print_type;

        if($certificate_type==2 || $certificate_type==3 || $certificate_type==4){
            if($certificate_type==3 || $certificate_type==4){
                $evaluation = Evaluation::leftJoin('evaluation_details', 'evaluation_details.evaluation_id', '=', 'evaluations.id')
                                        ->leftJoin('enrolles', 'evaluation_details.enroll_id', '=', 'enrolles.id')
                                        ->where('evaluations.schedule_id',$schedule->id)          
                                        ->where('enrolles.trainee_id',$trainee_id)       
                                        ->select('evaluation_details.*')
                                        ->orderBy('id','desc')->first();
                if(!$evaluation){
                    return redirect()->back()->with('alert',['messageType'=>'danger','message'=>'Result is not entered of this trainee!']);
                }

                if($certificate_type==3){
                    $data['remarks'] = $evaluation->remarks;
                }else{
                    $data['marks'] = $evaluation->obtain_marks;
                }
            }
            return view('admin.results.course-completing', compact('data'));

        } else if($certificate_type==1){
            return view('admin.results.course-participating', compact('data'));
        }

    }

    public function createOrEdit($id=null)
    {
        
        $data['schedules'] = Schedule::query();
        if($id){
            $data['evaluation'] = Evaluation::find($id);
            $data['evaluation']->evaluation_details = EvaluationDetails::leftJoin('enrolles', 'evaluation_details.enroll_id', '=', 'enrolles.id')
                                    ->leftJoin('trainees', 'enrolles.trainee_id', '=', 'trainees.id')
                                    ->select('evaluation_details.*','trainees.name as trainee','enrolles.trainee_id')
                                    ->where('evaluation_id',$id)->get();
                                    $data['title'] = 'Edit';
        }else{
            $data['title'] = 'Create';
            $data['schedules'] = $data['schedules']->where('result_entry',0);
        }
        $data['schedules'] = $data['schedules']->with('batch')->where('status',1)->get();
        return view('admin.results.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $obtain_marks = $request->obtain_marks;
        $remarks = $request->remarks;
        $enrolles = Enroll::with('trainee')->where('schedule_id', $request->schedule_id)->get();

        $evaluation['schedule_id'] = $request->schedule_id;
        $evaluation['evaluation_date'] = $request->evaluation_date;
        $evaluation['total_marks'] = $request->total_marks;
        $evaluation['created_by_id'] = Auth::guard('admin')->user()->id;
        $evaluation = Evaluation::create($evaluation);

        foreach ($enrolles as $key => $enroll) {
            $evaluationDetails = 
            [
                'evaluation_id'=> $evaluation->id,
                'enroll_id'=> $enroll->id,
                'obtain_marks'=> $obtain_marks[$key],
                'remarks'=> $remarks[$key],
            ];
            EvaluationDetails::create($evaluationDetails);
        }
        return redirect('admin/result/result-entries')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }


    public function update(Request $request, Evaluation $evaluation)
    {
        $evaluationUpdate = 
        [
            'total_marks'=>$request->total_marks,
            'evaluation_date'=>$request->evaluation_date,
            'updated_by_id'=> Auth::guard('admin')->user()->id,
        ];
        $evaluation->update($evaluationUpdate);

        $obtain_marks = $request->obtain_marks;
        $evaluation_details_id = $request->evaluation_details_id;
        $remarks = $request->remarks;

        foreach ($evaluation_details_id as $key => $ed_id) EvaluationDetails::find($ed_id)->update(['obtain_marks'=>$obtain_marks[$key], 'remarks'=>$remarks[$key]]);

        return redirect('admin/result/result-entries')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }


    public function destroy($id)
    {
        Evaluation::find($id)->delete();
        EvaluationDetails::where('evaluation_id', $id)->delete();
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Deleted Successfully!']);
    }

    public function formatSrl($srl)
    {
        switch(strlen($srl)){
            case 1:
                $zeros = '00000';
                break;
            case 2:
                $zeros = '0000';
                break;
            case 3:
                $zeros = '000';
                break;
            case 4:
                $zeros = '00';
                break;
            default:
                $zeros = '0';
            break;
        }
        return $zeros . $srl;
    }
}   
