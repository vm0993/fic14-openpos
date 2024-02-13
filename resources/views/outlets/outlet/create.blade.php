@extends('template.app')

@section('title')
New Employee ::
@parent
@stop


@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-8 md:col-span-6">
            @if(!empty($result))
            <form action="{{ route('outlets.outlet.update',['outlet' => $result['id']]) }}"
                method="post" onkeydown="return event.key != 'Enter';">
            @else
            <form action="{{ route('outlets.outlet.store') }}"
                method="post" onkeydown="return event.key != 'Enter';">
            @endif
                @csrf
                @if(!empty($result))
                @method('PUT')
                @endif
                <div class="intro-y box">
                    <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                        <h2 class="font-medium text-base mr-auto">
                            {{ $title }}
                        </h2>
                    </div>
                    <div id="basic-select" class="p-5">
                        <div class="preview">
                            <div class="mt-0">
                                <div class="sm:grid grid-cols-2 gap-2">
                                    <div class="sm:grid grid-cols-2 gap-2">
                                        <div>
                                            <div class="text-xs text-danger">Kode Komda</div>
                                            <input
                                                type="text"
                                                @if(!empty($result))
                                                value="{{ $result['kode'] }}"
                                                @endif
                                                name="kode"
                                                class="form-control form-control-sm"
                                                placeholder="{{ __('komda.enter-code') }}"
                                                aria-describedby="input-group-4">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-danger">Nama Komda</div>
                                        <input
                                            type="text"
                                            @if(!empty($result))
                                            value="{{ $result['nama'] }}"
                                            @endif
                                            name="nama"
                                            class="form-control form-control-sm"
                                            placeholder="{{ __('komda.enter-name') }}"
                                            aria-describedby="input-group-4">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-0">
                                <div class="sm:grid grid-cols-2 gap-2">
                                    <div>
                                        <div class="text-xs text-danger">Alamat</div>
                                        <input
                                            type="text"
                                            @if(!empty($result))
                                            value="{{ $result['alamat'] }}"
                                            @endif
                                            name="alamat"
                                            class="form-control form-control-sm"
                                            placeholder="{{ __('komda.enter-alamat') }}"
                                            aria-describedby="input-group-4">
                                    </div>
                                    <div>
                                        <div class="text-xs">Alamat Lain</div>
                                        <input
                                            type="text"
                                            @if(!empty($result))
                                            value="{{ $result['alamat_lain'] }}"
                                            @endif
                                            name="alamat_lain"
                                            class="form-control form-control-sm"
                                            placeholder="{{ __('komda.enter-alamat') }}"
                                            aria-describedby="input-group-4">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-0">
                                <div class="sm:grid grid-cols-2 gap-2">
                                    <div>
                                        <div class="text-xs text-danger">Kota</div>
                                        <input
                                            type="text"
                                            @if(!empty($result))
                                            value="{{ $result['kota'] }}"
                                            @endif
                                            name="kota"
                                            class="form-control form-control-sm"
                                            placeholder="{{ __('komda.enter-kota') }}"
                                            aria-describedby="input-group-4">
                                    </div>
                                    <div class="sm:grid grid-cols-2 gap-2">
                                        <div>
                                            <div class="text-xs text-danger">Kode Pos</div>
                                            <input
                                                type="text"
                                                @if(!empty($result))
                                                value="{{ $result['kode_pos'] }}"
                                                @endif
                                                name="kode_pos"
                                                maxlength="6"
                                                class="form-control form-control-sm"
                                                placeholder="{{ __('komda.enter-kode-pos') }}"
                                                aria-describedby="input-group-4">
                                        </div>
                                        <div>
                                            <div class="text-xs text-danger">No.Telepon</div>
                                            <input
                                                type="text"
                                                @if(!empty($result))
                                                value="{{ $result['no_telpon'] }}"
                                                @endif
                                                name="no_telpon"
                                                class="form-control form-control-sm"
                                                placeholder="{{ __('komda.enter-no-telepon') }}"
                                                aria-describedby="input-group-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('outlets.outlet.index') }}" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">{{ trans('global.cancel-button') }}</a>
                                <button type="submit" class="btn btn-primary w-20">{{ trans('global.save-button') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END: Basic Select -->
        </div>
    </div>
@endsection
