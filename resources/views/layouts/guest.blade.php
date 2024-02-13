<!DOCTYPE html>
<html lang="{{ \Illuminate\Support\Str::replace('_', '-', Session()->get('applocale')) }}" class=" default">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="myKedai, Kedai Digital terintegrasi">
        <meta name="keywords" content="myKedai">
        <title>{{ config('app.name', 'myKedai Login') }}</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('css/simplebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/vendors/simplebar.css') }}">
        <!-- Main styles for this application-->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <!-- We use those styles to show code examples, you should remove them in your application.-->
        <link href="{{ asset('css/examples.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="bg-light min-vh-100 d-flex flex-row align-items-center">
            <div class="container">
                @yield('content')
            </div>
        </div>
        <script src="{{ asset('js/coreui/coreui.bundle.min.js') }}"></script>
        <script src="{{ asset('js/simplebar/simplebar.min.js') }}"></script>
    </body>
</html>
