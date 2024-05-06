<?php
namespace App\Http\Controllers\admin;

use App\Models\Trainee;
use App\Models\Department;
use App\Models\Designation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class TraineeController extends Controller
{
    public function index()
    {
        $trainees = Trainee::with(['department','designation'])->orderBy('id','desc')->get();
        return view('admin.trainees.index', compact('trainees'));
    }


    public function createOrEdit($id=null)
    {
        if($id){
            $data['departments'] = Department::get();
            $data['designations'] = Designation::get();
            $data['trainee'] = Trainee::find($id);
            $data['title'] = 'Edit';
            return view('admin.trainees.create-or-edit',compact('data'));
        }else{
            $data['departments'] = Department::get();
            $data['designations'] = Designation::get();
            $data['title'] = 'Create';
            return view('admin.trainees.create-or-edit',compact('data'));
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_by_id'] = Auth::guard('admin')->user()->id;
        Trainee::create($data);
        return redirect('admin/trainees')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, Trainee $trainee)
    {
        $data = $request->all();
        $data['updated_by_id'] = Auth::guard('admin')->user()->id;
        $trainee->update($data);
        return redirect('admin/trainees')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy(Trainee $trainee)
    {
        $trainee->delete();
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Deleted Successfully!']);
    }
}
