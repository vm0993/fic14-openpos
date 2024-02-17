
<!DOCTYPE html>
<html lang="en" class="theme-3">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="myKedai">
    <meta name="author" content="E&FS">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.ico') }}">
    <title>
        @section('title')
            myKedai
        @show
    </title>
    <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    @yield('css')
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/OneSignalSDK.js') }}" async=""></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
</head>
<body class="py-1 md:py-0">
    @include('template.mobile')
    @include('template.top')
    <div class="flex overflow-hidden">
        @include('template.sidebar')
        <div class="content content--dashboard">
            <section id="loading">
                <div id="loading-content"></div>
            </section>
            @yield('content')
            <!-- Main modal -->
            <div id="deleteModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                    <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                        <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteModal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this item?</p>
                        <div class="flex justify-center items-center space-x-4">
                            <button data-modal-toggle="deleteModal" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                No, cancel
                            </button>
                            <button type="submit" class="py-2 px-3 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                Yes, I'm sure
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('dist/js/app.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    @stack('scripts')
    <script type="text/javascript">
        let _token   = document.head.querySelector('meta[name="csrf-token"]');

        var momentFormat = 'DD-MM-YYYY';
        var element = document.querySelectorAll('.date');
        element.forEach(element => {
            let m = new IMask(element, {
                mask: Date,
                pattern: 'd`-m`-00000',
                lazy: false,
            });
        });

        var inputElements = document.querySelectorAll("input[data-format]");
        inputElements.forEach(input => {
            let m = new IMask(input, {
                mask: input.getAttribute("data-format"),
            });
        });

        var inputElements = document.querySelectorAll("input[data-format]");
        inputElements.forEach(input => {
            let m = new IMask(input, {
                mask: input.getAttribute("data-format"),
            });
        });

        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            toastr.options = {
                "closeButton"      : false,
                "debug"            : false,
                "newestOnTop"      : false,
                "progressBar"      : false,
                "positionClass"    : "toast-bottom-right",
                "preventDuplicates": false,
                "onclick"          : null,
                "showDuration"     : "300",
                "hideDuration"     : "1000",
                "timeOut"          : "5000",
                "extendedTimeOut"  : "1000",
                "showEasing"       : "swing",
                "hideEasing"       : "linear",
                "showMethod"       : "fadeIn",
                "hideMethod"       : "fadeOut"
            }
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}","{{ config('app.name') }}");
                    break;

                case 'warning':
                    toastr.warning("{{ Session::get('message') }}","{{ config('app.name') }}");
                    break;

                case 'success':
                    toastr.success("{{ Session::get('message') }}","{{ config('app.name') }}");
                    break;

                case 'error':
                    toastr.error("{{ Session::get('message') }}","{{ config('app.name') }}");
                    break;
            }
        @endif

        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }
            // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });

        //global async function getData from uri
        async function getDataFromURI(source_uri) {
            let response = await fetch(source_uri);

            if (response.status === 200) {
                return await response.json();
            }
        }
    </script>
</body>
</html>
