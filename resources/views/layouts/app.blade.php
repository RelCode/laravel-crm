<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel CRM</title>
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}" media="all">
    <link rel="stylesheet" href="{{ asset('vendor/datetime/datetimepicker.css') }}">
    <style>
        html,body{
            height: 100% !important;
        }
        #wrapper {
            height: 100% !important;
        }
        #wrapper #content-wrapper {
            height: 100% !important;
        }
        #wrapper #content-wrapper #content {
            height: 100% !important;
        }
        .sidebar {
            height: 100% !important;
        }
        .bootstrap-datetimepicker-widget {
            display: block !important;
        }
        .toggle-options {
            display: flex;
            align-items: center;
        }
        #main-row {
            /* overflow-y: auto; */
        }
        input[name="datetime"] {
            cursor: pointer;
        }
        .dot {
            width: 15px;
            height: 15px;
            position: absolute;
            top: -8px;
            left: 17px;
            background-color: red;
            border-radius: 50%;
        }
        .text-overflow {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body class="mb-0 page-top">
    @yield('content')
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/datetime/datetimepicker.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @include('sweetalert::alert')
</body>
</html>