@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Result Entry</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Result Entry</li>
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
                            <form action="{{ isset($data['evaluation']) ? route('result-entries.update',$data['evaluation']->id) : route('result-entries.store'); }}" method="POST" enctype="multipart/form-data" 
                                id="form-submit">
                                @csrf()
                                @if(isset($data['evaluation']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Batch</label>
                                            <select class="form-control" id="schedule_id" name="schedule_id" required {{ isset($data['evaluation'])?'disabled' : null }}>
                                                <option value="">Select Batch</option>
                                                @foreach($data['schedules'] as $key => $schedule)
                                                    <option value="{{ $schedule->id }}" @if(isset($data['evaluation'])){{ $schedule->id == $data['evaluation']->schedule_id ? 'selected' : null }} @endif>{{ $schedule->batch->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Total Marks</label>
                                            <input value="{{ isset($data['evaluation']) ? $data['evaluation']->total_marks : null }}" type="number" class="form-control" name="total_marks" placeholder="0.00" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Evaluation Date</label>
                                            <input value="{{ isset($data['evaluation']) ? $data['evaluation']->evaluation_date : null }}" type="date" class="form-control" name="evaluation_date" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <div class="bootstrap-data-table-panel">
                                                <div class="table-responsive">
                                                   <table class="table table-striped table-bordered table-centre">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%">SN</th>
                                                                <th width="30%">Trainee Name</th>
                                                                <th width="30%">Obtain Marks</th>
                                                                <th width="30%">Remark</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="table-data">
                                                            @if(isset($data['evaluation']))
                                                                @foreach($data['evaluation']->evaluation_details as $key => $value)
                                                                    <tr>
                                                                        <td align="center" valign="middle">{{ $loop->iteration }}</td>
                                                                        <td align="left" valign="middle">{{ $value->trainee }} - {{ $value->trainee_id }} </td>
                                                                        <td align="left" valign="middle">
                                                                            <input value="{{ $value->obtain_marks }}" type="number" class="form-control" name="obtain_marks[]" placeholder="0.00" required>
                                                                            <input value="{{ $value->id }}" type="hidden" name="evaluation_details_id[]">
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control" id="remarks" name="remarks[]" required>
                                                                                <option value="">Select Remark</option>
                                                                                <option {{ $value->remarks=='Excellent'?'selected':null; }} value="Excellent">Excellent</option>
                                                                                <option {{ $value->remarks=='Good'?'selected':null; }} value="Good">Good</option>
                                                                                <option {{ $value->remarks=='Fair'?'selected':null; }} value="Fair">Fair</option>
                                                                                <option {{ $value->remarks=='Poor'?'selected':null; }} value="Poor">Poor</option>
                                                                                <option {{ $value->remarks=='Very Bad'?'selected':null; }} value="Very Bad">Very Bad</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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

    $('#schedule_id').change(function() {
        $.ajax({
            url: "{{ url('admin/get-schedule-trainee') }}/"+$(this).val(),
            method: "GET",
            dataType: "json",
            success: function(data){
                let td = '';
                let i = 1;
                data.forEach((element) => {
                    td += '<tr>';
                    td +=   '<td align="center" valign="middle">'+i+'</td>';
                    td +=   '<td align="left" valign="middle">' + element.trainee.name + ' - ' + element.trainee.id + '</td>';
                    td +=   '<td align="left" valign="middle"><input type="number" class="form-control" name="obtain_marks[]" placeholder="0.00" required></td>';
                    td +=   '<td>';
                    td +=       '<select class="form-control" id="remarks" name="remarks[]" required>';
                    td +=           '<option value="">Select Remark</option>';
                    td +=           '<option value="Excellent">Excellent</option>';
                    td +=           '<option value="Good">Good</option>';
                    td +=           '<option value="Fair">Fair</option>';
                    td +=           '<option value="Poor">Poor</option>';
                    td +=           '<option value="Very Bad">Very Bad</option>';
                    td +=       '</select>';
                    td +=   '</td>';
                    td += '</tr>';
                    i++;
                });
                if(!data.length) td = 'No Data Found!';

                $('#table-data').html(td);
            }
        });
    });

    $('#form-submit').submit(function(e){
        if(!$('input[name="obtain_marks[]"]').length){
            e.preventDefault();
            alert('Please Select Batch!');
        }
    });
</script>
@endsection