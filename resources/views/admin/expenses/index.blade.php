@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Expenses</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Expenses</li>
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
                                    <a href="{{ url('admin/expense/expenses-create-or-edit') }}"class="btn btn-light shadow rounded m-0"><i
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
                                                    <th>Schedule</th>
                                                    <th>Expense No</th>
                                                    <th>Date</th>
                                                    <th>Total Expense</th>
                                                    <th>Note</th>
                                                    <th>Created By</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($expenses as $expense)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $expense->schedule->batch->title }} - {{ $expense->schedule->start_date }}</td>
                                                        <td>{{ $expense->expense_no }}</td>
                                                        <td>{{ $expense->expense_date }}</td>
                                                        <td>{{ $expense->total_expense }}</td>
                                                        <td>{{ $expense->note }}</td>
                                                        <td>{{ $expense->admin->name }}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                {{-- <a href="{{ url('admin/expense/expenses-create-or-edit/'.$expense->id) }}" class="btn btn-warning">
                                                                    <i class="fa-solid fa-eye" style="color: white"></i>
                                                                </a> --}}
                                                                <a href="{{ url('admin/expense/expenses-create-or-edit/'.$expense->id) }}" class="btn btn-info">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <form class="delete" action="{{ route('expenses.destroy', $expense->id) }}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
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
