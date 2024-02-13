@extends('template.app')

@section('title')
Group Permission Lists ::
@parent
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box mb-2">
                <form action="{{ route('settings.group-permissions.post-new-user',['id' => $id]) }}"
                    method="post" onkeydown="return event.key != 'Enter';">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        {{ $title }}
                    </h2>
                </div>
                    @csrf
                    @if(!empty($result))
                    @method('PUT')
                    @endif
                    <input type="hidden" name="group_permission_id" id="group_permission_id" value="{{ $id }}">
                    <div id="basic-select" class="p-5">
                        <div class="preview">
                            <div class="mt-0">
                                <div class="sm:grid grid-cols-2 gap-2">
                                    <div class="sm:grid grid-cols-2 gap-2">
                                        <div>
                                            <div class="text-xs"><strong>Name</strong></div>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="name"
                                                name="name"
                                                @if(!empty($result))
                                                value="{{ $result['name'] }}"
                                                @endif
                                                placeholder="Enter Name"
                                                aria-describedby="input-group-4">
                                        </div>
                                        <div>
                                            <div class="text-xs"><strong>Email</strong></div>
                                            <input
                                                type="email"
                                                class="form-control"
                                                id="email"
                                                name="email"
                                                @if(!empty($result))
                                                value="{{ $result['email'] }}"
                                                @endif
                                                placeholder="Enter Email"
                                                aria-describedby="input-group-4">
                                        </div>
                                    </div>
                                    <div class="sm:grid grid-cols-2 gap-2">
                                        <div>
                                            <div class="text-xs"><strong>Password</strong></div>
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="password"
                                                name="password"
                                                placeholder="Password"
                                                aria-describedby="input-group-4">
                                        </div>
                                        <div>
                                            <div class="text-xs"><strong>Confirm Password</strong></div>
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="confirm_password"
                                                name="confirm_password"
                                                placeholder="Konfirmasi Password"
                                                aria-describedby="input-group-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="sm:grid grid-cols-2 gap-2">
                                    <div>
                                        <div class="text-xs"><strong>Group Permission</strong></div>
                                        <input
                                            type="text"
                                            readonly
                                            class="form-control"
                                            value="{{ $group['name'] }}"
                                            aria-describedby="input-group-4">
                                    </div>
                                    <div class="sm:grid grid-cols-2 gap-2">
                                        <div>
                                            <div class="text-xs text-danger">Select Employee</div>
                                            <select
                                                class="tom-select-custom w-full"
                                                name="pegawai_id"
                                                id="pegawai_id"
                                                placeholder="Select Employee" >
                                                <option value="">Select Employee</option>
                                                @foreach (getEmployee() as $employee)
                                                    <option value="{{ $employee->id }}">{{ $employee->code }} - {{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <div class="text-xs text-danger">User Type</div>
                                            <select
                                                class="tom-select-custom w-full"
                                                name="user_type"
                                                id="user_type"
                                                placeholder="Select User Type" >
                                                <option value="">Select User Type</option>
                                                @foreach (getUserTypes() as $key => $type)
                                                    <option value="{{ $key }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-right">
                        <a href="{{ route('settings.group-permissions.index') }}" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</a>
                        <button type="submit" class="btn btn-primary w-20">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @push('scripts')
    <script src="{{ asset('js/imask.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript">
        var transDate = '';
        var addState = "{{ request()->segment(count(request()->segments())) }}";

    </script>
    @endpush
@endsection
