@extends('template.app')

@section('title')
Outlet Lists ::
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
            <a data-tw-merge data-tw-toggle="modal" data-tw-target="#docOutlet"  href="javascript:void(0);"
                class="btn btn-primary shadow-md mr-2">Add New</a>
        </div>
        <div class="intro-y col-span-12 overflow-x-auto">
            <table class="display table-striped -mt-2" id="datatable">
                <thead>
                    <tr>
                        <th class="px-4 py-2 w-10"></th>
                        <th class="px-4 py-2 w-10 text-center">#</th>
                        <th class="px-4 py-2 w-56">Code</th>
                        <th class="px-4 py-2 w-56">Name</th>
                        <th class="px-4 py-2 w-56">Address</th>
                        <th class="px-4 py-2 w-56">Phone No</th>
                        <th class="px-4 py-2 w-56">Email</th>
                        <th class="px-4 py-2 w-56">Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="docOutlet" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="outletForm" name="outletForm" class="form-horizontal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="font-medium text-base mr-auto" id="modelHeading">New Outlet</h2>
                    </div>
                    <div class="modal-body p-5">
                        <div class="mt-0">
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="company_id" id="company_id" value="{{ auth()->user()->company_id }}">
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
                                    <div>
                                        <div class="text-xs">Phone.No</div>
                                        <input
                                            type="text"
                                            onkeypress="return isNumberKey(event)"
                                            class="form-control form-control-sm"
                                            name="phone_no"
                                            id="phone_no"
                                            placeholder="Phone.No"
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
                        <div class="mt-0">
                            <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                <div>
                                    <div class="text-xs">Address</div>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        name="address"
                                        id="address"
                                        placeholder="Address"
                                        aria-describedby="input-group-4">
                                </div>
                                <div>
                                    <div class="text-xs">Email</div>
                                    <input
                                        type="email"
                                        class="form-control form-control-sm"
                                        name="email"
                                        id="email"
                                        placeholder="Email"
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
    <script src="{{ asset('js/handlebars-v4.7.7.js') }}"></script>
    <script id="details-employee" type="text/x-handlebars-template">
        @verbatim
        <div class="intro-y box px-5 py-2">
            <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                <div class="text-xs">Detail Employee : </div>
                <table class="display table-striped" style="width: 100%;" id="outlet-{{id}}">
                    <thead>
                        <tr>
                            <th class="text-xs">#</th>
                            <th class="text-xs">Code</th>
                            <th class="text-xs">Name</th>
                            <th class="text-xs">Address</th>
                            <th class="text-xs">Email</th>
                            <th class="text-xs">Phone.No</th>
                            <th class="text-xs">Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @endverbatim
    </script>
    <script>
        var url = "{{ route('outlets.outlet.index') }}";

        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#outletForm').serialize(),
                url: "{{ route('outlets.outlet.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#outletForm').trigger("reset");
                    $('#docOutlet').modal('hide');
                    Swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${data.message}`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    tableOutlet.draw();
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

        var templateEmployee = Handlebars.compile($("#details-employee").html());
        var tableOutlet = $('#datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
            },
            columns: [
                { className : 'details-control', orderable : false, data : null, defaultContent  : '' },
                { data:'action', name:'action', className: 'text-xs', searchable: false },
                { data:'code', name:'code', className: 'text-xs text-left' },
                { data:'name', name:'name', className: 'text-xs text-left' },
                { data:'address', name:'address', className: 'text-xs text-left', searchable: false },
                { data:'phone_no', name:'phone_no', className: 'text-xs', searchable: false },
                { data:'email', name:'email', className: 'text-xs text-left', searchable: false },
                { data:'status', name:'status', className: 'text-xs text-center', searchable: false },
            ],
            columnDefs: [
                { targets:0, width: '2%'},
                { targets:1, width: '4%'},
                { targets:2, width: '10%'},
                { targets:3, width: '20%'},
                { targets:4, width: '30%'},
                { targets:5, width: '15%'},
                { targets:6, width: '10%'},
                { targets:7, width: '6%'},
            ]
        });

        $('#datatable tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tableOutlet.row(tr);
            var tableId = 'outlet-' + row.data().id;
            console.log(tableId);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                row.child(templateEmployee(row.data())).show();
                initTable(tableId, row.data());
                tr.addClass('shown');
                tr.next().find('td').addClass('no-padding bg-gray');
            }
        });

        $('body').on('click', '.editOutlet', function () {
            var outlet_id = $(this).data('id');
            console.log(outlet_id);
            $.get("{{ route('outlets.outlet.index') }}" +'/' + outlet_id +'/edit', function (data) {
                console.log(data);
                $('#modelHeading').html("Edit Outlet");
                $('#saveBtn').val("edit-user");
                $('#docOutlet').modal('show');
                $('#id').val(data.id);
                $('#company_id').val(data.company_id);
                $('#code').val(data.code);
                $('#name').val(data.name);
                $('#address').val(data.address);
                $('#phone_no').val(data.phone_no);
                $('#email').val(data.email);
            })
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
                    { data: 'action',name: 'action', className:'text-center text-xs',orderable: false, searchable: false},
                    { data: 'code', name: 'code', className:'text-left text-xs' },
                    { data: 'name', name: 'name', className:'text-left text-xs' },
                    { data: 'address', name: 'address', className:'text-left text-xs' },
                    { data: 'email', name: 'email', className:'text-left text-xs ml-4' },
                    { data: 'phone_no', name: 'phone_no', className:'text-left text-xs ml-4' },
                    { data: 'status', name: 'status', className:'text-right text-xs ml-4' },
                ],
                columnDefs: [
                    { targets:0, width: '4%'},
                    { targets:1, width: '10%'},
                    { targets:2, width: '25%'},
                    { targets:3, width: '30%'},
                    { targets:4, width: '15%'},
                    { targets:5, width: '10%'},
                    { targets:6, width: '6%'},
                ]
            });
        }
    </script>
    @endpush
@endsection
