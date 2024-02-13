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
                @if(!empty($result))
                <form action="{{ route('settings.user.update',['user' => $result['id']]) }}"
                    method="post" onkeydown="return event.key != 'Enter';">
                @else
                <form action="{{ route('settings.user.store') }}"
                    method="post" onkeydown="return event.key != 'Enter';">
                @endif
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        {{ $title }}
                    </h2>
                </div>
                    @csrf
                    @if(!empty($result))
                    @method('PUT')
                    @endif
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
                                        <select
                                            class="tom-select-custom w-full"
                                            name="permission_group_id"
                                            id="permission_group_id"
                                            placeholder="Select Permission" >
                                            <option value="">Select Permission</option>
                                            @foreach (getPermission() as $permission)
                                                @if(!empty($result))
                                                    @if($permission->id == $result->permission_group_id)
                                                    <option value="{{ $permission->id }}" selected>{{ $permission->name }}</option>
                                                    @else
                                                    <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                                    @endif
                                                @else
                                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
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
                                                    @if(!empty($result))
                                                        @if($employee->id == $result->pegawai_id)
                                                        <option value="{{ $employee->id }}" selected>{{ $employee->code }} - {{ $employee->name }}</option>
                                                        @else
                                                        <option value="{{ $employee->id }}">{{ $employee->code }} - {{ $employee->name }}</option>
                                                        @endif
                                                    @else
                                                    <option value="{{ $employee->id }}">{{ $employee->code }} - {{ $employee->name }}</option>
                                                    @endif
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
                                                    @if(!empty($result))
                                                        @if($key == $result->user_type)
                                                        <option value="{{ $key }}" selected>{{ $type }}</option>
                                                        @else
                                                        <option value="{{ $key }}">{{ $type }}</option>
                                                        @endif
                                                    @else
                                                    <option value="{{ $key }}">{{ $type }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-5 pb-8 text-right">
                        <a href="{{ route('settings.user.index') }}" class="btn btn-outline-secondary w-24 dark:border-dark-5 dark:text-gray-300 mr-1">Cancel</a>
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
