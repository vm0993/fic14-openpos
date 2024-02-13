@extends('template.app')

@section('title')
New Employee ::
@parent
@stop

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12 md:col-span-12">
            @if(!empty($result))
            <form action="{{ route('outlets.promo.update',['promo' => $result['id']]) }}"
                method="post" onkeydown="return event.key != 'Enter';">
            @else
            <form action="{{ route('outlets.promo.store') }}"
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
                                        <div class="sm:grid grid-cols-2 gap-2">
                                            <div>
                                                <div class="text-xs text-danger">Code</div>
                                                <input
                                                    type="text"
                                                    @if(!empty($result))
                                                    value="{{ $result['code'] }}"
                                                    @endif
                                                    name="code"
                                                    class="form-control"
                                                    placeholder="Code"
                                                    aria-describedby="input-group-4">
                                            </div>
                                            <div>
                                                <div class="text-xs text-danger">Voucher.Qty</div>
                                                <input
                                                    type="text"
                                                    onkeypress="return isNumberKey(event)"
                                                    @if(!empty($result))
                                                    value="{{ $result['voucher_qty'] }}"
                                                    @endif
                                                    name="voucher_qty"
                                                    class="form-control"
                                                    placeholder="Qty"
                                                    aria-describedby="input-group-4">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-danger">Promo.Type</div>
                                            <select
                                                class="tom-select-custom w-full"
                                                name="promo_type"
                                                id="promo_type"
                                                placeholder="Select Promo Type" >
                                                <option value="">Select Promo Type</option>
                                                @foreach (getPromoType() as $key => $promoType)
                                                    @if(!empty($result))
                                                        @if($result->promo_type == $key)
                                                        <option value="{{ $key }}" selected>{{ $promoType }}</option>
                                                        @else
                                                        <option value="{{ $key }}">{{ $promoType }}</option>
                                                        @endif
                                                    @else
                                                        <option value="{{ $key }}">{{ $promoType }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="sm:grid grid-cols-2 gap-2">
                                        <div class="sm:grid grid-cols-2 gap-2">
                                            <div>
                                                <div class="text-xs text-danger">Start.Date</div>
                                                <input
                                                    type="text"
                                                    onkeypress="return isNumberKey(event)"
                                                    class="form-control"
                                                    name="start_date"
                                                    id="start_date"
                                                    data-format="00-00-0000"
                                                    placeholder="DD-MM-YYYY">
                                            </div>
                                            <div>
                                                <div class="text-xs text-danger">End.Date</div>
                                                <input
                                                    type="text"
                                                    onkeypress="return isNumberKey(event)"
                                                    class="form-control"
                                                    name="end_date"
                                                    id="end_date"
                                                    data-format="00-00-0000"
                                                    placeholder="DD-MM-YYYY">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('outlets.promo.index') }}"
                                    class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</a>
                                <button type="submit" class="btn btn-primary w-20">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
@push('scripts')
    <script src="{{ asset('js/imask.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/accounting.min.js') }}"></script>
    <script src="{{ asset('js/easy-number-separator.js') }}"></script>
    <script type="text/javascript">
        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }
    </script>
@endpush
