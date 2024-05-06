@extends('layouts.admin.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            @include('layouts.admin.flash-message')
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Update Password</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Update Password</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3"></div>
                    <div class="form-group col-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Form</h3>
                            </div>
                            <form id="form" action="{{ url('admin/profile/update-admin-password/'. Auth::guard('admin')->user()->id)}}" method="POST" enctype="multipart/form-data">
                              @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label class="form-label">Current Password</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password" required>
                                            <span id="check-current-password"></span>
                                        </div>
                                        <div class="form-group col-12">
                                            <label class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required>
                                        </div>
                                        <div class="form-group col-12">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                                            <span id="check-confirm-password"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button id="submit" type="submit" disabled class="btn btn-primary">Submit</button>
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
$(document).ready(function(){
    $('#current_password').keyup(function(){
        var current_password = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ url("/admin/profile/check-admin-password") }}',
            type: 'POST',
            data: {
                current_password:current_password,
            },
            success: function(res){
                if(current_password){
                    if(res){
                        $('#check-current-password').html('<font color="green">Correct Password</font>');
                        $('#submit').removeAttr('disabled');
                    }else{
                        $('#check-current-password').html('<font color="red">Incorrect Password</font>');
                        $('#submit').attr('disabled', true);
                    }
                }else{
                    $('#check-current-password').html('');
                    $('#submit').attr('disabled', true);
                }
                }
            })
    });
    $('#confirm_password').keyup(function(){
        var confirm_password = $(this).val();
        var new_password = $('#new_password').val();

        if(confirm_password == new_password){
            $('#check-confirm-password').html('<font color="green">Password Matched</font>');
        }else{
            $('#check-confirm-password').html('<font color="red">Password Mismatch</font>');
        }
    });

    $('form').on('submit',function(e){

        e.preventDefault();

        var new_password = $('#new_password').val();
        var confirm_password = $('#confirm_password').val();
        if(confirm_password!=new_password) return alert("Mismatch Password!");

        var url = $(this).attr('action');
        $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: 'POST',
        data: {
            new_password:new_password,
        },
        success: function(bool){
                if(bool){
                    Swal.fire({
                    position: "middle-center",
                    icon: "success",
                    title: "Your password has been updated!",
                    showConfirmButton: false,
                    timer: 1500
                    });
                    $('#form')[0].reset();
                    $('#check-confirm-password').html('');
                    $('#check-current-password').html('');
                    $('#submit').attr('disabled', true);
                }
            }
        })
    });
});
</script>
@endsection