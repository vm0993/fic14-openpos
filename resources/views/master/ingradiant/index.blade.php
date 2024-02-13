@extends('template.app')

@section('title')
Ingradiant Lists ::
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
            <a href="{{ route('masters.ingradiant.create') }}"
                class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary">Add New</a>
        </div>
        <div class="intro-y col-span-12 overflow-x-auto">
            <table class="display table-striped -mt-2" id="datatable" width="100%">
                <thead>
                    <tr>
                        <th class="px-4 py-2 w-56"></th>
                        <th class="px-4 py-2 w-56">Action</th>
                        <th class="px-4 py-2 w-56">Code</th>
                        <th class="px-4 py-2 w-56">Description</th>
                        <th class="px-4 py-2 w-10 text-center">Cost.Amount</th>
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
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/handlebars-v4.7.7.js') }}"></script>
    <script id="details-ingradiant" type="text/x-handlebars-template">
        @verbatim
        <div class="intro-y box px-5 py-2">
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <div class="text-xs">Detail Ingradiant : {{ description }}</div>
                <table class="display table-striped" style="width: 100%;" id="ingradiant-{{id}}">
                    <thead>
                        <tr>
                            <th class="text-xs">Item Code</th>
                            <th class="text-xs">Item Name</th>
                            <th class="text-xs">Qty.Usage</th>
                            <th class="text-xs">Cost.Usage</th>
                            <th class="text-xs">Cost.Amount</th>
                            <th class="text-xs"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @endverbatim
    </script>
    <script type="text/javascript">
        var url = "{{ route('masters.ingradiant.index') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var templateIngradiant = Handlebars.compile($("#details-ingradiant").html());
        var tableIngradiant = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
            },
            columns: [
                { className : 'details-control', orderable : false, data : null, defaultContent  : '' },
                { data:'action', name:'action', className: 'text-xs', searchable: false },
                { data:'code', name:'code',className:'text-xs' },
                { data:'description', name:'description', className: 'text-xs text-left ml-4' },
                { data:'cost_amount', name:'cost_amount', className: 'text-xs text-right' },
            ],
            columnDefs: [
                { targets:0, width: '4%'},
                { targets:1, width: '8%'},
                { targets:2, width: '10%'},
                { targets:3, width: '80%'},
                { targets:4, width: '10%'},
            ]
        });

        $('#datatable tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tableIngradiant.row(tr);
            var tableId = 'ingradiant-' + row.data().id;
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                row.child(templateIngradiant(row.data())).show();
                initTable(tableId, row.data());
                tr.addClass('shown');
                tr.next().find('td').addClass('no-padding bg-gray');
            }
        });

        function initTable(tableId, data) {
            $('#' + tableId).DataTable({
                processing: true,
                serverSide: true,
                bPaginate: false,
                bLengthChange: false,
                bFilter: true,
                bInfo: false,
                bAutoWidth: false,
                ajax: data.addDetailUrl,
                columns: [
                    { data: 'code', name: 'code', className:'text-left text-xs' },
                    { data: 'name', name: 'name', className:'text-left text-xs' },
                    { data: 'qty_usage', name: 'qty_usage', className:'text-right text-xs' },
                    { data: 'cost_usage', name: 'cost_usage', className:'text-right text-xs' },
                    { data: 'cost_amount', name: 'cost_amount', className:'text-right text-xs' },
                    { data:'action',name:'action', className:'text-center text-xs',orderable: false, searchable: false}
                ],
                columnDefs: [
                    { targets:0, width: '20%'},
                    { targets:1, width: '42%'},
                    { targets:2, width: '10%'},
                    { targets:3, width: '10%'},
                    { targets:4, width: '10%'},
                    { targets:5, width: '4%'},
                ]
            })
        }

    </script>
    @endpush
@endsection
