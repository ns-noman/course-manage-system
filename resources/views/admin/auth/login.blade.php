@php
    $basicInfo = App\Models\BasicInfo::first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $basicInfo->title }}</title>
    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/uploads/basic-info/'. $basicInfo->favIcon) }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/admin-assets') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('public/admin-assets') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/admin-assets') }}/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <p><b>Admin </b>Login</p>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ $basicInfo->title }}</p>
                <form method="POST" action="{{ url('admin/login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="email" type="text" placeholder="Username or Email" class="form-control"
                            name="email" :value="old('email')" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" id="password"
                            type="password" name="password" required autocomplete="current-password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>
                <p class="mb-1">
                </p>
                <p class="mb-0">
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('public/admin-assets') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('public/admin-assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('public/admin-assets') }}/dist/js/adminlte.min.js"></script>
</body>

</html>
