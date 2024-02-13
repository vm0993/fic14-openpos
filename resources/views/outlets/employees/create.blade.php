@extends('template.app')

@section('title')
New Employee ::
@parent
@stop


@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12 md:col-span-12">
            @if(!empty($result))
            <form action="{{ route('outlets.employee.update',['employee' => $result['id']]) }}"
                method="post" onkeydown="return event.key != 'Enter';">
            @else
            <form action="{{ route('outlets.employee.store') }}"
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
                                            <div class="text-xs text-danger">Select Outlet</div>
                                            <select
                                                class="tom-select-custom w-full"
                                                name="outlet_id"
                                                id="outlet_id"
                                                placeholder="Select Outlet" >
                                                <option value="">Select Outlet</option>
                                                @foreach (getOutlets() as $outlet)
                                                    @if(!empty($result))
                                                        @if($result->outlet_id == $outlet->id)
                                                        <option value="{{ $outlet->id }}" selected>{{ $outlet->code }}</option>
                                                        @else
                                                        <option value="{{ $outlet->id }}">{{ $outlet->code }}</option>
                                                        @endif
                                                    @else
                                                        <option value="{{ $outlet->id }}">{{ $outlet->code }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <div class="text-xs text-danger">Emp.Code</div>
                                            <input
                                                type="text"
                                                @if(!empty($result))
                                                value="{{ $result['code'] }}"
                                                @endif
                                                name="code"
                                                class="form-control form-control-sm"
                                                placeholder="Emp.Code"
                                                aria-describedby="input-group-4">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-danger">Emp.Name</div>
                                        <input
                                            type="text"
                                            @if(!empty($result))
                                            value="{{ $result['name'] }}"
                                            @endif
                                            name="name"
                                            class="form-control form-control-sm"
                                            placeholder="Emp.Name"
                                            aria-describedby="input-group-4">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-0">
                                <div class="sm:grid grid-cols-2 gap-2">
                                    <div>
                                        <div class="text-xs text-danger">Address</div>
                                        <input
                                            type="text"
                                            @if(!empty($result))
                                            value="{{ $result['address'] }}"
                                            @endif
                                            name="address"
                                            class="form-control form-control-sm"
                                            placeholder="Enter Address"
                                            aria-describedby="input-group-4">
                                    </div>
                                    <div class="sm:grid grid-cols-2 gap-2">
                                        <div>
                                            <div class="text-xs">Email</div>
                                            <input
                                                type="email"
                                                @if(!empty($result))
                                                value="{{ $result['email'] }}"
                                                @endif
                                                name="email"
                                                class="form-control form-control-sm"
                                                placeholder="Enter Email"
                                                aria-describedby="input-group-4">
                                        </div>
                                        <div>
                                            <div class="text-xs">Phone.No</div>
                                            <input
                                                type="text"
                                                @if(!empty($result))
                                                value="{{ $result['phone_no'] }}"
                                                @endif
                                                onkeypress="return isNumberKey(event)"
                                                name="phone_no"
                                                class="form-control form-control-sm"
                                                placeholder="Enter Phone No"
                                                aria-describedby="input-group-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 text-right">
                                <a href="{{ route('outlets.employee.index') }}" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</a>
                                <button type="submit" class="btn btn-primary w-20">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END: Basic Select -->
        </div>
    </div>
@stop

@push('scripts')
    <script src="{{ asset('js/popper.min.js') }}"></script>
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

