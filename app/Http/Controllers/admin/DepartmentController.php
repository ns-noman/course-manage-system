<?php

namespace App\Http\Controllers\admin;

use App\Models\Department;
use App\Models\Trainee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('id','desc')->get();
        return view('admin.departments.index', compact('departments'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['department'] = Department::find($id);
        }else{
            $data['title'] = 'Create';
        }
        return view('admin.departments.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_by_id'] = Auth::guard('admin')->user()->id;
        Department::create($data);
        return redirect('admin/departments')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->all();
        $data['updated_by_id'] = Auth::guard('admin')->user()->id;
        $department->update($data);
        return redirect('admin/departments')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy(Department $department)
    {
        $isExits = Trainee::where('department_id',$department->id)->first();
        if(!$isExits)
        {
            $department->delete();
            $message = 'Data Deleted Successfully!';
            $status = 'success';
        }else{
            $message = 'Data Deletion Faild!';
            $status = 'warning';
        }
        return redirect()->back()->with('alert',['messageType'=>$status,'message'=>$message]);
    }
}
