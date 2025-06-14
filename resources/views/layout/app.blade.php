@php
    $currentRoute = Route::currentRouteName();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="icon" type="image/x-icon" href="{{ asset(config('setting.favicon')) }}">
    <title>@yield('title') | {{config('app.name')}} </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/sweetAlert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/baseJSFunctions.js') }}"></script>

    @stack('scripts')
</body>
</html>