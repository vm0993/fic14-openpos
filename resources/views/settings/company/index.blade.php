@extends('template.app')

@section('title')
Company Profile ::
@parent
@stop


@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12 md:col-span-12">
            <ul class="nav nav-boxed-tabs mt-6" role="tablist">
                <li id="companyNav" class="nav-item flex-1" role="presentation">
                    <button
                        class="nav-link w-full py-2 active"
                        data-tw-toggle="pill"
                        data-tw-target="#companyTab"
                        type="button"
                        role="tab"
                        aria-controls="companyTab"
                        aria-selected="true">
                        Company Information
                    </button>
                </li>
                <li id="itemNav" class="nav-item flex-1" role="presentation">
                    <button
                        class="nav-link w-full py-2"
                        data-tw-toggle="pill"
                        data-tw-target="#itemTab"
                        type="button"
                        role="tab"
                        aria-controls="itemTab"
                        aria-selected="false">
                        Item Default Account
                    </button>
                </li>
            </ul>
            <div class="tab-content mt-2">
                <div id="companyTab" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="companyNav">
                    @if(!empty($result))
                    <form action="{{ route('settings.company.update',['company' => $result['id']]) }}"
                        method="post" onkeydown="return event.key != 'Enter';">
                    @else
                    <form action="{{ route('settings.company.store') }}"
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
                                                <div class="text-danger">Company Name</div>
                                                <input
                                                    type="text"
                                                    @if(!empty($result))
                                                    value="{{ $result['company_name'] }}"
                                                    @endif
                                                    id="company_name"
                                                    name="company_name"
                                                    class="form-control"
                                                    placeholder="Enter Company Name"
                                                    aria-describedby="input-group-4">
                                            </div>
                                            <div>
                                                <div class="text-danger">Address</div>
                                                <input
                                                    type="text"
                                                    @if(!empty($result))
                                                    value="{{ $result['address'] }}"
                                                    @endif
                                                    id="address"
                                                    name="address"
                                                    class="form-control"
                                                    placeholder="Enter Address"
                                                    aria-describedby="input-group-4">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-0">
                                        <div class="sm:grid grid-cols-2 gap-2">
                                            <div class="sm:grid grid-cols-2 gap-2">
                                                <div>
                                                    <div class="text-danger">Phone No</div>
                                                    <input
                                                        type="text"
                                                        @if(!empty($result))
                                                        value="{{ $result['phone_no'] }}"
                                                        @endif
                                                        id="phone_no"
                                                        name="phone_no"
                                                        onkeypress="return isNumberKey(event)"
                                                        class="form-control"
                                                        placeholder="Enter Phone No"
                                                        aria-describedby="input-group-4">
                                                </div>
                                                <div>
                                                    <div class="text-danger">Website</div>
                                                    <input
                                                        type="text"
                                                        @if(!empty($result))
                                                        value="{{ $result['website'] }}"
                                                        @endif
                                                        id="website"
                                                        name="website"
                                                        class="form-control"
                                                        placeholder="Enter Website"
                                                        aria-describedby="input-group-4">
                                                </div>
                                            </div>
                                            <div class="sm:grid grid-cols-2 gap-2">
                                                <div>
                                                    <div>Email</div>
                                                    <input
                                                        type="email"
                                                        @if(!empty($result))
                                                        value="{{ $result['register_email'] }}"
                                                        @endif
                                                        id="register_email"
                                                        name="register_email"
                                                        class="form-control"
                                                        placeholder="Enter Email"
                                                        aria-describedby="input-group-4">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-0">
                                        <div class="sm:grid grid-cols-2 gap-2">
                                            <div class="sm:grid grid-cols-2 gap-2">
                                                <div>
                                                    <div>Service Charge Rate</div>
                                                    <input
                                                        type="text"
                                                        step="any"
                                                        onkeypress="return isNumberKey(event)"
                                                        @if(!empty($result))
                                                        value="{{ $result['service_charges_rate'] }}"
                                                        @endif
                                                        id="service_charges_rate"
                                                        name="service_charges_rate"
                                                        class="form-control text-right number-separator"
                                                        placeholder="Enter Service Charge Rate"
                                                        aria-describedby="input-group-4">
                                                </div>
                                                <div>
                                                    <div class="text-danger">Service Charges Account</div>
                                                    <select
                                                        class="tom-select-custom w-26"
                                                        name="service_charges_account_id"
                                                        id="service_charges_account_id">
                                                        <option value="">Select Service Charge Account</option>
                                                        @foreach (getAccountByType(9) as $sc)
                                                            @if(!empty($result))
                                                                @if($sc->id == $result['service_charges_account_id'])
                                                                    <option value="{{ $sc->id }}" selected>{{ $sc->accountFull }}</option>
                                                                @else
                                                                    <option value="{{ $sc->id }}">{{ $sc->accountFull }}</option>
                                                                @endif
                                                            @else
                                                            <option value="{{ $sc->id }}">{{ $sc->accountFull }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="sm:grid grid-cols-2 gap-2">
                                                <div>
                                                    <div>Tax PB1 Rate</div>
                                                    <input
                                                        type="text"
                                                        step="any"
                                                        onkeypress="return isNumberKey(event)"
                                                        @if(!empty($result))
                                                        value="{{ $result['resto_tax_rate'] }}"
                                                        @endif
                                                        id="resto_tax_rate"
                                                        name="resto_tax_rate"
                                                        class="form-control text-right number-separator"
                                                        placeholder="Enter Tax PB1 Rate"
                                                        aria-describedby="input-group-4">
                                                </div>
                                                <div>
                                                    <div class="text-danger">Sale Tax Account</div>
                                                    <select
                                                        class="tom-select-custom w-26"
                                                        name="resto_tax_account_id"
                                                        id="resto_tax_account_id">
                                                        <option value="">Select Sale Tax Account</option>
                                                        @foreach (getAccountByType(9) as $sc)
                                                            @if(!empty($result))
                                                                @if($sc->id == $result['resto_tax_account_id'])
                                                                    <option value="{{ $sc->id }}" selected>{{ $sc->accountFull }}</option>
                                                                @else
                                                                    <option value="{{ $sc->id }}">{{ $sc->accountFull }}</option>
                                                                @endif
                                                            @else
                                                            <option value="{{ $sc->id }}">{{ $sc->accountFull }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-4 text-right">
                                        <button type="submit" class="btn btn-primary w-20">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="itemTab" class="tab-pane leading-relaxed" role="tabpanel" aria-labelledby="itemNav">

                </div>
            </div>
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

