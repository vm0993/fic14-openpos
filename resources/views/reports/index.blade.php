@extends('template.app')

@section('title')
myKedai Reports ::
@parent
@stop

@section('content')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 mt-3">
        <div class="intro-y box mt-3">
            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">{{ config('app.name') }} Report</h2>
            </div>
            <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2 p-2">
                <div class="intro-y">
                    <div class="box px-4 py-4 mb-3 flex items-center">
                        <div class="ml-4 mr-auto">
                            <a href="" class="font-medium">Sales Report</a>
                            <div class="text-slate-500 text-xs mt-0.5">Sales Report periodic</div>
                        </div>
                    </div>
                    <div class="box px-4 py-4 mb-3 flex items-center">
                        <div class="ml-4 mr-auto">
                            <a href="" class="font-medium">Sales Summary</a>
                            <div class="text-slate-500 text-xs mt-0.5">Balance Sheet report summarizes your company’s assets, liabilities and equity at a specific time.</div>
                        </div>
                    </div>
                    <div class="box px-4 py-4 mb-3 flex items-center">
                        <div class="ml-4 mr-auto">
                            <a href="" class="font-medium">Sales Top 10</a>
                            <div class="text-slate-500 text-xs mt-0.5">Report shows the balance of all your accounts at a specific period. All accounts are grouped based on their categories</div>
                        </div>
                    </div>
                    <div class="box px-4 py-4 mb-3 flex items-center">
                        <div class="ml-4 mr-auto">
                            <a href="" class="font-medium">Sales By Category</a>
                            <div class="text-slate-500 text-xs mt-0.5">Report shows the balance of all your accounts at a specific period. All accounts are grouped based on their categories</div>
                        </div>
                    </div>
                </div>
                <div class="intro-y">
                    <div class="box px-4 py-4 mb-3 flex items-center">
                        <div class="ml-4 mr-auto">
                            <a href="" class="font-medium">Sales By Outlet</a>
                            <div class="text-slate-500 text-xs mt-0.5">Laporan perubahan modal dari waktu ke waktu</div>
                        </div>
                    </div>
                    <div class="box px-4 py-4 mb-3 flex items-center">
                        <div class="ml-4 mr-auto">
                            <a href="" class="font-medium">Sales Analyst</a>
                            <div class="text-slate-500 text-xs mt-0.5">Report shows the balance of all your accounts at a specific period.</div>
                        </div>
                    </div>
                    <div class="box px-4 py-4 mb-3 flex items-center">
                        <div class="ml-4 mr-auto">
                            <a href="" class="font-medium">Sales Comparation</a>
                            <div class="text-slate-500 text-xs mt-0.5">Report shows the balance of all your accounts at a specific period. All accounts are grouped based on their categories</div>
                        </div>
                    </div>
                    <div class="box px-4 py-4 mb-3 flex items-center">
                        <div class="ml-4 mr-auto">
                            <a href="" class="font-medium">Sales ...</a>
                            <div class="text-slate-500 text-xs mt-0.5">Report shows the balance of all your accounts at a specific period. All accounts are grouped based on their categories</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @push('scripts')
    <script src="{{ asset('js/imask.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript">
        var url = "{{ route('masters.category.index') }}";

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
                { data:'name', name:'name', className: 'text-xs text-left' },
                { data:'status', name:'status', className: 'text-xs text-center', searchable: false },
                { data:'action', name:'action', className: 'text-xs', searchable: false },
            ],
            columnDefs: [
                { targets:0, width: '90%'},
                { targets:1, width: '10%'},
                { targets:2, width: '10%'},
            ]
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#categoryForm').serialize(),
                url: "{{ route('masters.category.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#categoryForm').trigger("reset");
                    $('#keluargaModel').modal('hide');
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${data.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    tableCategory.draw();
                },
                error: function (data) {
                    $('#saveBtn').html('Simpan');
                    Swal.fire({
                        type: 'error',
                        icon: 'error',
                        title: `${data.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        });
    </script>
    @endpush
@endsection
