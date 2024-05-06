@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Attendance</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance</li>
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
                            <form action="{{ isset($data['schedule']) ? route('attendances.update',$data['schedule']->id) : route('attendances.store'); }}" method="POST" enctype="multipart/form-data" 
                                id="form-submit">
                                @csrf()
                                @if(isset($data['schedule']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Batch</label>
                                            <select class="form-control" id="schedule_id" name="schedule_id" required>
                                                <option value="" selected>Select Batch</option>
                                                @foreach($data['schedules'] as $key => $schedule)
                                                    <option value="{{ $schedule->id }}" @if(isset($data['schedule'])){{ $schedule->id == $data['schedule']->batch_id ? 'selected' : null }} @endif>{{ $schedule->batch->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Attendance Date</label>
                                            <input value="{{ isset($data['schedule']) ? $data['schedule']->date : null }}" type="date" class="form-control" name="date" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <div class="bootstrap-data-table-panel">
                                                <div class="table-responsive">
                                                   <table class="table table-striped table-bordered table-centre">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%">SN</th>
                                                                <th width="30%">Trainee Name</th>
                                                                <th width="30%">Comment</th>
                                                                <th width="30%">Attendance <span class="btn btn-sm bg-success m-0" id="select" style="font-size: 11px; padding:2px;">Select All</span></th>
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
                    td += '<td align="center" valign="middle">'+i+'</td>';
                    td += '<td align="left" valign="middle">' + element.trainee.name + ' - ' + element.trainee.id + '</td>';
                    td += '<td align="left" valign="middle"><input class="form-control" name="comment[]" placeholder="Comment"></td>';
                    td += '<td>';
                    td +=   '<div class="col-12">';
                    td +=     '<div class="custom-control custom-switch custom-switch-off-gray custom-switch-on-success child-menu">';
                    td +=       '<input name="attendance_status[]" type="checkbox" class="custom-control-input" id="ats-'+element.id+'" value="'+element.id+'">';
                    td +=       '<label class="custom-control-label" for="ats-'+element.id+'" ></label>';
                    td +=     '</div>';
                    td +=   '</div>';
                    td += '</td>';
                    td += '</tr>';
                    i++;
                });
                if(!data.length) td = 'No Data Found!';

                $('#table-data').html(td);
            }
        });
    });

    $('#select').click(function(){
        let checkboxes = $('input[type="checkbox"]');
        let text = $(this).text();
        if(text=='Select All'){
            $(this).text('Deselect All');
            $(this).removeClass('bg-success');
            $(this).addClass('bg-dark');
            checkboxes.each((index,element)=>{element.checked = true;});
        }else{
            $(this).text('Select All');
            $(this).removeClass('bg-dark');
            $(this).addClass('bg-success');
            checkboxes.each((index,element)=>{element.checked = false;});
        }
    });

    $('#form-submit').submit(function(e){
        let checked = false;
        if(!$('input[type="checkbox"]').length){
            e.preventDefault();
            return alert('Please Select Batch!');
        }
        $('input[type="checkbox"]').each(function(index, element) {
            if(element.checked){
                checked = true;
            }
        });
        if(!checked){
            e.preventDefault();
            return alert('Please select attendance!');
        }

    });
</script>
@endsection