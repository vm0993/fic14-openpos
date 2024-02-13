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
                <form action="{{ route('settings.group-permissions.update',['group_permission' => $result['id']]) }}"
                    method="post" onkeydown="return event.key != 'Enter';">
                @else
                <form action="{{ route('settings.group-permissions.store') }}"
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
                                </div>
                            </div>
                            <div class="mt-2">

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
