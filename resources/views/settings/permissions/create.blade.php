@extends('template.app')

@section('title')
Group Permission Lists ::
@parent
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
<style>
    td.details-control {
        background: url('../../../../images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('../../../../images/details_close.png') no-repeat center center;
    }
    .modal-dialog {
        padding-top: 30px;
        width: 80%;
        max-width: 700px;
        margin: auto;
    }
    .form-horizontal .control-label {
        padding-top: 0px;
    }

    input[type='text'][disabled], input[disabled], textarea[disabled], input[readonly], textarea[readonly], .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        background-color: white;
        color: #555555;
        cursor:text;
    }
    table.permissions {
        display:flex;
        flex-direction: column;
    }

    .permissions.table > thead, .permissions.table > tbody {
        margin: 15px;
        margin-top: 0px;
    }
    .permissions.table > tbody {
        border: 1px solid;
    }
    .header-row {
        border-bottom: 1px solid #ccc;
    }

</style>
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
                                <table class="display table-striped -mt-2" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 w-56">Permission</th>
                                            <th class="px-4 py-2 w-10 text-center">Grant</th>
                                            <th class="px-4 py-2 w-10 text-center">Deny</th>
                                        </tr>
                                    </thead>
                                    @foreach ($permissions as $area => $area_permission)
                                        @php $localPermission = $area_permission[0]; @endphp
                                        @if (count($area_permission) == 1)
                                            <tbody>
                                                <tr class="header-row permissions-row">
                                                    <td>
                                                        @unless (empty($localPermission['label']))
                                                        <h2><strong>{{ $area . ': ' . $localPermission['label'] }}</strong></h2>
                                                        @else
                                                        <h2>{{ $area }}</h2>
                                                        @endunless
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio"
                                                            name="permission[{{ $localPermission['permission'] }}]"
                                                            aria-label="permission[{{ $localPermission['permission'] }}]" value="1"
                                                            id="permission[{{ $localPermission['permission'] }}]"
                                                            {{ $groupPermissions[$localPermission['permission'] ] == '1' ? 'checked' : null }}
                                                            >
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" name="permission[{{ $localPermission['permission'] }}]" aria-label="permission[{{ $localPermission['permission'] }}]"
                                                            value="0" id="permission[{{ $localPermission['permission'] }}]"
                                                            {{ $groupPermissions[$localPermission['permission'] ] == '0' ? 'checked' : null }}
                                                            >
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @else
                                            <tbody>
                                                <tr class="header-row permissions-row">
                                                    <td>
                                                        <h2><strong>{{ $area }}</strong></h2>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" name="{{ $area }}" data-checker-group="{{ Str::slug($area) }}" aria-label="{{ $localPermission['permission'] }}"
                                                            value="1" id="{{ $area }}">
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="radio" name="{{ $area }}" data-checker-group="{{ Str::slug($area) }}" aria-label="{{ $localPermission['permission'] }}"
                                                            value="0" id="{{ $area }}">
                                                    </td>
                                                </tr>
                                                @foreach ($area_permission as $index => $this_permission)
                                                    @if ($this_permission['display'])
                                                        <tr class="permissions-row">
                                                            @if ($this_permission['display'])
                                                              <td
                                                                class="col-md-5 tooltip-base permissions-item"
                                                                data-tooltip="true"
                                                                data-placement="right"
                                                                title="{{ $this_permission['note'] }}"
                                                              >
                                                                {{ $this_permission['label'] }}
                                                              </td>
                                                              <td class="text-center">
                                                                    <input type="radio" name="permission[{{ $this_permission['permission'] }}]" aria-label="permission[{{ $this_permission['permission'] }}]"
                                                                    value="1" id="permission[{{ $this_permission['permission'] }}" class="radiochecker-{{ Str::slug($area) }}"
                                                                    {{ $groupPermissions[$this_permission['permission'] ] == '1' ? 'checked' : null }}
                                                                    >
                                                              </td>
                                                              <td class="text-center">
                                                                    <input type="radio" name="permission[{{ $this_permission['permission'] }}]" aria-label="permission[{{ $this_permission['permission'] }}]"
                                                                    value="0" id="permission[{{ $this_permission['permission'] }}]" class="radiochecker-{{ Str::slug($area) }}"
                                                                    {{ $groupPermissions[$this_permission['permission'] ] == '0' ? 'checked' : null }}
                                                                    >
                                                              </td>
                                                            @endif
                                                          </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        @endif
                                    @endforeach
                                </table>
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

        $(".superuser").change(function() {
            var perms = $(this).val();
            if (perms =='1') {
                $("#nonadmin").hide();
            } else {
                $("#nonadmin").show();
            }
        });

        $('tr.header-row input:radio').change(function() {
            value = $(this).attr('value');
            area = $(this).data('checker-group');
            $('.radiochecker-'+area+'[value='+value+']').prop('checked', true);
        });


        $('.header-name').click(function() {
            $(this).parent().nextUntil('tr.header-row').slideToggle(500);
        });
    </script>
    @endpush
@endsection
