<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>H1D023011 | @yield('title', 'Login / Register')</title>

    {{-- AdminLTE CSS --}}
    <link rel="stylesheet" href="{{ asset('adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte3/dist/css/adminlte.min.css') }}">
    {{-- Google Font: Source Sans Pro --}}
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" rel="stylesheet">

    {{-- Livewire Styles --}}
    @livewireStyles
</head>
<body class="hold-transition login-page"> {{-- Kelas khusus untuk halaman login AdminLTE --}}

    {{-- Slot untuk konten Livewire Component --}}
    {{ $slot }}

    {{-- AdminLTE JS --}}
    <script src="{{ asset('adminlte3/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte3/dist/js/adminlte.min.js') }}"></script>

    {{-- Livewire Scripts --}}
    @livewireScripts
</body>
</html>