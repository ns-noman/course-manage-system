@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Basic Info</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Basic Info</li>
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
                                <h3 class="card-title">Localization Form</h3>
                            </div>
                            <form action="{{ url('admin/basic-infos-localization/'. $id . '/'. $locale) }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">Title*</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="{{  isset($data) ? $data->title : null }}" placeholder="Title" required>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">Moto*</label>
                                            <textarea class="form-control" id="moto" name="moto" cols="30" rows="3" placeholder="Moto" required>{{  isset($data) ? $data->moto : null }}"</textarea>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">Address*</label>
                                            <textarea class="form-control" id="address" name="address" cols="30" rows="3" placeholder="Address" required>{{  isset($data) ? $data->address : null }}"</textarea>
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
    $(function () {
        $('#description').summernote({
                placeholder: 'Description',
                tabsize: 2,
                height: 100
        });
    });
</script>
@endsection