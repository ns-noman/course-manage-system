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
                <section class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-primary p-1">
                            <h3 class="card-title">
                                <a href="{{ route('admins.create') }}"class="btn btn-light shadow rounded m-0"><i
                                        class="fas fa-plus"></i>
                                    <span>Add New</span></i></a>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="bootstrap-data-table-panel">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-striped table-bordered table-centre">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($admins as $admin)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $admin->name }}</td>
                                                    <td>{{ $admin->role->role }}</td>
                                                    <td>{{ $admin->mobile }}</td>
                                                    <td>{{ $admin->email }}</td>
                                                    <td>
                                                        <img width="50px" height="50px" src="{{ $admin->image? asset('public/uploads/admin/'.$admin->image): asset('public/frontend-assets/img/user.png') }}">
                                                    </td>
                                                    <td>{{ $admin->status==1? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a href="{{ route('admins.edit', $admin->id) }}"
                                                                class="btn btn-info">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <form class="delete" action="{{ route('admins.destroy', $admin->id) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>SN</th>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Image</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>
@endsection
