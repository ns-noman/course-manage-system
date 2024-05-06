<?php

namespace App\Http\Controllers\admin;

use App\Models\Trainer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::orderBy('id','desc')->get();
        return view('admin.trainers.index', compact('trainers'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['trainer'] = Trainer::find($id);
            $data['title'] = 'Edit';
            return view('admin.trainers.create-or-edit',compact('data'));
        }else{
            $data['title'] = 'Create';
            return view('admin.trainers.create-or-edit',compact('data'));
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_by_id'] = Auth::guard('admin')->user()->id;
        Trainer::create($data);
        return redirect('admin/trainers')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, Trainer $trainer)
    {
        $data = $request->all();
        $data['updated_by_id'] = Auth::guard('admin')->user()->id;
        $trainer->update($data);
        return redirect('admin/trainers')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Deleted Successfully!']);
    }
}
