@extends('template.app')

@section('title')
Item Opname Lists ::
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
            <a href="{{ route('inventorys.item-opname.create') }}"
                class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary">Add New</a>
            <div class="flex items-center sm:ml-auto ml-2">
                <input
                    data-tw-merge
                    id="date_range"
                    name="date_range"
                    type="text" class="disabled:bg-slate-100 disabled:cursor-not-allowed dark:disabled:bg-darkmode-800/50 dark:disabled:border-transparent [&amp;amp;[readonly]]:bg-slate-100 [&amp;amp;[readonly]]:cursor-not-allowed [&amp;amp;[readonly]]:dark:bg-darkmode-800/50 [&amp;amp;[readonly]]:dark:border-transparent transition duration-200 ease-in-out w-full text-sm border-slate-200 shadow-sm rounded-md placeholder:text-slate-400/90 focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus:border-primary focus:border-opacity-40 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 dark:placeholder:text-slate-500/80 rangetanggal mx-auto block w-56 mx-auto block w-56 rangetanggal mx-auto block w-56 mx-auto block w-56"/>
                <button class="btn btn-primary filter ml-0">Filter</button>
                <input type="hidden" id="dariTgl" name="dariTgl">
                <input type="hidden" id="sampaiTgl" name="sampaiTgl">
                <div class="pos-dropdown dropdown ml-auto sm:ml-2 ml-2">
                    <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                        <span class="w-5 h-5 flex items-center justify-center">
                            <i class="w-4 h-4" data-lucide="chevron-down"></i>
                        </span>
                    </button>
                    <div class="pos-dropdown__dropdown-menu dropdown-menu">
                        <ul class="dropdown-content">
                            <li>
                                <a id="exportPDF" target="_blank" class="dropdown-item">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                                    <span class="truncate">Download PDF</span>
                                </a>
                            </li>
                            <li>
                                <a id="exportXls" target="_blank" class="dropdown-item">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-2"></i>
                                    <span class="truncate">Download Excel</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="intro-y col-span-12 overflow-x-auto">
            <table class="display table-striped -mt-2" id="datatable" width="100%">
                <thead>
                    <tr>
                        <th class="px-4 py-2 w-10 text-center"></th>
                        <th class="px-4 py-2 w-10 text-center">#</th>
                        <th class="px-4 py-2 w-56">Outlet</th>
                        <th class="px-4 py-2 w-56">Code</th>
                        <th class="px-4 py-2 w-56">Transaction.Date</th>
                        <th class="px-4 py-2 w-56">Description</th>
                        <th class="px-4 py-2 w-56">Total.Qty</th>
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
    <script type="text/javascript" src="{{ asset('js/daterangepicker.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/daterangepicker.css') }}" />
    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/handlebars-v4.7.7.js') }}"></script>
    <script id="details-barangmasuk" type="text/x-handlebars-template">
        @verbatim
        <div class="intro-y box px-5 py-2">
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <div class="text-xs">Detail Barang Masuk : {{ voucher }}</div>
                <table class="display table-striped" style="width: 100%;" id="barangmasuk-{{id}}">
                    <thead>
                        <tr>
                            <th class="text-xs">Code</th>
                            <th class="text-xs">Product Name</th>
                            <th class="text-xs">Qty</th>
                            <th class="text-xs">Price</th>
                            <th class="text-xs"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @endverbatim
    </script>
    <script type="text/javascript">
        var url = "{{ route('inventorys.item-opname.index') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('input[name="date_range"]').daterangepicker({
            startDate: moment().startOf('month'),
            endDate: moment()
        }, function(first, last) {
            $('#exportPDF').attr('href', '/inventorys/item-opname/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD') + '/preview')
            $('#exportXls').attr('href', '/inventorys/item-opname/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD') + '/download-xls')
        });

        $('#exportPDF').attr('href', '/inventorys/item-opname/' + $('input[name="date_range"]').data('daterangepicker').startDate.format('YYYY-MM-DD') + '+' + $('input[name="date_range"]').data('daterangepicker').endDate.format('YYYY-MM-DD') + '/preview');
        $('#exportXls').attr('href', '/inventorys/item-opname/' + $('input[name="date_range"]').data('daterangepicker').startDate.format('YYYY-MM-DD') + '+' + $('input[name="date_range"]').data('daterangepicker').endDate.format('YYYY-MM-DD') + '/download-xls')

        $(".filter").click(function(){
            tableBarangMasuk.draw();
        });

        var templateBarangMasuk = Handlebars.compile($("#details-barangmasuk").html());
        var tableBarangMasuk = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
                data:function (d) {
                    d.from_date = $('input[name="date_range"]').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    d.to_date = $('input[name="date_range"]').data('daterangepicker').endDate.format('YYYY-MM-DD');
                }
            },
            columns: [
                { className : 'details-control', orderable : false, data : null, defaultContent  : '' },
                { data:'action', name:'action', className: 'text-xs', searchable: false },
                { data:'outlet', name:'outlet',className:'text-xs' },
                { data:'code', name:'code',className:'text-xs' },
                { data:'transaction_date', name:'transaction_date',className:'text-xs' },
                { data:'description', name:'description',className: 'text-xs'},
                { data:'total_qty', name:'total_qty',className: 'text-xs text-right'},
            ],
            columnDefs: [
                { targets:0, width: '4%'},
                { targets:1, width: '6%'},
                { targets:2, width: '18%'},
                { targets:3, width: '10%'},
                { targets:4, width: '10%'},
                { targets:5, width: '70%'},
                { targets:6, width: '10%'},
            ]
        });

        $('#datatable tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tableBarangMasuk.row(tr);
            var tableId = 'barangmasuk-' + row.data().id;
            console.log(tableId);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                row.child(templateBarangMasuk(row.data())).show();
                initTable(tableId, row.data());
                console.log(row.data());
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
                    { data: 'qty', name: 'qty', className:'text-right text-xs' },
                    { data: 'buy_price', name: 'buy_price', className:'text-right text-xs mr-4' },
                    { data:'action',name:'action', className:'text-center text-xs',orderable: false, searchable: false}
                ],
                columnDefs: [
                    { targets:0, width: '15%'},
                    { targets:1, width: '76%'},
                    { targets:2, width: '12%'},
                    { targets:3, width: '15%'},
                    { targets:4, width: '4%'},
                ]
            })
        }


    </script>
    @endpush
@endsection
