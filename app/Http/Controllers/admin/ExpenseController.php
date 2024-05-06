<?php

namespace App\Http\Controllers\admin;

use App\Models\Expense;
use App\Models\ExpenseDetails;
use App\Models\ExpenseHead;
use App\Models\Schedule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with(['schedule', 'admin'])->orderBy('id','desc')->get();
        return view('admin.expenses.index', compact('expenses'));
    }

    public function createOrEdit($id=null)
    {
        if($id){
            $data['title'] = 'Edit';
            $data['expense'] = Expense::find($id);
            $data['expense_detals'] = ExpenseDetails::with('expense_head')->where('expense_id', $id)->get();
        }else{
            $data['title'] = 'Create';  
        }
        $data['schedules'] = Schedule::with('batch')->where('status',1)->get();
        $data['expenseheads'] = ExpenseHead::where('status',1)->get();
        return view('admin.expenses.create-or-edit',compact('data'));
    }

    public function store(Request $request)
    {
        $total_expense = 0;
        for($i = 0; $i < count($request->expense_head_id); $i++) $total_expense += $request->unit_price[$i] * $request->quantity[$i];

        $expense =
        [
            'expense_no'=> $request->expense_no,
            'schedule_id'=> $request->schedule_id,
            'expense_date'=> $request->expense_date,
            'total_expense'=> $total_expense,
            'note'=> $request->note,
            'created_by_id'=> Auth::guard('admin')->user()->id,
        ];
        $expense = Expense::create($expense);

        for($i = 0; $i < count($request->expense_head_id); $i++) {
           $expenseDetails = 
            [
                'expense_id'=> $expense->id,
                'expense_head_id'=> $request->expense_head_id[$i],
                'unit_price'=> $request->unit_price[$i],
                'quantity'=> $request->quantity[$i],
            ];
            ExpenseDetails::create($expenseDetails);
        }
        return redirect('admin/expense/expenses')->with('alert',['messageType'=>'success','message'=>'Data Inserted Successfully!']);
    }

    public function update(Request $request, Expense $expense)
    {
        $total_expense = 0;
        for($i = 0; $i < count($request->expense_head_id); $i++) $total_expense += $request->unit_price[$i] * $request->quantity[$i];
        $data =
        [
            'expense_no'=> $request->expense_no,
            'schedule_id'=> $request->schedule_id,
            'expense_date'=> $request->expense_date,
            'total_expense'=> $total_expense,
            'note'=> $request->note,
            'updated_by_id'=> Auth::guard('admin')->user()->id,
        ];
        $expense->update($data);
        ExpenseDetails::where('expense_id',$expense->id)->delete();
        for($i = 0; $i < count($request->expense_head_id); $i++)
        {
           $expenseDetails = 
            [
                'expense_id'=> $expense->id,
                'expense_head_id'=> $request->expense_head_id[$i],
                'unit_price'=> $request->unit_price[$i],
                'quantity'=> $request->quantity[$i],
            ];
            ExpenseDetails::create($expenseDetails);
        }
        return redirect('admin/expense/expenses')->with('alert',['messageType'=>'success','message'=>'Data Updated Successfully!']);
    }

    public function destroy(Expense $expense)
    {
        ExpenseDetails::where('expense_id',$expense->id)->delete();
        $expense->delete();
        return redirect()->back()->with('alert',['messageType'=>'success','message'=>'Data Deleted Successfully!']);
    }
}
