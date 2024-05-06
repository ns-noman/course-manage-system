@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Expenses</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Expenses</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ $data['title'] }} Form</h3>
                            </div>
                            <form id="form-submit" action="{{ isset($data['expense']) ? route('expenses.update',$data['expense']->id) : route('expenses.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['expense']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Expense No</label>
                                            <input value="{{ isset($data['expense']) ? $data['expense']->expense_no : null }}" type="text" class="form-control" name="expense_no" placeholder="123456" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Schedule</label>
                                            <select class="form-control" name="schedule_id" required>
                                                <option value="" selected>Select Schedule</option>
                                                @foreach($data['schedules'] as $key => $schedule)
                                                    <option value="{{ $schedule->id }}" @if(isset($data['expense'])){{ $schedule->id == $data['expense']->schedule_id ? 'selected' : null }} @endif>{{ $schedule->batch->title }} - tr: {{ $schedule->batch->trainer->name }} - date: {{ $schedule->start_date }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Expense Date</label>
                                            <input value="{{ isset($data['expense']) ? $data['expense']->expense_date : null }}" type="date" class="form-control" name="expense_date" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <table id="expanse-table" class="table table-striped table-bordered table-centre p-0 m-0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">SN</th>
                                                        <th>Expense Head</th>
                                                        <th>Unit Price</th>
                                                        <th>Quantity</th>
                                                        <th>Total</th>
                                                        <th width="5%">Action</th>
                                                    </tr>
                                                    <tr class="p-0 m-0">
                                                        <th>#</th>
                                                        <th>
                                                            <select class="form-control form-control-sm" id="expense_head_id_temp">
                                                                <option value="" selected>Select Expense Head</option>
                                                                @foreach($data['expenseheads'] as $key => $expensehead)
                                                                    <option value="{{ $expensehead->id }}" expense-head="{{ $expensehead->title }}">{{ $expensehead->title }}</option>
                                                                @endforeach
                                                            </select>
                                                        </th>
                                                        <th><input placeholder="0.00" type="number" class="form-control form-control-sm calculate" id="unit_price_temp"></th>
                                                        <th><input placeholder="0.00" type="number" class="form-control form-control-sm calculate" id="quantity_temp"></th>
                                                        <th><input placeholder="0.00" type="number" class="form-control form-control-sm" id="total_temp" disabled></th>
                                                        <th><button id="btn-add" class="btn btn-sm btn-primary" type="button"><i class="fa-sharp fa-solid fa-plus"></i></button></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-data">
                                                    @if(isset($data['expense']))
                                                        @foreach($data['expense_detals'] as $key => $value)
                                                            <tr>
                                                                <td class="serial">{{ $loop->iteration }}</td>
                                                                <td><input type="hidden" value="{{ $value->expense_head->id  }}" name="expense_head_id[]">{{ $value->expense_head->title  }}</td>
                                                                <td><input type="number" value="{{ $value->unit_price }}" class="form-control form-control-sm calculate" name="unit_price[]" placeholder="0.00"></td>
                                                                <td><input type="number" value="{{ $value->quantity }}" class="form-control form-control-sm calculate" name="quantity[]" placeholder="0.00"></td>
                                                                <td><input type="number" value="{{ $value->unit_price * $value->quantity }}" class="form-control form-control-sm" name="total[]" placeholder="0.00" disabled></td>
                                                                <td><button class="btn btn-sm btn-danger btn-del" type="button"><i class="fa-solid fa-trash btn-del"></i></button></td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-9 col-lg-9">
                                            <label>Note</label>
                                            <input value="{{ isset($data['expense']) ? $data['expense']->note : null }}" type="text" class="form-control" name="note" placeholder="Note">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-3 col-lg-3">
                                            <label>Grand Total</label>
                                            <input value="{{ isset($data['expense']) ? $data['expense']->total_expense : null }}" type="number" class="form-control" name="total_expense" id="total_expense" placeholder="0.00" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        $('#expanse-table').bind('keyup, input', function (e) {
            if($(e.target).is('.calculate')){
                calculate();
            }
        });
        $('#table-data').bind('click', function (e) {
            $(e.target).is('.btn-del') && e.target.closest('tr').remove();
            $( ".serial" ).each(function(index){$(this).html(index+1);});
            calculate();
        });
        $('#btn-add').click(function(){
            let expense_head_id_temp = $('#expense_head_id_temp').val();
            let expense_head = $('#expense_head_id_temp option:selected').attr('expense-head');
            let unit_price_temp = $('#unit_price_temp').val();
            let quantity_temp = $('#quantity_temp').val();
            let total_temp = $('#total_temp').val();
            let td = '';
            if(!(expense_head_id_temp && unit_price_temp && quantity_temp && total_temp)) return alert("Please fill up required field!");

            td += '<tr>';
            td += '<td class="serial"></td>';
            td += '<td><input type="hidden" value="'+expense_head_id_temp+'" name="expense_head_id[]">'+expense_head+'</td>';
            td += '<td><input type="number" value="'+unit_price_temp+'" class="form-control form-control-sm calculate" name="unit_price[]" placeholder="0.00"></td>';
            td += '<td><input type="number" value="'+quantity_temp+'" class="form-control form-control-sm calculate" name="quantity[]" placeholder="0.00"></td>';
            td += '<td><input type="number" value="'+total_temp+'" class="form-control form-control-sm" name="total[]" placeholder="0.00" disabled></td>';
            td += '<td><button class="btn btn-sm btn-danger btn-del" type="button"><i class="fa-solid fa-trash btn-del"></i></button></td>';
            td += '</tr>';
            $('#table-data').append(td);
            $( ".serial" ).each(function(index){$(this).html(index+1);});

            $('#expense_head_id_temp').val('');
            $('#expense_head_id_temp').val('');
            $('#unit_price_temp').val('');
            $('#quantity_temp').val('');
            $('#total_temp').val('');
            calculate();
        });
    });

    $('#form-submit').submit(function(e){
        if(!$('input[name="expense_head_id[]"]').length){
            e.preventDefault();
            alert('Please Insert Expense Details!');
        }
    });
    function calculate(){
        $('#total_temp').val($('#quantity_temp').val() * $('#unit_price_temp').val());
        let expense_head_id = $('input[name="expense_head_id[]"]');
        let grand_total = 0;
        for (let i = 0; i < expense_head_id.length; i++){
            $('input[name="total[]"]')[i].value = ($('input[name="unit_price[]"]')[i].value * $('input[name="quantity[]"]')[i].value);
            grand_total += $('input[name="unit_price[]"]')[i].value * $('input[name="quantity[]"]')[i].value;
        }
        $('#total_expense').val(grand_total);
    }


</script>
@endsection