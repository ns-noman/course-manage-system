@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Enroll</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Enroll</li>
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
                            <form id="form-submit" action="{{ isset($data['enroll']) ? route('enrolles.update',$data['enroll']->id) : route('enrolles.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['enroll']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Schedule</label>
                                            <select class="form-control" name="schedule_id" required>
                                                <option value="" selected>Select Schedule</option>
                                                @foreach($data['schedules'] as $key => $schedule)
                                                    <option value="{{ $schedule->id }}" @if(isset($data['enroll'])){{ $schedule->id == $data['enroll']->schedule_id ? 'selected' : null }} @endif>{{ $schedule->batch->title }} - tr: {{ $schedule->batch->trainer->name }} - date: {{ $schedule->start_date }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Enroll Date</label>
                                            <input value="{{ isset($data['enroll']) ? $data['enroll']->enroll_date : null }}" type="date" class="form-control" name="enroll_date" required>
                                        </div>

                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <table id="expanse-table" class="table table-striped table-bordered table-centre p-0 m-0">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">SN</th>
                                                        <th>Trainee</th>
                                                        <th>Note</th>
                                                        <th>Status</th>
                                                        @if(!isset($data['enroll']))
                                                            <th width="5%">Action</th>
                                                        @endif
                                                    </tr>
                                                    @if(!isset($data['enroll']))
                                                        <tr class="p-0 m-0">
                                                            <th>#</th>
                                                            <th>
                                                                <select class="form-control" id="trainee_id_temp">
                                                                    <option value="" selected>Select Trainee</option>
                                                                    @foreach($data['trainees'] as $key => $trainee)
                                                                        <option value="{{ $trainee->id }}" trainee-name="{{ $trainee->name }}">{{ $trainee->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </th>
                                                            <th><input placeholder="Note" type="text" class="form-control calculate" id="note_temp"></th>
                                                            <th>
                                                                <select id="status_temp" class="form-control">
                                                                    <option {{ isset($data['enroll']) ? $data['enroll']->status == 0 ? 'selected' : null : null }} value="0">Pending</option>
                                                                    <option {{ isset($data['enroll']) ? $data['enroll']->status == 1 ? 'selected' : null : null }} value="1">Approved</option>
                                                                </select>
                                                            </th>
                                                            <th><button id="btn-add" class="btn btn-sm btn-primary" type="button"><i class="fa-sharp fa-solid fa-plus"></i></button></th>
                                                        </tr>
                                                    @endif
                                                </thead>
                                                <tbody id="table-data">
                                                    @if(isset($data['enroll']))
                                                        <tr>
                                                            <td class="serial"></td>
                                                            <td><input type="hidden" value="{{ $data['enroll']->trainee_id }}" name="trainee_id">{{ $data['enroll']->trainee->name }}</td>
                                                            <td><input type="text" value="{{ $data['enroll']->note }}" class="form-control" name="note" placeholder="Note"></td>
                                                            <td>
                                                                <select name="status" class="form-control" {{ $data['enroll']->status != 1? : 'disabled' }}>
                                                                    <option value="0" {{ isset($data['enroll']) ? $data['enroll']->status == 0 ? 'selected' : null : null }} >Pending</option>
                                                                    <option value="1" {{ isset($data['enroll']) ? $data['enroll']->status == 1 ? 'selected' : null : null }} >Approved</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
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
        $('#table-data').bind('click', function (e) {
            $(e.target).is('.btn-del') && e.target.closest('tr').remove();
            $( ".serial" ).each(function(index){$(this).html(index+1);});
        });
        $('#btn-add').click(function(){
            let trainee_id_temp = $('#trainee_id_temp').val();
            let trainee_name = $('#trainee_id_temp option:selected').attr('trainee-name');
            let note_temp = $('#note_temp').val();
            let status_temp = $('#status_temp').val();
            console.log(status_temp);
            let td = '';
            if(!(trainee_id_temp && status_temp)) return alert("Please fill up required field!");

            td += '<tr>';
            td += '<td class="serial"></td>';
            td += '<td><input type="hidden" value="'+trainee_id_temp+'" name="trainee_id[]">'+trainee_name+'</td>';
            td += '<td><input type="text" value="'+note_temp+'" class="form-control" name="note[]" placeholder="Note"></td>';
            td += '<td>';
            td +=   '<select name="status[]" class="form-control">';
            td +=     '<option '+(status_temp==0? "selected" : null)+' value="0">Pending</option>';
            td +=     '<option '+(status_temp==1? "selected" : null)+' value="1">Approved</option>';
            td +=   '</select>';
            td += '</td>';
            td += '<td><button class="btn btn-sm btn-danger btn-del" type="button"><i class="fa-solid fa-trash btn-del"></i></button></td>';
            td += '</tr>';
            $('#table-data').append(td);
            $( ".serial" ).each(function(index){$(this).html(index+1);});

            $('#trainee_id_temp').val('');
            $('#note_temp').val('');
            // $('#status_temp').val('');
        });
    });

    $('#form-submit').submit(function(e){
        if(!(($('input[name="trainee_id[]"]').length) || $('input[name="trainee_id"]').val())){
            e.preventDefault();
            return alert('Please Add trainee!');
        }
    });

</script>
@endsection