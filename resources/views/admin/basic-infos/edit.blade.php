@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="form-group col-sm-6">
                        <h1 class="m-0">Basic Info</h1>
                    </div>
                    <div class="form-group col-sm-6">
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
                    <div class="form-group col-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Form</h3>
                            </div>
                            <form action="{{ route('basic-infos.update', $basicInfo->id)}}" method="POST" enctype="multipart/form-data">
                              @csrf
                              @method('PATCH')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-sm-6 col-md-3 col-lg-3">
                                            <label class="form-label">Title*</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="{{ $basicInfo->title }}" placeholder="Title" required>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-3 col-lg-3">
                                            <label class="form-label">Phone-1*</label>
                                            <input type="text" class="form-control" id="phone1" name="phone1"
                                                value="{{ $basicInfo->phone1 }}" placeholder="+88018XXXXXXXX" required>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-3 col-lg-3">
                                            <label class="form-label">Phone-2*</label>
                                            <input type="text" class="form-control" id="phone2" name="phone2"
                                                value="{{ $basicInfo->phone2 }}" placeholder="+88018XXXXXXXX">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-3 col-lg-3">
                                            <label class="form-label">Email*</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                value="{{ $basicInfo->email }}"placeholder="Email" required>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-3 col-lg-3" hidden>
                                            <label class="form-label">Currency*</label>
                                            <select class="form-control" id="currency_symbol_id" name="currency_symbol_id">
                                                <option value=''>Select Currency</option>
                                                @foreach ($currencys as $currency)
                                                    <option {{ $basicInfo->currency_code == $currency->code ? 'selected':'' }} value="{{ $currency->id }}">{{ $currency->country }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6" hidden>
                                            <label class="form-label">Moto*</label>
                                            <textarea class="form-control" id="moto" name="moto" cols="30" rows="3" placeholder="Moto" required>{{ $basicInfo->moto }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                            <label class="form-label">Address*</label>
                                            <textarea class="form-control" id="address" name="address" cols="30" rows="1" placeholder="Address" required>{{ $basicInfo->address }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-4 col-md-3 col-lg-3">
                                            <label for="logo" class="form-label">Logo (141 X 29)</label>
                                            <input type="file" name="logo" class="form-control">
                                        </div>
                                        <div class="form-group col-sm-4 col-md-3 col-lg-3">
                                            <label for="favIcon" class="form-label">Fab Icon (32 X 32)</label>
                                            <input type="file" name="favIcon" class="form-control">
                                        </div>
                                        <div class="form-group col-sm-4 col-md-3 col-lg-3" hidden>
                                            <label for="acceptPaymentType" class="form-label">Accept Payment Types (267 X 39)</label>
                                            <input type="file" name="acceptPaymentType" class="form-control">
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12">
                                            <label class="form-label">Copy Right Text*</label>
                                            <textarea id="copyRightName" name="copyRightName" required>{{ $basicInfo->copyRightName }}</textarea>
                                        </div>
                                        <div class="form-group col-sm-12 col-md-12 col-lg-12" hidden>
                                            <label for="inputAddress" class="form-label">Copy Right Link*</label>
                                            <input type="text" class="form-control" id="copyRightLink" name="copyRightLink"
                                                value="{{ $basicInfo->copyRightLink }}" placeholder="Copy Right Link">
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4" hidden>
                                            <label for="mapLink" class="form-label">Location Map Link</label>
                                            <input type="text" class="form-control" id="mapLink" name="mapLink"
                                                value="{{ $basicInfo->mapLink }}" placeholder="Location Map Link">
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4" hidden>
                                            <label for="facebook" class="form-label">Facebook Link</label>
                                            <input type="text" class="form-control" id="facebook" name="facebook"
                                                value="{{ $basicInfo->facebook }}" placeholder="Facebook Link">
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4" hidden>
                                            <label for="instagram" class="form-label">Instagram Link</label>
                                            <input type="text" class="form-control" id="instagram" name="instagram"
                                                value="{{ $basicInfo->instagram }}" placeholder="Instagram Link">
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4" hidden>
                                            <label for="twitter" class="form-label">Twitter Link</label>
                                            <input type="text" class="form-control" id="twitter" name="twitter"
                                                value="{{ $basicInfo->twitter }}" placeholder="Twitter Link">
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4" hidden>
                                            <label for="pinterest" class="form-label">Pinterest Link</label>
                                            <input type="text" class="form-control" id="pinterest" name="pinterest"
                                                value="{{ $basicInfo->pinterest }}" placeholder="Pinterest Link">
                                        </div>
                                        <div class="form-group col-sm-4 col-md-4 col-lg-4" hidden>
                                            <label for="linkedIn" class="form-label">LinkedIn Link</label>
                                            <input type="text" class="form-control" id="linkedIn" name="linkedIn"
                                                value="{{ $basicInfo->linkedIn }}" placeholder="LinkedIn Link">
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
    $('#copyRightName').summernote({
        placeholder: 'Copy Right Text',
        tabsize: 2,
        height: 100
    });
</script>
@endsection