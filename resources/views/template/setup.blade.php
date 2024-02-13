<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        @section('title')
            {{ env('APP_NAME') }}
        @show
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="myKedai">
    <meta name="author" content="E&FS">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.ico') }}">
    <link href="{{ url('css/style.min.css') }}" rel="stylesheet">
    <style>
        .table>:not(caption)>*>* {
            padding: 0.2rem 0.2rem;
            background-color: var(--bs-table-bg);
            border-bottom-width: 1px;
            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
        }
        td, th {
        font-size: 11pt;
        }
        .preflight-success {
            color: green;
        }
        .preflight-error {
        color: red;
        }
        .preflight-warning {
        color: orange;
        }
        .page-header {
        font-size: 280%;
        }
        h3 {
        font-size: 250%;
        }
        .alert {
        font-size: 16px;
        }
    </style>
</head>
<body class="skin-default card-no-border">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">{{ env('APP_NAME') }}</p>
        </div>
    </div>
    <div class="main-wrapper p-20">
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="col-10">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ env('APP_NAME') }} Pre-Flight</h4>
                            <div class="wizard-circle">
                                <h6><strong>{{ $section }}</strong></h6><br>
                                @yield('content')

                                @section('button')
                                @show
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ url('js/jquery.min.js') }}" nonce="{{ csrf_token() }}"></script>
    <script src="{{ url('js/bootstrap.bundle.min.js') }}" nonce="{{ csrf_token() }}"></script>
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-bs-toggle="tooltip"]').tooltip()
        });
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>
</body>
</html>
