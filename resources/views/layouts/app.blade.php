<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-white">
@include('navigationbar')
<a class="bg-dark hidden" id="return-to-top"><i class="fas fa-angle-up"></i></a>
<div class="container">
    @include('breadcrumbs')
    <div id="app" class="">
        @yield('content')
    </div>

</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/scroll_to_top.js') }}"></script>
@stack('scripts')
</body>
</html>
