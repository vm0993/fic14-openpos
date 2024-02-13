@extends('template.setup')

@section('title')
Buat Table Database myKedai ::
@parent
@stop

@section('content')
<div class="col-lg-12" style="padding-top: 20px;">
    @if (trim($output)=='Nothing to migrate.')
    <div class="col-md-12">
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            {{ trans('general.setup_no_migrations') }}
        </div>
    </div>
    @else
    <div class="col-md-12">
        <div class="alert alert-success">
            <i class="fas fa-check"></i>
            Tabel database Anda telah dibuat
        </div>
    </div>

    @endif

    <p>Migration output:</p>
    <pre>{{ $output }}</pre>
</div>
@stop

@section('button')
  <form action="{{ route('setup.user') }}" method="GET">
    <button class="btn btn-primary">Next: Buat User</button>
  </form>
@parent
@stop
