@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Trainer</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Trainer</li>
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
                            <form action="{{ isset($data['trainer']) ? route('trainers.update',$data['trainer']->id) : route('trainers.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['trainer']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Name</label>
                                            <input value="{{ isset($data['trainer']) ? $data['trainer']->name : null }}" type="text" class="form-control" name="name" placeholder="Name" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Phone</label>
                                            <input value="{{ isset($data['trainer']) ? $data['trainer']->phone : null }}" type="text" class="form-control" name="phone" placeholder="+88018********" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Email</label>
                                            <input value="{{ isset($data['trainer']) ? $data['trainer']->email : null }}" type="email" class="form-control" name="email" placeholder="Email" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-2 col-lg-2">
                                            <label>Gender</label>
                                            <div class="row">
                                                <div class="form-group ml-2">
                                                    <div class="custom-control custom-radio">
                                                        <input {{ isset($data['trainer']) ? $data['trainer']->sex == "Male" ? 'checked' : null : 'checked' }} class="custom-control-input" type="radio" id="customRadio1" name="sex" value="Male">
                                                        <label for="customRadio1" class="custom-control-label">Male</label>
                                                    </div>
                                                </div>
                                                <div class="form-group ml-2">
                                                    <div class="custom-control custom-radio">
                                                        <input {{ isset($data['trainer']) ? $data['trainer']->sex == "Female" ? 'checked' : null : null }} class="custom-control-input" type="radio" id="customRadio2" name="sex" value="Female">
                                                        <label for="customRadio2" class="custom-control-label">Female</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-10 col-lg-10">
                                            <label>Address</label>
                                            <input value="{{ isset($data['trainer'])?$data['trainer']->address : null }}" type="text" class="form-control" name="address" placeholder="Address" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Education Background</label>
                                            <textarea rows="4" class="form-control" name="education" placeholder="Education Background" required>{{ isset($data['trainer']) ? $data['trainer']->education : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Work Experience *</label>
                                            <textarea rows="4" class="form-control" name="work_experience" placeholder="Work Experience" required>{{ isset($data['trainer']) ? $data['trainer']->work_experience : null }}</textarea>
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