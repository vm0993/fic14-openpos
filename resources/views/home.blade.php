@extends('template.app')

@section('title')
Dashboard ::
@parent
@stop

@section('css')
@endsection

@section('content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 mt-5">
        <div class="grid grid-cols-12 gap-6 mt-2">
            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                <div class="report-box">
                    <div class="box p-2">
                        <a class="text-3xl font-medium leading-8 mt-2">

                        </a>
                        <div class="text-xs text-right text-slate-500 mt-1">Pendapatan&nbsp;Bulan&nbsp;Ini</div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                <div class="report-box">
                    <div class="box p-2">
                        <a class="text-3xl font-medium leading-8 mt-2">

                        </a>
                        <div class="text-xs text-right text-slate-500 mt-1">Pendapatan&nbsp;Bulan&nbsp;Lalu</div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                <div class="report-box">
                    <div class="box p-2">
                        <a class="text-3xl font-medium leading-8 mt-2">

                        </a>
                        <div class="text-xs text-right text-slate-500 mt-1">Pendapatan&nbsp;Tahun&nbsp;Ini</div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                <div class="report-box">
                    <div class="box p-2">
                        <a class="text-3xl font-medium leading-8 mt-2 tooltip cursor-pointer" title="Pendapatan Tahun Lalu">

                        </a>
                        <div class="text-xs text-right text-slate-500 mt-1">Pendapatan&nbsp;Tahun&nbsp;Lalu</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="intro-y grid grid-cols-12 gap-6 mt-2">
    <div class="col-span-12 lg:col-span-9">
        <div class="col-span-12 xl:col-span-9 2xl:col-span-9 z-10">
            <div class="mt-4 mb-3 grid grid-cols-12 sm:gap-10 intro-y">
                <div class="col-span-12 sm:col-span-6 md:col-span-12 sm:pl-2 md:pl-0 lg:pl-2 relative text-center sm:text-left">
                    <div class="intro-y box p-5 mt-2 sm:mt-2">
                        <canvas id="salesChart" height="162" class="mt-3"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-12 xl:col-span-3 xl:col-start-10 xl:pb-6 z-30">
        <div class="box p-5 mt-6 bg-primary intro-x">
            <div class="flex flex-wrap gap-3">
                <div class="mr-auto">
                    <div class="text-white text-opacity-70 dark:text-slate-300 flex items-center leading-3">
                        Cash Balance
                        <i data-lucide="alert-circle" class="tooltip w-4 h-4 ml-1.5" title="Total Cash in hand: "></i>
                    </div>
                    <div class="text-white relative text-2xl font-medium leading-5 pl-4 mt-3.5">
                        <span class="absolute text-xl top-0 left-0 -mt-1.5"></span>0
                    </div>
                </div>
            </div>
        </div>
        <div class="box p-5 mt-2 bg-primary intro-x">
            <div class="flex flex-wrap gap-3">
                <div class="mr-auto">
                    <div class="text-white text-opacity-70 dark:text-slate-300 flex items-center leading-3">
                        Payment Gateway Balance
                        <i data-lucide="alert-circle" class="tooltip w-4 h-4 ml-1.5" title="Midtrans Balance : 0"></i>
                    </div>
                    <div class="text-white relative text-2xl font-medium leading-5 pl-4 mt-3.5">
                        <span class="absolute text-xl top-0 left-0 -mt-1.5"></span>0
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')
    @push('scripts')
    <script src="{{ asset('js/accounting.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/daterangepicker.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/daterangepicker.css') }}" />
    @endpush
@stop
