@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Schedule</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Schedule</li>
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
                            <form action="{{ isset($data['schedule']) ? route('schedules.update',$data['schedule']->id) : route('schedules.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['schedule']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Batch</label>
                                            <select class="form-control" name="batch_id" required>
                                                <option value="" selected>Select Batch</option>
                                                @foreach($data['batches'] as $key => $batche)
                                                    <option value="{{ $batche->id }}" @if(isset($data['schedule'])){{ $batche->id == $data['schedule']->batch_id ? 'selected' : null }} @endif>{{ $batche->title }} - cr: {{ $batche->course->name }} - tr: {{ $batche->trainer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Days In Week</label>
                                            <select class="select2" name="week_days[]" multiple="multiple" data-placeholder="Select Batch" style="width: 100%;" required>
                                                <option value="0" @if(isset($data['schedule'])){{ in_array(0,explode(',',$data['schedule']->week_days))? 'selected' : null }} @endif>Sunday</option>
                                                <option value="1" @if(isset($data['schedule'])){{ in_array(1,explode(',',$data['schedule']->week_days))? 'selected' : null }} @endif>Monday</option>
                                                <option value="2" @if(isset($data['schedule'])){{ in_array(2,explode(',',$data['schedule']->week_days))? 'selected' : null }} @endif>Tuesday</option>
                                                <option value="3" @if(isset($data['schedule'])){{ in_array(3,explode(',',$data['schedule']->week_days))? 'selected' : null }} @endif>Wednesday</option>
                                                <option value="4" @if(isset($data['schedule'])){{ in_array(4,explode(',',$data['schedule']->week_days))? 'selected' : null }} @endif>Thursday</option>
                                                <option value="5" @if(isset($data['schedule'])){{ in_array(5,explode(',',$data['schedule']->week_days))? 'selected' : null }} @endif>Friday</option>
                                                <option value="6" @if(isset($data['schedule'])){{ in_array(6,explode(',',$data['schedule']->week_days))? 'selected' : null }} @endif>Saturday</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Start Date</label>
                                            <input value="{{ isset($data['schedule']) ? $data['schedule']->start_date : null }}" type="date" class="form-control" name="start_date" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>End Date</label>
                                            <input value="{{ isset($data['schedule']) ? $data['schedule']->end_date : null }}" type="date" class="form-control" name="end_date" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Start Time</label>
                                            <input value="{{ isset($data['schedule']) ? $data['schedule']->start_time : null }}" type="time" class="form-control" name="start_time" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>End Time</label>
                                            <input value="{{ isset($data['schedule']) ? $data['schedule']->end_time : null }}" type="time" class="form-control" name="end_time" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label>Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option {{ isset($data['schedule']) ? $data['schedule']->status == 1 ? 'selected' : null : null }} value="1">Active</option>
                                                <option {{ isset($data['schedule']) ? $data['schedule']->status == 0 ? 'selected' : null : null }} value="0">Inactive</option>
                                            </select>
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