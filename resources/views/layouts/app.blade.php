<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel CRM</title>
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}" media="all"> --}}
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}" media="all">

    
</head>
<body class="mb-0 page-top">
    <div id="wrapper">
        @auth
            @include('layouts.sidebar')
        @endauth
        @yield('content')
    </div>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
</body>
</html