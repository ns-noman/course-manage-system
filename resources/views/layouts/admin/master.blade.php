@php
    $basicInfo = App\Models\BasicInfo::first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $basicInfo->title }}</title>
    @include('layouts.admin.links')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('public/uploads/basic-info/'. $basicInfo->favIcon) }}" alt="{{ $basicInfo->title }}Logo" height="32" width="32">
        </div> --}}
        @include('layouts.admin.header')
        @include('layouts.admin.sidebar')
            @yield('content')
        @include('layouts.admin.footer')
    </div>
    @include('layouts.admin.scripts')
</body>
@yield('script')
</html>
