<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta name="csrf-token" value="{{ csrf_token() }}"/>
    <meta name="keywords" content="au theme template">
    <title>{{env('MIX_APP_NAME')}}</title>

 
    <link href="{{ asset(url('vendor/fontawesome-free/css/all.min.css')) }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset(url('css/sb-admin-2.min.css')) }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" type="text/css" rel="stylesheet"/>
</head>

<body class="app bg-gradient-primary-mode" id="page-top">
@if (Auth::check())
    @php
    $user_auth_data = [
        'isLoggedin' => true,
        'user' =>  Auth::user(),
    ];
    @endphp
@else
    @php
    $user_auth_data = [
        'isLoggedin' => false
    ];
    @endphp
@endif

<script>
    window.Laravel = JSON.parse(atob('{{ base64_encode(json_encode($user_auth_data)) }}'));
</script>
<script src="{{ asset(url('vendor/jquery/jquery.min.js')) }}"></script>
<script src="{{ asset(url('vendor/bootstrap/js/bootstrap.bundle.min.js')) }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset(url('vendor/jquery-easing/jquery.easing.min.js')) }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset(url('js/sb-admin-2.min.js')) }}"></script>

<script src="{{ mix('js/app.js') }}" type="text/javascript"></script>
<!-- <script src="{{ asset(url('assets/js/main.js')) }}"></script> -->
</body>
</html>