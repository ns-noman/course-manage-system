@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Certificates</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Certificates</li>
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
                                <h3 class="card-title">Certificate Print</h3>
                            </div>
                            <form action="{{ url('admin/result/certificate-print') }}" method="POST" enctype="multipart/form-data" id="form-submit">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Batch</label>
                                            <select class="form-control" id="schedule_id" name="schedule_id" required>
                                                <option value="" selected>Select Batch</option>
                                                @foreach($schedules as $key => $schedule)
                                                    <option value="{{ $schedule->id }}">{{ $schedule->batch->title }} <strong>[{{ $schedule->batch->course->title }}]</strong> SD: [{{ $schedule->start_date }}]</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Trainee</label>
                                            <select class="form-control" id="trainee_id" name="trainee_id" required>
                                                <option value="" selected>Select Trainee</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Certificate Type</label>
                                            <select class="form-control" id="certificate_type" name="certificate_type" required>
                                                <option value="" selected>Select Certificate Types</option>
                                                <option value="1">Participating</option>
                                                <option value="2">Completing</option>
                                                <option value="3">Result in comments</option>
                                                <option value="4">Result with marks</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Print Type</label>
                                            <select class="form-control" id="print_type" name="print_type" required>
                                                <option value="" selected>Select Certificate Types</option>
                                                <option value="1">On pad</option>
                                                <option value="2">Predesign template</option>
                                                <option value="3">Blank paper</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Print</button>
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
                let option = '<option value="">Select Trainee</option>';
                data.forEach((element) => {
                    option += '<option value="' + element.trainee.id + '">' + element.trainee.name + '</option>';
                });
                if(!data.length) alert('No trainee found!');
                $('#trainee_id').html(option);
            }
        });
    });

    $('#form-submit').submit(function(e){
        e.preventDefault();
        const schedule_id = $('#schedule_id').val();
        const trainee_id = $('#trainee_id').val();
        const certificate_type = $('#certificate_type').val();
        const print_type = $('#print_type').val();
        const param = "{{ url('admin/result/certificate-print') }}" + "?&schedule_id=" + schedule_id + "&trainee_id=" + trainee_id + "&certificate_type=" +certificate_type+ "&print_type=" +print_type;
        window.open(param);
    });

    
</script>
@endsection