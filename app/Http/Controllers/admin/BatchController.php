<?php

namespace App\Http\Controllers\admin;

use App\Models\Batch;
use App\Models\Course;
use App\Models\Trainer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class BatchController extends Controller
{

    public function index()
    {
        $batches = Batch::with(['course','trainer'])->orderBy('id','desc')->get();
        return view('admin.batches.index', compact('batches'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['batch'] = Batch::find($id);
        }else{
            $data['title'] = 'Create';
        }
        $data['courses'] = Course::where('status',1)->get();
        $data['trainers'] = Trainer::where('status',1)->get();
        return view('admin.batches.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_by_id'] = Auth::guard('admin')->user()->id;
        Batch::create($data);
        return redirect('admin/batches')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, Batch $batch)
    {
        $data = $request->all();
        $data['updated_by_id'] = Auth::guard('admin')->user()->id;
        $batch->update($data);
        return redirect('admin/batches')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy(Batch $batch)
    {
        $batch->delete();
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Deleted Successfully!']);
    }
}
