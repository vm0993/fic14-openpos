@extends('template.app')

@section('title')
@if(!empty($result))
Edit
@else
New
@endif
 Item Incoming ::
@parent
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('content')
<div class="grid grid-cols-12 gap-10 mt-5">
    <div class="intro-y col-span-12 lg:col-span-12 md:col-span-12 sm:col-span-12">
        @if(!empty($result))
        <form action="{{ route('inventorys.item-opname.update',['item_opname'=> $result['id']]) }}"
            method="post" onkeydown="return event.key != 'Enter';">
        @else
        <form action="{{ route('inventorys.item-opname.store') }}"
            method="post" onkeydown="return event.key != 'Enter';">
        @endif
            @csrf
            @if(!empty($result))
            @method('PUT')
            <input
                type="hidden"
                readonly
                class="form-control form-control-sm text-center"
                name="id"
                @if(!empty($result))
                value="{{ $result['id'] }}"
                @endif
                id="id">
            @endif
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-2 px-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        {{ $title }}
                    </h2>
                    <div class="text-right">
                        <input
                            type="text"
                            readonly
                            placeholder="Opname No"
                            class="form-control form-control-sm text-center"
                            name="code"
                            @if(!empty($result))
                            value="{{ $result['code'] }}"
                            @endif
                            id="code">
                    </div>
                </div>
                <div id="basic-select" class="p-5">
                    <div class="preview">
                        <div class="intro-y">
                            <div class="mt-0">
                                <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                    <div class="md:grid grid-cols-2 sm:grid grid-cols-2 gap-2">
                                        <div>
                                            <div class="text-danger">Outlet</div>
                                            <select
                                                class="tom-select-custom w-26"
                                                style="height: 20px;"
                                                name="outlet_id"
                                                id="outlet_id">
                                                <option value="">Select Outlet</option>
                                                @foreach (getOutlets() as $cat)
                                                    @if(!empty($result))
                                                        @if($cat->id == $result['outlet_id'])
                                                            <option value="{{ $cat->id }}" selected>{{ $cat->name }}</option>
                                                        @else
                                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                        @endif
                                                    @else
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <div><span class="text-theme-20">Transaction.Date</span></div>
                                            <input
                                                type="text"
                                                data-format="00-00-0000"
                                                placeholder="dd-mm-yyyy"
                                                class="form-control"
                                                name="transaction_date"
                                                @if(!empty($result))
                                                value="{{ \Carbon\Carbon::parse($result['transaction_date'])->format('d-m-Y') }}"
                                                @endif
                                                id="transaction_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-0">
                                <div class="md:grid grid-cols-1 sm:grid grid-cols-1 gap-2">
                                    <div>
                                        <div><span class="text-theme-20">Description</span></div>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="description"
                                            @if(!empty($result))
                                            value="{{ $result['description'] }}"
                                            @endif
                                            id="description">
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-x-5 mt-1">
                                <div class="col-span-12 lg:col-span-6 sm:col-span-6 mt-1">
                                    <div class="input-group">
                                        <div class="input-group-text w-full text-center">
                                            <span class="text-theme-20">Item&nbsp;Name</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-1">
                                    <div class="input-group">
                                        <div class="input-group-text w-full text-center">
                                            <span class="text-theme-20">Qty</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-1">
                                    <div class="input-group">
                                        <div class="input-group-text w-full text-center">
                                            <span class="text-theme-20">Qty.Opname</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="ingradiant-list">
                            </div>
                            <div class="grid grid-cols-12 gap-x-5 mt-0">
                                <div class="col-span-12 lg:col-span-9 sm:col-span-9 mt-2">
                                    <div class="col-span-12 lg:col-span-8 mt-2">
                                        <button type="button" class="btn btn-primary shadow-md mr-2" id="addLine">Add&nbsp;Row</button>
                                    </div>
                                </div>
                                <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-2">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            Total&nbsp;Receive
                                        </div>
                                        <input type="text" step="any" readonly name="totalCost" id="totalCost" class="form-control form-control-sm text-right"/>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-5">
                                <a href="{{ route('inventorys.item-incoming.index') }}" class="btn closeModal btn-outline-secondary w-20 mr-1">Cancel</a>
                                <button type="submit" id="submitButton" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('footer')
    @push('scripts')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/imask.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/accounting.min.js') }}"></script>
    <script src="{{ asset('js/easy-number-separator.js') }}"></script>
    <script type="text/javascript">
        var transDate = '';
        var id        = 0;
        var url       = "{{ route('inventorys.item-opname.index') }}";
        var urlJurnal = "{{ url('masters/ingradiant') }}";
        var count     = 1;
        var addState  = "{{ request()->segment(count(request()->segments())) }}";
        var btnSubmit = document.getElementById('submitButton');
        var config    = {};
        var balance   = 0;
        var momentFormat = 'DD-MM-YYYY';

        var element      = document.querySelectorAll('.date');
        element.forEach(element => {
            var m = new IMask(element, {
                mask: Date,
                pattern: 'd`-m`-00000',
                lazy: false,
            });
        });

        if(addState=='create'){
            dynamicField(1);
        }else{
            id = $('#id').val();
            $.get(url + '/'+ id +'/get-detail',  function(data, status){
                for(var a=0;a<data.length;a++){
                    html = '<div class="grid grid-cols-12 gap-x-5 mt-0" id="line_'+ a +'"><input type="hidden" name="nomor[]" value="'+ a + '">';
                    html += '    <div class="col-span-12 lg:col-span-6 sm:col-span-6 mt-2">';
                    html += '        <div class="input-group">';
                    html += '            <select class="form-control form-control-sm select" id="item_id_'+ a +'" name="item_id_'+ a +'">';
                    html += '               <option value="0">Select Item Opname</option>';
                    html += '               @foreach($items as $item) ';
                    if(data[a].item_id == "{{ $item->id }}"){
                        html += '<option value="{{ $item->id }}" selected>{{ $item->code }} - {{ $item->name }}</option>';
                    }else{
                        html += '<option value="{{ $item->id }}">{{ $item->code }} - {{ $item->name }}</option>';
                    }
                    html += ' @endforeach </select>';
                    html += '        </div>';
                    html += '    </div>';
                    html += '    <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-2">';
                    html += '        <div class="input-group">';
                    html += '            <input type="text" name="qty_'+ a +'" id="qty_'+ a +'" value="'+formatNumber(accounting.toFixed(data[a].qty,2))+'" onkeypress="return isNumberKey(event)" class="form-control number-separator text-right"/>';
                    html += '        </div>';
                    html += '    </div>';
                    html += '    <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-2">';
                    html += '        <div class="input-group">';
                    html += '            <input type="text" name="buy_price_'+ a +'" id="buy_price_'+ a +'" value="'+formatNumber(accounting.toFixed(data[a].buy_price))+'" onkeypress="return isNumberKey(event)" class="form-control number-separator amount text-right"/>';
                    html += '            <button type="button" class="input-group-text remove">';
                    html += '                <img src="{{ asset('vendor/blade-lucide-icons/trash-2.svg') }}" class="w-4 h-4"/>';
                    html += '            </button>';
                    html += '        </div>';
                    html += '    </div>';
                    html += '</div>';

                    $('#ingradiant-list').append(html);
                    $('.select').select2();
                    calculateTotal();
                }
            });
        }

        function dynamicField(number){
            html = '<div class="grid grid-cols-12 gap-x-5 mt-0" id="line_'+ number +'"><input type="hidden" name="nomor[]" value="'+ number + '">';
            html += '    <div class="col-span-12 lg:col-span-6 sm:col-span-6 mt-2">';
            html += '        <div class="input-group">';
            html += '            <select class="form-control form-control-sm select" id="item_id_'+ number +'" name="item_id_'+ number +'">';
            html += '               <option value="0">Select Item Opname</option>';
            html += '               @foreach($items as $item) <option value="{{ $item->id }}">{{ $item->code }} - {{ $item->name }} @endforeach ';
            html += '            </select>';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-2">';
            html += '        <div class="input-group">';
            html += '            <input type="text" name="qty_'+ number +'" id="qty_'+ number +'" onkeypress="return isNumberKey(event)" class="form-control number-separator text-right"/>';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="col-span-12 lg:col-span-3 sm:col-span-3 mt-2">';
            html += '        <div class="input-group">';
            html += '            <input type="text" name="buy_price_'+ number +'" id="buy_price_'+ number +'" onkeypress="return isNumberKey(event)" class="form-control number-separator amount text-right"/>';
            html += '            <button type="button" class="input-group-text remove">';
            html += '                <img src="{{ asset('vendor/blade-lucide-icons/trash-2.svg') }}" class="w-4 h-4"/>';
            html += '            </button>';
            html += '        </div>';
            html += '    </div>';
            html += '</div>';

            $('#ingradiant-list').append(html);
            $('.select').select2();
        }

        $('#addLine').on('click',function(){
            count++;
            dynamicField(count);
        })

        $(document).on('click', '.remove', function(){
            count--;
            $(this).parent().parent().parent().remove();
        })

        function getOpnameNo(){
            transDate        = $('#transaction_date').val();
            tanggalTransaksi = transDate.split("-").reverse().join("-");
            $.ajax({
                type: 'POST',
                url : "{{ route('inventorys.item-opname.get-opname-number') }}",
                data: {
                    _token     : '{{ csrf_token() }}',
                    transaction_date: tanggalTransaksi.replace('_',''),
                },
                success:function(response){
                    $('#code').val(response);
                }
            });
        }

        $('#transaction_date').on('keyup',function(event){
            if (event.key === 'Enter' ) {
                getOpnameNo();
                document.getElementById("description").focus();
            }
        });

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }

        function moneyFormat(price, sign = '') {
            const pieces = parseFloat(price).toFixed(2).split('')
            let ii = pieces.length - 3
            while ((ii-=3) > 0) {
                pieces.splice(ii, 0, ',')
            }
            return sign + pieces.join('')
        }

        function changeNumber(num){
            return num.toString().replace('.', '')
        }

        function validate(evt) {
            var theEvent = evt || window.event;

            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
            // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }

        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        $(document).on('change keyup','.amount',function(){
            id_arr = $(this).attr('id');
            id = id_arr.split("_");

            var nStr = $('#cost_usage_'+id[1]).val();
            $('#cost_usage_'+id[1]).val((nStr));
            calculateTotal();
        });

        function calculateTotal(){
            totalDebet =0; totalCredit =0;
            balance = 0;
            $('.amount').each(function(){
                tDebet    = $(this).val();
                debetLine = tDebet.replace(/[\D\s\._\-]+/g, "");
                if(debetLine != '' )totalDebet += (parseFloat(debetLine.replace(/,/g,'')));
            });
            totDebet = totalDebet.toLocaleString("id-ID");
            $('#totalCost').val((totDebet));
        }

    </script>
    @endpush
@endsection
