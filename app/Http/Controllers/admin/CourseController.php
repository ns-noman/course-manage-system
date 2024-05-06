<?php

namespace App\Http\Controllers\admin;


use App\Models\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('id','desc')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['course'] = Course::find($id);
            $data['title'] = 'Edit';
        }else{
            $data['title'] = 'Create';
        }
        return view('admin.courses.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_by_id'] = Auth::guard('admin')->user()->id;
        Course::create($data);
        return redirect('admin/courses')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->all();
        $data['updated_by_id'] = Auth::guard('admin')->user()->id;
        $course->update($data);
        return redirect('admin/courses')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Deleted Successfully!']);
    }
}
