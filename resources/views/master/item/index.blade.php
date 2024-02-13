@extends('template.app')

@section('title')
Item Lists ::
@parent
@stop

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a href="{{ route('masters.item.create') }}"
                class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary">Add New</a>
        </div>
        <div class="intro-y col-span-12 overflow-x-auto">
            <table class="display table-striped -mt-2" id="datatable" width="100%">
                <thead>
                    <tr>
                        <th class="px-4 py-2 w-10 text-center">#</th>
                        <th class="px-4 py-2 w-56">Category</th>
                        <th class="px-4 py-2 w-56">Code</th>
                        <th class="px-4 py-2 w-56">Name</th>
                        <th class="px-4 py-2 w-56">Purchase</th>
                        <th class="px-4 py-2 w-56">Sale.Item</th>
                        <th class="px-4 py-2 w-56">Item.Stock</th>
                        <th class="px-4 py-2 w-56">Item.Type</th>
                        <th class="px-4 py-2 w-56">Sale.Amount</th>
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
    <script type="text/javascript">
        var url = "{{ route('masters.item.index') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var tableCategory = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
            },
            columns: [
                { data:'action', name:'action', className: 'text-xs', searchable: false },
                { data:'category_name', name:'category_name', className: 'text-xs text-left' },
                { data:'code', name:'code', className: 'text-xs text-left' },
                { data:'name', name:'name', className: 'text-xs text-left' },
                { data:'item_purchase', name:'item_purchase', className: 'text-xs text-center' },
                { data:'item_sale', name:'item_sale', className: 'text-xs text-center dt-center' },
                { data:'item_stock', name:'item_stock', className: 'text-xs text-center dt-center' },
                { data:'item_type', name:'item_type', className: 'text-xs text-left' },
                { data:'sale_amount', name:'sale_amount', className: 'text-xs text-right' },
            ],
            columnDefs: [
                { targets:0, width: '5%'},
                { targets:1, width: '15%'},
                { targets:2, width: '10%'},
                { targets:3, width: '25%'},
                { targets:4, width: '15%'},
                { targets:5, width: '10%'},
                { targets:6, width: '10%'},
                { targets:7, width: '10%'},
                { targets:8, width: '10%'},
            ]
        });

    </script>
    @endpush
@endsection
