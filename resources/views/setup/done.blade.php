@extends('template.setup')
{{-- Page title --}}
@section('title')
Profile & User Berhasil
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="col-lg-12" style="padding-top: 20px;">
	<div class="col-md-12">
        <div class="alert alert-warning">
            <i class="fas fa-check"></i>
            'Data Usaha, Outlet & User sudah berhasil dibuat!'
        </div>
    </div>
    <p>Silahkan klik link ini untuk login <a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
</div>
@stop
