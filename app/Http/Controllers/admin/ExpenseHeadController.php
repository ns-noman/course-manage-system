<?php

namespace App\Http\Controllers\admin;

use App\Models\ExpenseHead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class ExpenseHeadController extends Controller
{
    public function index()
    {
        $expenseheads = ExpenseHead::orderBy('id','desc')->get();
        return view('admin.expense-heads.index', compact('expenseheads'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['expensehead'] = ExpenseHead::find($id);
            $data['title'] = 'Edit';
        }else{
            $data['title'] = 'Create';
        }
        return view('admin.expense-heads.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['created_by_id'] = Auth::guard('admin')->user()->id;
        ExpenseHead::create($data);
        return redirect('admin/expense/expense-heads')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, ExpenseHead $expenseHead)
    {
        $data = $request->all();
        $data['updated_by_id'] = Auth::guard('admin')->user()->id;
        $expenseHead->update($data);
        return redirect('admin/expense/expense-heads')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy(ExpenseHead $expenseHead)
    {
        $expenseHead->delete();
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Deleted Successfully!']);
    }
}
