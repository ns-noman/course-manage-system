@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Course</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Course</li>
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
                            <form action="{{ isset($data['course']) ? route('courses.update',$data['course']->id) : route('courses.store'); }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @if(isset($data['course']))
                                    @method('put')
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Course Title</label>
                                            <input value="{{ isset($data['course']) ? $data['course']->title : null }}" type="text" class="form-control" name="title" placeholder="Course Title" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Total Duration(hr)</label>
                                            <input value="{{ isset($data['course']) ? $data['course']->total_duration : null }}" type="number" class="form-control" name="total_duration" placeholder="0.00" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-4 col-lg-4">
                                            <label>Per Class Duration(hr)</label>
                                            <input value="{{ isset($data['course']) ? $data['course']->per_class_duration : null }}" type="number" class="form-control" name="per_class_duration" placeholder="0.00" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Total Class</label>
                                            <input value="{{ isset($data['course']) ? $data['course']->total_class : null }}" type="number" class="form-control" name="total_class" placeholder="0.00" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Class Per Week</label>
                                            <input value="{{ isset($data['course']) ? $data['course']->class_per_week : null }}" type="number" class="form-control" name="class_per_week" placeholder="0.00" required>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">Course Objective*</label>
                                            <textarea required id="objective" name="objective" required>{{ isset($data['course']) ? $data['course']->objective : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">Course Methodology*</label>
                                            <textarea required id="methodology" name="methodology" required>{{ isset($data['course']) ? $data['course']->methodology : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">Course Benifits*</label>
                                            <textarea required id="benifits" name="benifits" required>{{ isset($data['course']) ? $data['course']->benifits : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">Syllabus*</label>
                                            <textarea required id="short_syllabus" name="short_syllabus" required>{{ isset($data['course']) ? $data['course']->short_syllabus : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">Description*</label>
                                            <textarea required id="description" name="description" required>{{ isset($data['course']) ? $data['course']->description : null }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label>Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option {{ isset($data['course']) ? $data['course']->status == 1 ? 'selected' : null : null }} value="1">Active</option>
                                                <option {{ isset($data['course']) ? $data['course']->status == 0 ? 'selected' : null : null }} value="0">Inactive</option>
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
@section('script')
<script>
    $('#objective').summernote({
        placeholder: 'Course Objective',
        tabsize: 2,
        height: 100
    });
    $('#methodology').summernote({
        placeholder: 'Course Methodology',
        tabsize: 2,
        height: 100
    });
    $('#benifits').summernote({
        placeholder: 'Course Benifts',
        tabsize: 2,
        height: 100
    });
    $('#short_syllabus').summernote({
        placeholder: 'Syllabus',
        tabsize: 2,
        height: 100
    });
    $('#description').summernote({
        placeholder: 'Description',
        tabsize: 2,
        height: 100
    });
</script>
@endsection