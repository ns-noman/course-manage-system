@php
use Illuminate\Support\Facades\DB;
$privileges = DB::table('privileges')
                ->join('menus', function ($join) {
                    $join->on('privileges.menu_id', '=', 'menus.id');
                })
                ->where('privileges.role_id', Auth::guard('admin')->user()->type)
                ->select('menus.menu_name')
                ->get()->toArray();
$privileges = array_column($privileges,'menu_name');
$basicInfo = App\Models\BasicInfo::first();
@endphp
@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Total Sales',$privileges))
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner"><h3>{{ $data['total_batch'] }}</h3>
                                    <p>Total Batches</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('New Orders',$privileges))
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $data['total_running_batch'] }}</h3>
                                    <p>Running Batches</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Total Orders',$privileges))
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $data['total_trainer'] }}</h3>
                                    <p>Total Trainers</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Pending Orders',$privileges))
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $data['total_trainee'] }}</h3>
                                    <p>Total Trainees</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif
                    {{-- @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Total Products',$privileges))
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{ $data['totalProducts'] }}</h3>

                                    <p>Total Products</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif --}}
                    {{-- @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Active Products',$privileges))
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $data['activeProducts'] }}</h3>
                                    <p>Active Products</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif --}}
                    {{-- @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('Total Customers',$privileges))
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $data['totalCustomers'] }}</h3>
                                    <p>Total Customers</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif --}}
                    {{-- @if(Auth::guard('admin')->user()->type=='superadmin' || in_array('New Customers',$privileges))
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ $data['newCustomers'] }}</h3>
                                    <p>New Customers</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
        </section>
    </div>
@endsection
