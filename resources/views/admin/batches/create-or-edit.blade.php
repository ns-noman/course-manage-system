@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Batches</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Batches</li>
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
                            <form action="{{ isset($data['batch']) ? route('batches.update',$data['batch']->id) : route('batches.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['batch']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Course</label>
                                            <select class="form-control" name="course_id" required>
                                                <option value="" selected>Select Course</option>
                                                @foreach($data['courses'] as $key => $course)
                                                    <option value="{{ $course->id }}" @if(isset($data['batch'])){{ $course->id == $data['batch']->course_id ? 'selected' : null }} @endif>{{ $course->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Trainer</label>
                                            <select class="form-control" name="trainer_id" required>
                                                <option value="" selected>Select Trainer</option>
                                                @foreach($data['trainers'] as $key => $trainer)
                                                    <option value="{{ $trainer->id }}" @if(isset($data['batch'])){{ $trainer->id==$data['batch']->trainer_id ? 'selected' : null }}@endif>{{ $trainer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Batch Title</label>
                                            <input value="{{ isset($data['batch']) ? $data['batch']->title : null }}" type="text" class="form-control" name="title" placeholder="Batch Title" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option {{ isset($data['batch']) ? $data['batch']->status == 1 ? 'selected' : null : null }} value="1">Active</option>
                                                <option {{ isset($data['batch']) ? $data['batch']->status == 0 ? 'selected' : null : null }} value="0">Inactive</option>
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