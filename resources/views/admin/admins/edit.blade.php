@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Admin</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Admin</li>
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
                                <h3 class="card-title">Create Form</h3>
                            </div>
                            <form action="{{ route('admins.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf()
                                @method('patch')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Full Name</label>
                                            <input value="{{ $admin->name }}" required type="text" class="form-control" name="name"
                                                placeholder="Full Name">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Role</label>
                                            <select class="form-control" name="type" required>
                                                <option value=''>Select Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}" {{ $admin->type == $role->id ? 'selected' : null }}>{{ $role->role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Email</label>
                                            <input value="{{ $admin->email }}" required type="text" class="form-control" name="email" placeholder="Email">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Contact No.</label>
                                            <input value="{{ $admin->mobile }}" required type="number" class="form-control" name="mobile"
                                                placeholder="01800000000">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Password">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-6 col-lg-6">
                                            <label>Confirm Password</label>
                                            <input type="password" onkeyup="checkPassword()" class="form-control"
                                                id="conpassword" name="conpassword" placeholder="Confirm Password">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label>Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" {{ $admin->status==1? 'selected':'' }}>Active</option>
                                                <option value="0" {{ $admin->status==0? 'selected':'' }}>Inactive</option>
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
    <script type="text/javascript">
        function checkPassword() {
            var x = document.getElementById("password").value;
            var y = document.getElementById("conpassword").value;
            if (x == y) {

                var input = document.getElementById("conpassword");
                input.style.borderColor = 'green';
            } else {
                var input = document.getElementById("conpassword");
                input.style.borderColor = 'red';
            }
        }
    </script>
@endsection
