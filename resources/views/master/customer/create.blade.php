@extends('template.app')

@section('title')
New Customer ::
@parent
@stop

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-8 lg:col-span-8 md:col-span-8">
            @if(!empty($result))
            <form action="{{ route('masters.customer.update',['customer' => $result['id']]) }}"
                method="post" onkeydown="return event.key != 'Enter';">
            @else
            <form action="{{ route('masters.customer.store') }}"
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
                                    <div>
                                        @component('components.inputs.text',
                                        ['className' => 'text-xs text-danger','title' => 'Name','inputName' => 'name', 'inputClassName' => 'form-control form-control-sm',
                                        'result' => $result,'placeHolder' => 'Enter Name','value' => (!empty($result)) ? $result['name'] : '' ])
                                        @endcomponent
                                    </div>
                                    <div class="sm:grid grid-cols-2 gap-2">
                                        <div>
                                            @component('components.inputs.text',
                                            ['className' => 'text-xs text-danger','title' => 'Phone.No','result' => $result, 'inputClassName' => 'form-control form-control-sm',
                                            'inputName' => 'phone_no','placeHolder' => 'Enter Phone No', 'value' => (!empty($result)) ? $result['phone_no'] : ''])
                                            @endcomponent
                                        </div>
                                        <div>
                                            <div class="text-xs text-danger">Shop.Amount</div>
                                            <input
                                                type="text"
                                                readonly
                                                @if(!empty($result))
                                                value="{{ $result['shop_amount'] }}"
                                                @endif
                                                name="shop_amount"
                                                id="shop_amount"
                                                class="form-control form-control-sm"
                                                placeholder="Shop Amount"
                                                aria-describedby="input-group-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @component('components.buttons.submit-cancel',['route' => route('masters.customer.index') ])
                            @endcomponent
                        </div>
                    </div>
                </div>
            </form>
            <!-- END: Basic Select -->
        </div>
    </div>
@endsection
