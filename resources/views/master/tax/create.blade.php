@extends('template.app')

@section('title')
New Customer ::
@parent
@stop


@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-8 md:col-span-6">
            @if(!empty($result))
            <form action="{{ route('masters.tax.update',['tax' => $result['id']]) }}"
                method="post" onkeydown="return event.key != 'Enter';">
            @else
            <form action="{{ route('masters.tax.store') }}"
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
                                            <div class="text-xs text-danger">Code</div>
                                            <input
                                                type="text"
                                                @if(!empty($result))
                                                value="{{ $result['code'] }}"
                                                @endif
                                                name="code"
                                                class="form-control form-control-sm"
                                                placeholder="Enter Code"
                                                aria-describedby="input-group-4">
                                        </div>
                                        <div>
                                            <div class="text-xs text-danger">Tax.Rate</div>
                                            <input
                                                type="text"
                                                step="any"
                                                @if(!empty($result))
                                                value="{{ $result['tax_rate'] }}"
                                                @endif
                                                name="tax_rate"
                                                class="form-control form-control-sm number-separator text-right"
                                                placeholder="Enter Tax Rate"
                                                aria-describedby="input-group-4">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-xs">Description</div>
                                        <input
                                            type="text"
                                            @if(!empty($result))
                                            value="{{ $result['description'] }}"
                                            @endif
                                            name="description"
                                            class="form-control form-control-sm"
                                            placeholder="Description"
                                            aria-describedby="input-group-4">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-0">
                                <div class="sm:grid grid-cols-2 gap-2">
                                    <div>
                                        <div class="text-xs text-danger">Purchase Account</div>
                                        <select
                                            class="tom-select-custom w-full"
                                            name="purchase_account_id"
                                            id="purchase_account_id"
                                            placeholder="Select Purchase Account" >
                                            <option value="">Select Purchase Account</option>
                                            @foreach (getAccountByType(5) as $purchase)
                                                @if(!empty($result))
                                                    @if($result['purchase_account_id'] == $purchase->id)
                                                    <option value="{{ $purchase->id }}" selected>{{ $purchase->account_full }}</option>
                                                    @else
                                                    <option value="{{ $purchase->id }}">{{ $purchase->account_full }}</option>
                                                    @endif
                                                @else
                                                <option value="{{ $purchase->id }}">{{ $purchase->account_full }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <div class="text-xs">Sales Account</div>
                                        <select
                                            class="tom-select-custom w-full"
                                            name="sale_account_id"
                                            id="sale_account_id"
                                            placeholder="Select Purchase Account" >
                                            <option value="">Select Sales Account</option>
                                            @foreach (getAccountByType(9) as $sales)
                                                @if(!empty($result))
                                                    @if($result['sale_account_id'] == $sales->id)
                                                    <option value="{{ $sales->id }}" selected>{{ $sales->account_full }}</option>
                                                    @else
                                                    <option value="{{ $sales->id }}">{{ $sales->account_full }}</option>
                                                    @endif
                                                @else
                                                <option value="{{ $sales->id }}">{{ $sales->account_full }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('masters.tax.index') }}" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</a>
                                <button type="submit" class="btn btn-primary w-20">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END: Basic Select -->
        </div>
    </div>
@endsection
