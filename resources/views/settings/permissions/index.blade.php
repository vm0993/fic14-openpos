@extends('template.app')

@section('title')
Group Permission Lists ::
@parent
@stop

@section('css')
<style>
    td.details-control {
        background: url('../../images/details_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('../../images/details_close.png') no-repeat center center;
    }
    .modal-dialog {
        padding-top: 30px;
        width: 80%;
        max-width: 700px;
        margin: auto;
    }
</style>
@endsection

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('settings.group-permissions.create') }}"
                class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary">Add New</a>
        </div>
        <div class="intro-y col-span-12 overflow-x-auto">
            <table class="display table-striped -mt-2" id="datatable" width="100%">
                <thead>
                    <tr>
                        <th class="px-4 py-2 w-10"></th>
                        <th class="px-4 py-2 w-10 text-center">#</th>
                        <th class="px-4 py-2 w-56">Name</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('footer')
    @push('scripts')
    <script src="{{ asset('js/imask.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/handlebars-v4.7.7.js') }}"></script>
    <script id="details-user" type="text/x-handlebars-template">
        @verbatim
        <div class="intro-y box px-5 py-2">
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <div class="text-xs">Detail User : </div>
                <table class="display table-striped" style="width: 100%;" id="group-{{id}}">
                    <thead>
                        <tr>
                            <th class="text-xs">#</th>
                            <th class="text-xs">Name</th>
                            <th class="text-xs">Email</th>
                            <th class="text-xs">User.Type</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @endverbatim
    </script>
    <script type="text/javascript">
        var url = "{{ route('settings.group-permissions.index') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var templatePermission = Handlebars.compile($("#details-user").html());
        var tablePermission = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
            },
            columns: [
                { className : 'details-control', orderable : false, data : null, defaultContent  : '' },
                { data:'action', name:'action', className: 'text-xs', searchable: false },
                { data:'name', name:'name', className: 'text-xs text-left' },
            ],
            columnDefs: [
                { targets:0, width: '4%'},
                { targets:1, width: '6%'},
                { targets:2, width: '90%'},
            ]
        });

        $('#datatable tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tablePermission.row(tr);
            var tableId = 'group-' + row.data().id;
            console.log(tableId);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                row.child(templatePermission(row.data())).show();
                initTable(tableId, row.data());
                tr.addClass('shown');
                tr.next().find('td').addClass('no-padding bg-gray');
            }
        });

        function initTable(tableId, data) {
            $('#' + tableId).DataTable({
                processing: true,
                serverSide: true,
                bPaginate: true,
                bLengthChange: false,
                bFilter: true,
                bInfo: true,
                bAutoWidth: true,
                ajax: data.addDetailUrl,
                columns: [
                    { data:'action', name:'action', className: 'text-xs text-left' },
                    { data:'name', name:'name', className: 'text-xs text-left' },
                    { data:'email', name:'email', className: 'text-xs text-left' },
                    { data:'user_type', name:'user_type', className: 'text-xs text-left' },
                ],
                columnDefs: [
                    { targets:0, width: '4%'},
                    { targets:1, width: '50%'},
                    { targets:2, width: '40%'},
                    { targets:3, width: '10%'},
                ]
            });
        }

    </script>
    @endpush
@endsection
