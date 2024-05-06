@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Training Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Training Report</li>
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
                                <h3 class="card-title">Training Report</h3>
                            </div>
                            <form action="{{ url('admin/result/certificate-print') }}" method="POST" enctype="multipart/form-data" id="form-submit">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-2 col-lg-2">
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
                                        <div class="form-group col-sm-12 col-md-2 col-lg-2">
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
                                        <div class="form-group col-sm-12 col-md-3 col-lg-3">
                                            <label>Department</label>
                                            <select class="form-control" id="department_id" name="department_id">
                                                <option value="" selected>Select Department</option>
                                                @foreach($departments as $key => $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-3 col-lg-3">
                                            <label>Trainee</label>
                                            <select disabled class="form-control" id="trainee_id" name="trainee_id">
                                                <option value="" selected>Select Trainee</option>
                                            </select>
                                        </div>
                                        <div class="form-group pr-0 col-sm-12 col-md-2 col-lg-2">
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
                                                        <thead>
                                                            <tr>
                                                                <th width="80%">Total Training: </th>
                                                                <th id="total_id" style="text-align: right;">0</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                   <table class="table table-striped table-bordered table-centre">
                                                        <thead>
                                                            <tr>
                                                                <th >SN</th>
                                                                <th >Course Name</th>
                                                                <th >From Date</th>
                                                                <th >To Date</th>
                                                                <th id="absent" hidden>Absent/Class</th>
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

    $('#department_id').change(function() {

        !$(this).val()? $('#trainee_id').val(''): null;
        $('#trainee_id').attr('disabled', $(this).val()?false: true);

        $.ajax({
            url: "{{ url('admin/reports/dept-trainees') }}/"+$(this).val(),
            method: "GET",
            dataType: "json",
            success: function(data){
                let option = '<option value="">Select Trainee</option>';
                data.forEach((element) => {
                    option += '<option value="' + element.id + '">' + element.name + '</option>';
                });
                if(!data.length) alert('No trainee found!');
                $('#trainee_id').html(option);
            }
        });
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
        data.trainee_id = $('#trainee_id').val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('admin/reports/training-reports-data') }}",
            method: "post",
            dataType: "json",
            data: data,
            success: function(res){
                let td = '';
                let i = 1;
                res.courses.forEach((element) => {
                    td += '<tr>';
                    td +=   '<td align="center" valign="middle">'+(i++)+'</td>';
                    td +=   '<td align="center" valign="middle">' + element.title + ' {' + element.batch_title + '}' + '</td>';
                    td +=   '<td align="center" valign="middle">' + element.start_date + '</td>';
                    td +=   '<td align="center" valign="middle">' + element.end_date + '</td>';
                    if(data.trainee_id){
                        td +=   '<td align="center" valign="middle">' + element.absent + '</td>';
                    }
                    td += '</tr>';
                });
                    
                            
                $('#absent').attr('hidden',(data.trainee_id? false : true));

                if(!res.courses.length) td = 'No Data Found!';
                $('#table-data').html(td);
                $('#total_id').html(res.courses.length);
            }
        });
    });

    
    $('#form-submit').submit(function(e){
        e.preventDefault();
        let year = $('#year').val();
        let month = $('#month').val();
        let department_id = $('#department_id').val();
        let trainee_id = $('#trainee_id').val();
        
        const param = "{{ url('admin/reports/training-reports-print') }}" + "?year=" + year + "&month=" + month + "&department_id=" +department_id+ "&trainee_id=" +trainee_id;
        window.open(param);
    });



</script>
@endsection