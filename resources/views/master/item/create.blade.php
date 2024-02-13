@extends('template.app')

@section('title')
New Item ::
@parent
@stop


@section('content')

@if(!empty($result))
    @component('components.forms.update-form',
        ['updateRoute' => route('masters.item.update',['item' => $result['id']]),
        'enctype' => 'yes'])
    @endcomponent
@else
    @component('components.forms.store-form',
        ['storeRoute' => route('masters.item.store'), 'enctype' => 'yes'])
    @endcomponent
@endif
    @csrf
    @if(!empty($result))
    @method('PUT')
    @endif
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-9 lg:col-span-9 md:col-span-9">
            <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400 intro-y mt-6 box">
                <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
                    <i data-tw-merge="" data-lucide="chevron-down" class="stroke-1.5 mr-2 h-4 w-4"></i>
                    Product Information
                </div>
                <div class="mt-2">
                    <div class="sm:grid grid-cols-2 gap-2">
                        <div class="sm:grid grid-cols-2 gap-2">
                            <div>
                                <div class="text-danger">Category</div>
                                <select
                                    class="tom-select-custom w-26"
                                    style="height: 20px;"
                                    name="categori_id"
                                    id="categori_id">
                                    <option value="">Select Category</option>
                                    @foreach (getCategorys() as $cat)
                                        @if(!empty($result))
                                            @if($cat->id == $result['categori_id'])
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
                                @component('components.inputs.text',
                                ['className' => 'text-danger','title' => 'Product Code', 'inputClassName' => 'form-control',
                                'result' => $result,'value' => !empty($result) ? $result['code'] : '',
                                'inputName' => 'code', 'placeHolder' => 'Enter Product Code' ])
                                @endcomponent
                            </div>
                        </div>
                        <div class="sm:grid grid-cols-2 gap-2">
                            <div>
                                @component('components.inputs.number',
                                ['inputName' => 'sale_amount','placeholder' => 'Sale Amount',
                                'title' => 'Sale Amount','result' => $result,
                                'amount' => !empty($result) ? $result['sale_amount'] : 0 ])
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-1">
                    <div class="sm:grid grid-cols-2 gap-2">
                        <div>
                            @component('components.inputs.text',
                            ['className' => 'text-danger','title' => 'Product Name', 'inputClassName' => 'form-control',
                            'result' => $result,'value' => !empty($result) ? $result['name'] : '',
                            'inputName' => 'name', 'placeHolder' => 'Enter Product Name' ])
                            @endcomponent
                        </div>
                        <div class="sm:grid grid-cols-2 gap-2">
                            <div>
                                <div class="text-danger">Item Unit</div>
                                <select
                                    class="tom-select-custom w-26"
                                    name="unit_id"
                                    id="unit_id">
                                    <option value="">Select Unit</option>
                                    @foreach (getUnits() as $unit)
                                        @if(!empty($result))
                                            @if($unit->id == $result['unit_id'])
                                                <option value="{{ $unit->id }}" selected>{{ $unit->name }}</option>
                                            @else
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endif
                                        @else
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-1">
                    <div class="sm:grid grid-cols-2 gap-2">
                        <div>
                            @component('components.inputs.file',['inputName'=> 'file_upload', 'title' => 'Image File'])
                            @endcomponent
                        </div>
                        <div class="sm:grid grid-cols-2 gap-2">
                            <div class="sm:grid grid-cols-2 gap-2">
                                <div>
                                    @component('components.inputs.checkbox',
                                    ['title'=> 'Item Purchase', 'inputName' => 'item_purchase',
                                    'result' => $result, 'value' => (!empty($result) ? $result['item_purchase'] : '' ) ])
                                    @endcomponent
                                </div>
                                <div>
                                    @component('components.inputs.checkbox',
                                    ['title'=> 'Item Sale', 'inputName' => 'item_sale',
                                    'result' => $result, 'value' => (!empty($result) ? $result['item_sale'] : '' ) ])
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-3 lg:col-span-3 md:col-span-3 gap-2">
            <div class="mt-6 ">
                <div class="h-40 cursor-pointer zoom-in mx-auto">
                    @if(!empty($result))
                    <img class="rounded-md" alt="Product Image" width="200" src="{{ url($result['item_image']) }}">
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="rounded-md border border-slate-200/60 p-5 dark:border-darkmode-400 intro-y box mt-4">
        <div class="flex items-center border-b border-slate-200/60 pb-5 text-base font-medium dark:border-darkmode-400">
            <i data-tw-merge="" data-lucide="chevron-down" class="stroke-1.5 mr-2 h-4 w-4"></i>
            Product Management
        </div>
        <div class="mt-2">
            <div class="sm:grid grid-cols-2 gap-2">
                <div class="sm:grid grid-cols-2 gap-2">
                    <div>
                        @component('components.inputs.text',
                        ['className' => '','title' => 'SKU', 'inputClassName' => 'form-control',
                        'result' => $result,'value' => !empty($result) ? $result['sku'] : '',
                        'inputName' => 'sku', 'placeHolder' => 'Enter SKU' ])
                        @endcomponent
                    </div>
                    <div>
                        @component('components.inputs.text',
                        ['className' => '','title' => 'Barcode', 'inputClassName' => 'form-control',
                        'result' => $result,'value' => !empty($result) ? $result['barcode'] : '',
                        'inputName' => 'barcode', 'placeHolder' => 'Enter Barcode' ])
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-1">
            <div class="sm:grid grid-cols-2 gap-2">
                <div class="sm:grid grid-cols-2 gap-2">
                    <div class="sm:grid grid-cols-2 gap-2">
                        <div>
                            @component('components.inputs.checkbox',
                            ['title'=> 'Item Stock', 'inputName' => 'item_stock',
                            'result' => $result, 'value' => (!empty($result) ? $result['item_stock'] : '' ) ])
                            @endcomponent
                        </div>
                        <div>
                            @component('components.inputs.checkbox',
                            ['title'=> 'Check.Bal', 'inputName' => 'check_inventory',
                            'result' => $result, 'value' => (!empty($result) ? $result['check_inventory'] : '' ) ])
                            @endcomponent
                        </div>
                    </div>
                    <div>
                        <div class="text-danger">Product Type</div>
                        <select
                            class="tom-select-custom w-26"
                            name="item_type"
                            id="item_type">
                            <option value="">Select Product Type</option>
                            @foreach (getProductType() as $key => $productType)
                                @if(!empty($result))
                                    @if($key == $result['item_type'])
                                        <option value="{{ $key }}" selected>{{ $productType }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $productType }}</option>
                                    @endif
                                @else
                                <option value="{{ $key }}">{{ $productType }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="sm:grid grid-cols-2 gap-2">
                    @if(!empty($result))
                    <div id="source_bom_id" class="{{ $result['ingradiant_id'] == 0 ? 'hidden' : '' }}">
                        <div class="text-danger">Source Ingradiant</div>
                        <select
                            class="tom-select-custom w-26"
                            name="ingradiant_id"
                            id="ingradiant_id">
                            <option value="">Select Ingradiant</option>
                            @foreach (getIngradiants() as $ingradiant)
                                <option value="{{ $ingradiant->id }}">{{ $ingradiant->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <div id="source_bom_id" class="hide">
                        <div class="text-danger">Source Ingradiant</div>
                        <select
                            class="tom-select-custom w-26"
                            name="ingradiant_id"
                            id="ingradiant_id">
                            <option value="">Select Ingradiant</option>
                            @foreach (getIngradiants() as $ingradiant)
                                <option value="{{ $ingradiant->id }}">{{ $ingradiant->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div>
        @component('components.buttons.submit-cancel',['route' => route('masters.item.index') ])
        @endcomponent
    </div>
</form>
@stop

@push('scripts')
    <script src="{{ asset('js/imask.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/accounting.min.js') }}"></script>
    <script src="{{ asset('js/easy-number-separator.js') }}"></script>
    <script type="text/javascript">
        var itemType = "{{ !empty($result) ? $result['item_type'] : '' }}";
        console.log(itemType);

        if(itemType == null || itemType == ''){
            console.log('disini');
            //checkSelectItemType();
        }else{

        }

        function getItemCode(){
            categoryID    = $('#categori_id').val();
            $.ajax({
                type: 'POST',
                url : "{{ route('masters.item.get-number') }}",
                data: {
                    _token     : '{{ csrf_token() }}',
                    categori_id: categoryID,
                },
                success:function(response){
                    $('#code').val(response);
                }
            });
        }

        listCategory = document.querySelector('#categori_id');
        listCategory.onchange = function(e){
            var catID = listCategory.value;
            if(catID != ''){
                getItemCode();
            }
        };

        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode != 46 && charCode > 31
                && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

        function checkSelectItemType(){
            var checkItem = $('#item_type').val();
            if(checkItem == null || checkItem == ''){
                toastr.error('Sorry, Please select this item, you can chose Single or Ingradiant!');
            }
        }

        $('#singleNav').click(function(){
            $('#item_type').val('TUNGGAL');
        });
        $('#ingradiantNav').click(function(){
            $('#item_type').val('KOMPOSISI');
        });
    </script>
@endpush

