@extends('template.app')

@section('title')
Category Lists ::
@parent
@stop

@section('content')
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <a data-tw-merge data-tw-toggle="modal" data-tw-target="#docCategory"  href="javascript:void(0);"
                class="transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer focus:ring-4 focus:ring-primary focus:ring-opacity-20 focus-visible:outline-none dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&amp;:hover:not(:disabled)]:bg-opacity-90 [&amp;:hover:not(:disabled)]:border-opacity-90 [&amp;:not(button)]:text-center disabled:opacity-70 disabled:cursor-not-allowed bg-primary border-primary text-white dark:border-primary">Add New</a>
        </div>
        <div class="intro-y col-span-12 overflow-x-auto">
            <table class="display table-striped -mt-2" id="datatable" width="100%">
                <thead>
                    <tr>
                        <th class="px-4 py-2 w-56">Name</th>
                        <th class="px-4 py-2 w-56">Show.POS</th>
                        <th class="px-4 py-2 w-56">Status</th>
                        <th class="px-4 py-2 w-10 text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="docCategory" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="categoryForm" name="categoryForm" class="form-horizontal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto" id="modelHeading">New Category</h2>
                    </div>
                    <input type="hidden" id="category_id" name="category_id">
                    <div class="modal-body p-5">
                        <div class="mt-0">
                            <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
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
                                <div>
                                    <div class="text-xs">Show on POS Outlet</div>
                                    <div data-tw-merge="" class="flex items-center mt-2">
                                        <input data-tw-merge="" type="checkbox" name="show_pos" id="show_pos"
                                            class="transition-all duration-100 ease-in-out shadow-sm border-slate-200 cursor-pointer focus:ring-4 focus:ring-offset-0 focus:ring-primary focus:ring-opacity-20 dark:bg-darkmode-800 dark:border-transparent dark:focus:ring-slate-700 dark:focus:ring-opacity-50 [&[type='radio']]:checked:bg-primary [&[type='radio']]:checked:border-primary [&[type='radio']]:checked:border-opacity-10 [&[type='checkbox']]:checked:bg-primary [&[type='checkbox']]:checked:border-primary [&[type='checkbox']]:checked:border-opacity-10 [&:disabled:not(:checked)]:bg-slate-100 [&:disabled:not(:checked)]:cursor-not-allowed [&:disabled:not(:checked)]:dark:bg-darkmode-800/50 [&:disabled:checked]:opacity-70 [&:disabled:checked]:cursor-not-allowed [&:disabled:checked]:dark:bg-darkmode-800/50 w-[38px] h-[24px] p-px rounded-full relative before:w-[20px] before:h-[20px] before:shadow-[1px_1px_3px_rgba(0,0,0,0.25)] before:transition-[margin-left] before:duration-200 before:ease-in-out before:absolute before:inset-y-0 before:my-auto before:rounded-full before:dark:bg-darkmode-600 checked:bg-primary checked:border-primary checked:bg-none before:checked:ml-[14px] before:checked:bg-white">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Closed</button>
                        <button type="submit" data-tw-dismiss="modal" id="saveBtn" class="btn btn-primary w-30">Submit</button>
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
                { data:'show_pos', name:'show_pos', className: 'text-xs text-left' },
                { data:'status', name:'status', className: 'text-xs text-center', searchable: false },
                { data:'action', name:'action', className: 'text-xs', searchable: false },
            ],
            columnDefs: [
                { targets:0, width: '80%'},
                { targets:1, width: '10%'},
                { targets:2, width: '10%'},
                { targets:3, width: '10%'},
            ]
        });

        $('body').on('click', '.editCategory', function () {
            var category_id = $(this).data('id');
            $.get("{{ route('masters.category.index') }}" +'/' + category_id +'/edit', function (data) {
                $('#modelHeading').html("Edit Category");
                $('#saveBtn').val("edit-category");
                $('#docCategory').modal('show');
                $('#category_id').val(data.id);
                $('#show_pos').val(data.show_pos);
                $('#name').val(data.name);
            })
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Submit..');

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
