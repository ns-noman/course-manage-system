@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Training Expense Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Training Expense Report</li>
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
                                <h3 class="card-title">Training Expense Report</h3>
                            </div>
                            <form action="{{ url('admin/result/certificate-print') }}" method="POST" enctype="multipart/form-data" id="form-submit">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-2 col-lg">
                                            <label>Year</label>
                                            <select class="form-control" id="year" name="year">
                                                <option value="" selected>Select Year</option>
                                                @php
                                                    $years = range(2018, strftime("%Y", time()));
                                                    rsort($years);
                                                @endphp
                                                @foreach($years as $key => $year)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2 col-lg">
                                            <label>Month</label>
                                            <select disabled class="form-control" id="month" name="month">
                                                <option value="" selected>Select Month</option>
                                                <option value="01">January</option>
                                                <option value="02">February</option>
                                                <option value="03">March</option>
                                                <option value="04">April</option>
                                                <option value="05">May</option>
                                                <option value="06">June</option>
                                                <option value="07">July</option>
                                                <option value="08">August</option>
                                                <option value="09">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2 col-lg">
                                            <label>Department</label>
                                            <select class="form-control" id="department_id" name="department_id">
                                                <option value="" selected>Select Department</option>
                                                @foreach($departments as $key => $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2 col-lg">
                                            <label>Search By</label>
                                            <select class="form-control" id="search_by" name="search_by">
                                                <option value="1">Course</option>
                                                <option value="2">Batch</option>
                                                <option value="3">Schedule</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2 col-lg" id="batch_div_id">
                                            <label>Batch</label>
                                            <select class="form-control" id="batch_id" name="batch_id">
                                                <option value="">Select Batch</option>
                                            </select>
                                        </div>
                                        <div class="form-group pr-0 col-sm-12 col-md-2 col-lg">
                                            <div class="row float-left">
                                                <div class="col-6">
                                                    <button  style="margin-top: 32px;" type="button" class="btn btn-warning mr-0" id="filter">Filter</button>
                                                </div>
                                                <div class="col-6">
                                                    <button type="submit" class="btn btn-primary ml-0" style="margin-top: 32px;">Print</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="bootstrap-data-table-panel">
                                                <div class="table-responsive">
                                                   <table class="table table-striped table-bordered table-centre">
                                                        <thead id="table-head">
                                                            <tr>
                                                                <th>SN</th>
                                                                <th id="title">Course Title</th>
                                                                <th>Total Expense</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="table-data">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

    $('#search_by').change(function() {
        if($(this).val() ==3){
            $('#batch_div_id').attr('hidden',false);
            $('#title').text('Schedule Date');
            $.ajax({
                url: "{{ url('admin/reports/get-batches') }}",
                method: "GET",
                dataType: "JSON",
                success: function(res){
                    let options = '<option value="">Select Batch</option>';
                    res.forEach((element) => {
                        options +=   '<option value="' + element.id + '">' + element.title + '</option>';
                    });
                    $('#batch_id').html(options);
                }
            });
        }else{
            $('#batch_div_id').attr('hidden',true);
        }
        if($(this).val()==1){
            $('#title').text('Course Title');
        }else if($(this).val()==2){
            $('#title').text('Batch Title');
        }
    });

    $('#year').change(function() {
        !$(this).val()? $('#month').val(''): null;
        $('#month').attr('disabled', $(this).val()?false: true);
    });

    $('#filter').click(function() {
        const data = {};
        data.year = $('#year').val();
        data.month = $('#month').val();
        data.department_id = $('#department_id').val();
        data.search_by = $('#search_by').val();
        data.batch_id = $('#batch_id').val();

        if((data.search_by==3 && !$('#batch_id').val())) return alert('Please Select Batch!');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('admin/reports/training-expense-reports-data') }}",
            method: "post",
            dataType: "json",
            data: data,
            success: function(res){

                let td = '';
                let th = '';
                let i = 1;
                let grand_total = 0;

                res.expenses.forEach((element) => {
                    td += '<tr>';
                    td +=   '<td align="center" >'+(i++)+'</td>';
                    td +=   '<td align="center" >' + element.title + '</td>';
                    td +=   '<td align="right" >' + element.total_expense + '/- </td>';
                    td += '</tr>';
                    grand_total += element.total_expense;
                });
                

                td += '<tr class="text-right">';
                td +=   '<th colspan="2">Grand Total:</th>';
                td +=   '<th>' + grand_total + '/- </th>';
                td += '</tr>';

                if(!res.expenses.length) td = 'No Data Found!';
                $('#table-data').html(td);
                $('#total_id').html(res.expenses.length);
            }
        });
    });

    
    $('#form-submit').submit(function(e){
        e.preventDefault();
        const year = $('#year').val();
        const month = $('#month').val();
        const department_id = $('#department_id').val();
        const search_by = $('#search_by').val();
        const batch_id = $('#batch_id').val();

        
        const param = "{{ url('admin/reports/training-expense-reports-print') }}" + "?year=" + year + "&month=" + month + "&department_id=" + department_id + "&search_by=" + search_by + "&batch_id=" + batch_id;
        window.open(param);
    });



</script>
@endsection