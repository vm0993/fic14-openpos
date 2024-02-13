@extends('template.app')

@section('title')
Employee Lists ::
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
            <a href="{{ route('outlets.employee.create') }}"
                class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary">Add New</a>
        </div>
        <div class="intro-y col-span-12 overflow-x-auto">
            <table class="display table-striped -mt-2" id="datatable" width="100%">
                <thead>
                    <tr>
                        <th class="px-4 py-2 w-10 text-center"></th>
                        <th class="px-4 py-2 w-10 text-center">Action</th>
                        <th class="px-4 py-2 w-56">Outlet</th>
                        <th class="px-4 py-2 w-56">Code</th>
                        <th class="px-4 py-2 w-56">Name</th>
                        <th class="px-4 py-2 w-56">Address</th>
                        <th class="px-4 py-2 w-56">Email</th>
                        <th class="px-4 py-2 w-56">Phone.No</th>
                        <th class="px-4 py-2 w-56">Status</th>
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
        var url = "{{ route('outlets.employee.index') }}";

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
                { className : 'details-control', orderable : false, data : null, defaultContent  : '' },
                { data:'action', name:'action', className: 'text-xs', searchable: false },
                { data:'outlet_name', name:'outlet_name', className: 'text-xs text-left' },
                { data:'code', name:'code', className: 'text-xs text-left' },
                { data:'name', name:'name', className: 'text-xs text-left' },
                { data:'address', name:'address', className: 'text-xs text-left' },
                { data:'email', name:'email', className: 'text-xs text-left' },
                { data:'phone_no', name:'phone_no', className: 'text-xs text-left' },
                { data:'status', name:'status', className: 'text-xs text-center', searchable: false },
            ],
            columnDefs: [
                { targets:0, width: '3%'},
                { targets:1, width: '5%'},
                { targets:2, width: '15%'},
                { targets:3, width: '6%'},
                { targets:4, width: '18%'},
                { targets:5, width: '25%'},
                { targets:6, width: '15%'},
                { targets:7, width: '10%'},
                { targets:8, width: '6%'},
            ]
        });

    </script>
    @endpush
@endsection
