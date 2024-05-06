@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
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
                    @if($basicInfo)
                    <section class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="bootstrap-data-table-panel">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>Title</th>
                                                    <td>{{ $basicInfo->title }}</td>
                                                </tr>
                                                <tr hidden>
                                                    <th>Moto</th>
                                                    <td>{{ $basicInfo->moto }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone-1</th>
                                                    <td>{{ $basicInfo->phone1 }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone-2</th>
                                                    <td>{{ $basicInfo->phone2 }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td>{{ $basicInfo->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td>{{ $basicInfo->address }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Logo</th>
                                                    <td>
                                                        @if ($basicInfo->logo)
                                                            <img src="{{ asset('public/uploads/basic-info/' . $basicInfo->logo) }}" height="29px" width="141px">
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Fav Icon</th>
                                                    <td>
                                                        @if ($basicInfo->logo)
                                                            <img src="{{ asset('public/uploads/basic-info/' . $basicInfo->favIcon) }}" height="32px" width="32px">
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr hidden>
                                                    <th>Currency Code</th>
                                                    <td>{{ $basicInfo->currency_code }}</td>
                                                </tr>
                                                <tr hidden>
                                                    <th>Currency Symbol</th>
                                                    <td>{{ $basicInfo->currency_symbol }}</td>
                                                </tr>
                                                <tr hidden>
                                                    <th>Accept Payment Type</th>
                                                    <td>
                                                        @if ($basicInfo->logo)
                                                            <img src="{{ asset('public/uploads/basic-info/' . $basicInfo->acceptPaymentType) }}" height="39px" width="267px">
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Copy Right Text</th>
                                                    <td>{!! $basicInfo->copyRightName !!}</td>
                                                </tr>
                                                <tr hidden>
                                                    <th>Copy Right Link</th>
                                                    <td>{{ $basicInfo->copyRightLink }}</td>
                                                </tr>
                                                <tr hidden>
                                                    <th>Map Link</th>
                                                    <td>{!! $basicInfo->mapLink !!}</td>
                                                </tr>
                                                <tr hidden>
                                                    <th>Facebook</th>
                                                    <td>{{ $basicInfo->facebook }}</td>
                                                </tr>
                                                <tr hidden>
                                                    <th>Instagram</th>
                                                    <td>{{ $basicInfo->instagram }}</td>
                                                </tr>
                                                <tr hidden>
                                                    <th>Twitter</th>
                                                    <td>{{ $basicInfo->twitter }}</td>
                                                </tr>
                                                <tr hidden>
                                                    <th>Pinterest</th>
                                                    <td>{{ $basicInfo->pinterest }}</td>
                                                </tr>
                                                <tr hidden>
                                                    <th>LinkedIn</th>
                                                    <td>{{ $basicInfo->linkedIn }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer" >
                                <a href="{{ route('basic-infos.edit', $basicInfo->id) }}"
                                    class="btn btn-primary">Edit</a>
                                    {{-- <td>
                                        @foreach (Config::get('languages') as $lang => $language)
                                            <a href="{{ url('admin/basic-infos-localization/'. $basicInfo->id . '/'. $lang) }}">
                                                @if($basicInfo->translate($lang))
                                                        <i class="fa-solid fa-check text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                @endif
                                                {{ $lang }} &nbsp;
                                            </a>
                                        @endforeach
                                    </td> --}}
                            </div>
                        </div>
                    </section>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection