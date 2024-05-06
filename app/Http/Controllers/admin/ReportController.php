<?php

namespace App\Http\Controllers\admin;


use App\Models\Department;
use App\Models\Trainee;
use App\Models\Course;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\Batch;
use App\Models\Expense;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function trainingReports()
    {
        $departments = Department::get();
        return view('admin.all-reports.training-reports.filter', compact('departments'));
    }
    public function trainingReportsPrint()
    {
        return view('admin.all-reports.training-reports.print');
    }
    public function deptTrainees($id)
    {
        $trainees = Trainee::where('department_id', $id)->get();
        return response()->json($trainees, 200);
    }
    public function trainingReportsData(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $department_id = $request->department_id;
        $trainee_id = $request->trainee_id;
        $summery = [];

        $courses = Course::join('batches','courses.id','=','batches.course_id')
                    ->join('schedules','batches.id','=','schedules.batch_id');

        if($department_id){
            $courses = $courses->join('enrolles','schedules.id','=','enrolles.schedule_id')
                        ->join('trainees','enrolles.trainee_id','=','trainees.id')
                        ->join('departments','trainees.department_id','=','departments.id')
                        ->where('departments.id',$department_id);
            if($trainee_id){
                $courses = $courses->where('trainees.id', $trainee_id);
                $summery['trainee'] = Trainee::find($trainee_id)->name;
            }

            $courses = $courses->groupBy('schedules.id');
            $summery['department'] = Department::find($department_id)->name;
        }

        if($year){

            if($month){
                $date = $year . '-' . $month;
                $summery['month'] = $month;
            }else{
                $date = $year;
            }
            $courses = $courses->where('schedules.start_date','like',"%{$date}%");
            $summery['year'] = $year;
        }
        $courses = $courses->select(['courses.title','schedules.id as schedule_id','schedules.start_date','schedules.end_date','batches.title as batch_title'])->get();

        if($trainee_id){
            foreach ($courses as $key => $course) {
                $totalClasses = Schedule::join('enrolles','schedules.id','=','enrolles.schedule_id')
                                        ->join('trainees','enrolles.trainee_id','=','trainees.id')
                                        ->join('attendances','enrolles.id','=','attendances.enrolle_id')
                                        ->where('schedules.id',$course->schedule_id)
                                        ->where('attendances.status',1)
                                        ->groupBy('attendances.date')
                                        ->select('attendances.*')->get()->count('id');

                $totalAttendance = Schedule::join('enrolles','schedules.id','=','enrolles.schedule_id')
                                        ->join('trainees','enrolles.trainee_id','=','trainees.id')
                                        ->join('attendances','enrolles.id','=','attendances.enrolle_id')
                                        ->where('schedules.id',$course->schedule_id)
                                        ->where('attendances.status',1)
                                        ->where('trainees.id',$trainee_id)
                                        ->where('attendances.attendance_status',0)
                                        ->groupBy('attendances.date')
                                        ->select('attendances.*')
                                        ->count('attendances.id');
                $courses[$key]->absent = $totalAttendance . '/' . $totalClasses;
            }
        }

        return response()->json(['courses'=>$courses,'summery'=>$summery], 200);
    }

    public function trainingExpenseReports()
    {
        $departments = Department::get();
        return view('admin.all-reports.trainin-expense-reports.filter', compact('departments'));
    }
    public function getBatches()
    {
        $batches = Batch::where('status',1)->orderBy('id','desc')->get();
        return response()->json($batches,200);
    }
    public function trainingExpenseReportsPrint()
    {
        return view('admin.all-reports.trainin-expense-reports.print');
    }
    // public function deptTrainees($id)
    // {
    //     $trainees = Trainee::where('department_id', $id)->get();
    //     return response()->json($trainees, 200);
    // }

    public function trainingExpenseReportsData(Request $request)
    {

        // $expenses = Expense::select('expenses.*')
        // ->selectRaw('SUM(expenses.total_expense) as total_expense')
        // ->join('schedules', 'schedules.id', '=', 'expenses.schedule_id')
        // ->join('batches', 'batches.id', '=', 'schedules.batch_id')
        // ->join('courses', 'courses.id', '=', 'batches.course_id')
        // ->join('enrollees', 'enrollees.schedule_id', '=', 'schedules.id')
        // ->join('trainees', 'trainees.id', '=', 'enrollees.trainee_id')
        // ->join('departments', 'departments.id', '=', 'trainees.department_id')
        // ->where('departments.id', '=', 9)
        // ->groupBy('expenses.id')
        // ->get();

        //OR

        // $expenses = DB::table('expenses')
        // ->select('expenses.*', DB::raw('SUM(expenses.total_expense) as total_expense'))
        // ->join('schedules', 'schedules.id', '=', 'expenses.schedule_id')
        // ->join('batches', 'batches.id', '=', 'schedules.batch_id')
        // ->join('courses', 'courses.id', '=', 'batches.course_id')
        // ->join('enrollees', 'enrollees.schedule_id', '=', 'schedules.id')
        // ->join('trainees', 'trainees.id', '=', 'enrollees.trainee_id')
        // ->join('departments', 'departments.id', '=', 'trainees.department_id')
        // ->where('departments.id', '=', 9)
        // ->groupBy('expenses.id')
        // ->get();



        $year = $request->year;
        $month = $request->month;
        $department_id = $request->department_id;
        $trainee_id = $request->trainee_id;
        $batch_id = $request->batch_id;

        $summery = [];
        $query = '';

        if($request->search_by==1){
            $title = "courses.title";
            $goupBy = "courses.id";
            $summery['search_by'] = 'course';
        }else if($request->search_by==2){
            $title = "batches.title";
            $goupBy = "batches.id";
            $summery['search_by'] = 'batch';
        }else{
            $title = "expenses.expense_date";
            $goupBy = "expenses.id";
            $summery['search_by'] = 'schedule';
            $summery['batch'] = Batch::find($batch_id)->title;
        }

        $query .= "SELECT {$title} as title, SUM(expenses.total_expense) as total_expense FROM `expenses` JOIN schedules ON schedules.id = expenses.schedule_id JOIN batches ON batches.id = schedules.batch_id JOIN courses ON courses.id = batches.course_id";

        if($department_id){
            $query .= " JOIN ( SELECT `expenses`.`id` as exp_id FROM expenses JOIN schedules ON schedules.id = expenses.schedule_id JOIN enrolles ON enrolles.schedule_id = schedules.id JOIN trainees ON trainees.id = enrolles.trainee_id JOIN departments ON departments.id = trainees.department_id WHERE departments.id=".$department_id." GROUP BY expenses.id) dept ON dept.exp_id = expenses.id";
            $summery['department'] = Department::find($department_id)->name;
        }
        if($year){

            if($month){
                $date = $year . '-' . $month;
                $summery['month'] = $month;
            }else{
                $date = $year;
            }
            $query .= " WHERE expenses.expense_date like '%{$date}%'";
            $summery['year'] = $year;
        }
        if($request->search_by==3){
            $query .=  ($year? " AND" : " WHERE") . " batches.id='{$batch_id}'";
        }

        $query .= " GROUP BY {$goupBy}";
        $expenses = DB::select($query);

        return response()->json(['expenses'=>$expenses,'summery'=>$summery], 200);
    }
}
