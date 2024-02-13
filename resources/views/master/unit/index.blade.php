@extends('template.app')

@section('title')
Category Lists ::
@parent
@stop

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a data-tw-merge data-tw-toggle="modal" data-tw-target="#docUnit" data-id=""  href="javascript:void(0);"
                class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary">Add New</a>
        </div>
        <div class="intro-y col-span-12 overflow-x-auto">
            <table class="display table-striped -mt-2" id="datatable" width="100%">
                <thead>
                    <tr>
                        <th class="px-4 py-2 w-56">Code</th>
                        <th class="px-4 py-2 w-56">Name</th>
                        <th class="px-4 py-2 w-56">Status</th>
                        <th class="px-4 py-2 w-10 text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="docUnit" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="unitForm" name="unitForm" class="form-horizontal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto" id="modelHeading">New Unit</h2>
                    </div>
                    <div class="modal-body p-5">
                        <input type="hidden" id="unit_id" name="unit_id">
                        <div class="mt-0">
                            <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                    <div>
                                        <div class="text-xs">Code</div>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm"
                                            name="code"
                                            id="code"
                                            placeholder="Code"
                                            aria-describedby="input-group-4">
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs">Name</div>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        name="name"
                                        id="name"
                                        placeholder="Name"
                                        aria-describedby="input-group-4">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Closed</button>
                        <button type="submit" data-tw-dismiss="modal" id="saveBtn" class="btn btn-primary w-30">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    @push('scripts')
    <script src="{{ asset('js/imask.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript">
        var url = "{{ route('masters.unit.index') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* $('#docUnit').click(function () {
            $('#saveBtn').val("create-unit");
            var unit_id = $(this).data('id');
            if(unit_id != ''){
                $('#modelHeading').html("Edit Unit");
            }else{
                $('#modelHeading').html("Create New Unit");
                $('#unit_id').val('');
            }
            $('#unitForm').trigger("reset");
            $('#docUnit').modal('show');
        }); */

        $('body').on('click', '.editUnit', function () {
            var unit_id = $(this).data('id');
            $.get("{{ route('masters.unit.index') }}" +'/' + unit_id +'/edit', function (data) {
                if(unit_id != ''){
                    $('#modelHeading').html("Edit Unit");
                }else{
                    $('#modelHeading').html("Create New Unit");
                }
                $('#modelHeading').html("Edit Unit");
                $('#saveBtn').val("edit-unit");
                $('#docUnit').modal('show');
                $('#unit_id').val(data.id);
                $('#code').val(data.code);
                $('#name').val(data.name);
            })
        });

        var tableUnit = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
            },
            columns: [
                { data:'code', name:'code', className: 'text-xs text-left' },
                { data:'name', name:'name', className: 'text-xs text-left' },
                { data:'status', name:'status', className: 'text-xs text-center', searchable: false },
                { data:'action', name:'action', className: 'text-xs', searchable: false },
            ],
            columnDefs: [
                { targets:0, width: '15%'},
                { targets:1, width: '75%'},
                { targets:2, width: '10%'},
                { targets:3, width: '10%'},
            ]
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#unitForm').serialize(),
                url: "{{ route('masters.unit.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#unitForm').trigger("reset");
                    $('#unit_id').val();
                    $('#docUnit').modal('hide');
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${data.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    tableUnit.draw();
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
