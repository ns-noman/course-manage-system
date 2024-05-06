<?php

namespace App\Http\Controllers\admin;

use App\Models\Designation;
use App\Models\Trainee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class DesignationController extends Controller
{
    public function index()
    {
        $designations = Designation::orderBy('id','desc')->get();
        return view('admin.designations.index', compact('designations'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['designation'] = Designation::find($id);
        }else{
            $data['title'] = 'Create';
        }
        return view('admin.designations.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_by_id'] = Auth::guard('admin')->user()->id;
        Designation::create($data);
        return redirect('admin/designations')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, Designation $designation)
    {
        $data = $request->all();
        $data['updated_by_id'] = Auth::guard('admin')->user()->id;
        $designation->update($data);
        return redirect('admin/designations')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy(Designation $designation)
    {
        $isExits = Trainee::where('designation_id',$designation->id)->first();
        if(!$isExits)
        {
            $designation->delete();
            $message = 'Data Deleted Successfully!';
            $status = 'success';
        }else{
            $message = 'Data Deletion Faild!';
            $status = 'warning';
        }
        return redirect()->back()->with('alert',['messageType'=>$status,'message'=>$message]);
    }
}
