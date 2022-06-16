@extends('layouts.base')

@section('content')
{{--    {{ dd($product) }}--}}
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                <h4>Update Product</h4>
            </div>
            <div class="box-action">
                <a href="{{ route('product.list') }}" class="btn btn-sm btn-secondary">Product List</a>
            </div>
        </div>
        {!! Form::open(['route' => ['product.update', $product->slug], 'method' => 'PUT']) !!}
        <div class="box-body">
            <input type="hidden" name="admin_id" value="{{ Auth::guard('admin')->user()->id }}">

            <div class="form-group">
                <label for="">Name<span> *</span></label>
                <input type="text" name="name" placeholder="Enter Name" id="cat_name" class="form-control" value="{{ $product->name}}">
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" rows="5" placeholder="Enter description" class="form-control">{{ $product->description}}</textarea>
                <span class="text-danger">{{ $errors->first('description') }}</span>
            </div>
            <h4 class="mb-3 mt-4">General Info</h4>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Category<span> *</span></label>
                        {!! Form::select('category_id', selectOptions($parent_categories), $product->category_id, ['class' => 'form-select form-control', 'placeholder' => 'Select Category' , 'id' => 'parent_category']) !!}<span class="text-danger">{{ $errors->first('category_id') }}</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Sub Category</label>
                        {{-- <select class="form-control" name="sub_category_id" id="sub_category">
                        </select> --}}
                        {!! Form::select('sub_category_id', selectOptions($sub_categories), $product->sub_category_id, ['class' => 'form-select form-control', 'placeholder' => 'Select Category' , 'id' => 'sub_category']) !!}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="">Sub sub Category</label>
                        {{-- <select class="form-control" name="sub_sub_category_id" id="sub_sub_category">
                        </select> --}}
                        {!! Form::select('sub_sub_category_id', selectOptions($sub_sub_Categories), $product->sub_sub_category_id, ['class' => 'form-select form-control', 'placeholder' => 'Select Category' , 'id' => 'sub_sub_category']) !!}
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Brand<span> *</span></label>
                        {!! Form::select('brand_id', selectOptions($brands), $product->brand_id, ['class' => 'form-select form-control', 'placeholder' => 'Select Brand']) !!}
                        <span class="text-danger">{{ $errors->first('brand_id') }}</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Unit</label>
                        {!! Form::select('unit', getUnit(), $product->unit, ['class' => 'form-select form-control', 'placeholder' => 'Select Unit']) !!}
                    </div>
                </div>
            </div>
            <h4 class="mb-3 mt-4">Variations</h4>
            <div class="form-group">
                <label for="">Attribute</label>
                <select name="attribute_id[]" class="form-control attribute-select2" id="attribute_id" multiple>
                    @foreach($attributes as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div id="attribute-section">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <input type="text" class="form-control attr-name" value="{{ $product->attribute->first()->attribute->name }}" readonly>
                    </div>
                    <div class="col-lg-8">
                        <input type="text" name="attribute_tag[]" class="form-control tags" value="{{ $product->attribute->first()->value }}">
                    </div>
                </div>
            </div>

            <h4 class="mb-3 mt-4">Price & Stock</h4>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Unit Price<span> *</span></label>
                        <input type="number" name="unit_price" placeholder="0.00" class="form-control unit-price" value="{{ $product->price->unit_price}}">
                        <span class="text-danger">{{ $errors->first('unit_price') }}</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Purchase Price<span> *</span></label>
                        <input type="number" name="purchase_price" placeholder="0.00" class="form-control" value="{{ $product->price->purchase_price}}">
                        <span class="text-danger">{{ $errors->first('purchase_price') }}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="">Tax Percentage (%)</label>
                        <input type="number" name="tax" placeholder="Enter tax percentage" class="form-control" value="{{ $product->price->tax}}">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="">Discount<span> *</span></label>
                        <input type="number" name="discount" class="form-control" placeholder="0.00" value="{{ $product->price->discount }}">
                        <span class="text-danger">{{ $errors->first('discount') }}</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="">Discount Type</label>
                        {!! Form::select('discount_type', getDiscountType(), $product->price->discount_type, ['class' => 'form-select form-control', 'placeholder' => 'Select Discount Type']) !!}
                    </div>
                </div>
            </div>
            <div class="variation-table" {{$product->variant ? 'style="display: block"' : 'style="display: none"'}}>
                <h4 class="mb-3 mt-4">Product Variations</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Variation</th>
                        <th>Unit Price</th>
                        <th>Sku</th>
                        <th>Quantity</th>
                    </tr>
                    </thead>
                    <tbody id="variant-section">
                        @if($product->variant)
                            @foreach($product->variant as $variant)
                            <tr>
                                <td><input type="text" name="variation_name[]" class="form-control variation_name" readonly value="{{ $variant->variant }}"></td>
                                <td><input type="number" name="variation_price[]" class="form-control variation_price" value="{{ $variant->variant_price }}"></td>
                                <td><input type="text" name="variation_sku[]" class="form-control variation_sku" readonly value="{{ $variant->sku }}"></td>
                                <td><input type="number" name="variation_quantity[]" class="form-control variation_quantity" value="{{ $variant->quantity }}"></td>
                            </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Total Quantity</label>
                        <input type="number" name="quantity" placeholder="0.00" class="form-control total-quantity" value="{{ $product->price->quantity}}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Shipping Cost</label>
                        <input type="number" name="shipping_cost" placeholder="0.00" class="form-control" value="{{ $product->price->shipping_cost}}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" placeholder="Enter Image" id="">
                <span class="text-danger">{{ $errors->first('image') }}</span>
            </div>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-lg-10 offset-md-1">
                    <div class="form-submit d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary" onclick="formSubmit(this, event)">Save</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <template id="attributeTemplate">
        <div class="form-group row">
            <div class="col-lg-4">
                <input type="text" class="form-control attr-name" value="" readonly>
            </div>
            <div class="col-lg-8">
                <input type="text" name="attribute_tag[]" class="form-control tags" data-attribute>
            </div>
        </div>
        <script>
            $('.tags').tagsInput({
                'width': '100%',
                'height': '100%',
                'interactive': true,
                'defaultText': 'Add More',
                'removeWithBackspace': true,
                'minChars': 0,
                'maxChars': 20,
                'placeholderColor': '#666666'
            });
        </script>
    </template>
    <template id="variantTemplate">
        <tr>
            <td><input type="text" name="variation_name[]" class="form-control variation_name" readonly></td>
            <td><input type="number" name="variation_price[]" class="form-control variation_price"></td>
            <td><input type="text" name="variation_sku[]" class="form-control variation_sku" readonly></td>
            <td><input type="number" name="variation_quantity[]" class="form-control variation_quantity"></td>
        </tr>
    </template>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers:{
                    'x-csrf-token' : $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
        (function ($) {
            "use-strict"


            $(document).ready(function() {
                const allAttributes = @json($attributes)


                $('.tags').tagsInput({
                'width': '100%',
                'height': '100%',
                'interactive': true,
                'defaultText': 'Add More',
                'removeWithBackspace': true,
                'minChars': 0,
                'maxChars': 20,
                'placeholderColor': '#666666'
            });

                $('.attribute-select2').select2({
                    placeholder: "Select Attribute",
                    maximumSelectionLength: 1,
                    allowClear: true
                });


                $(document).on('change', '#attribute_id', function () {
                    const attribute_ids = $('#attribute_id').val();
                    let services = [];
                    $.each(attribute_ids, function(key, value) {
                      service = allAttributes.find((item) => {
                            return item.id == value
                        });
                        services.push(service)
                    });

                    const attributeTemplate = document.getElementById('attributeTemplate');
                    const attributeElement = document.getElementById('attribute-section');

                    if (services && services.length > 0) {
                        $('#attribute-section').html('');
                        for(const attribute of services) {
                            const serviceEl = document.importNode(attributeTemplate.content, true)
                            serviceEl.querySelector('.attr-name').setAttribute('value', attribute.name)
                            serviceEl.querySelector('.tags').setAttribute('data-attribute', attribute.id)
                            attributeElement.append(serviceEl)
                            // $('#attribute-section').append('<div class="form-group row"> <div class="col-lg-4"> <input type="text" class="form-control attr-name" value="'+ attribute.name +'" readonly></div><div class="col-lg-8"> <input type="text" name="attribute_tag[]" class="form-control tags" data-role="taginputs"> </div></div>');
                        }
                    } else {
                        $('#attribute-section').html('');
                    }

                });


                $(document).on('keyup', '.tags', function () {
                    var variation_name = $('input[name="attribute_tag[]"]').val();
                    let variations = variation_name.split(',')
                    const attr_ids = $('#attribute_id').val();
                    let unit_price = $('.unit-price').val();
                    let servics = [];
                    $.each(attr_ids, function(key, value) {
                      service = allAttributes.find((item) => {
                            return item.id == value
                        });
                        servics.push(service)
                    });
                    const variantTemplate = document.getElementById('variantTemplate');
                    const variantElement = document.getElementById('variant-section');

                    let total_quantity = 0;
                    if (servics && servics.length > 0) {
                        $('#variant-section').html('');
                        for(const varient of servics) {
                            for(const vari of variations) {
                                const var2 = document.importNode(variantTemplate.content, true)
                                var2.querySelector('.variation_name').setAttribute('value', vari)
                                var2.querySelector('.variation_price').setAttribute('value', unit_price)
                                var2.querySelector('.variation_sku').setAttribute('value', varient.name+'-'+vari)
                                var2.querySelector('.variation_quantity').setAttribute('value', 1)
                                variantElement.append(var2)
                                total_quantity = total_quantity+1
                            }
                        }
                    } else {
                        $('#variant-section').html('');
                    }
                    $(".total-quantity").val(total_quantity);
                    $(".variation-table").css({"display": "block"});
                });


                $(document).on('keyup', '.unit-price', function () {
                    var variation_name = $('input[name="attribute_tag[]"]').val();
                    let variations = variation_name.split(',')
                    const attr_ids = $('#attribute_id').val();
                    let unit_price = $(this).val();
                    let servics = [];
                    $.each(attr_ids, function(key, value) {
                      service = allAttributes.find((item) => {
                            return item.id == value
                        });
                        servics.push(service)
                    });
                    const variantTemplate = document.getElementById('variantTemplate');
                    const variantElement = document.getElementById('variant-section');

                    if (servics && servics.length > 0) {
                        $('#variant-section').html('');
                        for(const varient of servics) {
                            for(const vari of variations) {
                                const var2 = document.importNode(variantTemplate.content, true)
                                var2.querySelector('.variation_name').setAttribute('value', vari)
                                var2.querySelector('.variation_price').setAttribute('value', unit_price)
                                var2.querySelector('.variation_sku').setAttribute('value', varient.name+'-'+vari)
                                var2.querySelector('.variation_quantity').setAttribute('value', 1)
                                variantElement.append(var2)
                            }
                        }
                    } else {
                        $('#variant-section').html('');
                    }
                    $(".variation-table").css({"display": "block"});
                });


                $('#parent_category').on('change', function(e) {
                    var cat_id = e.target.value;
                    $.ajax({
                        url: "{{ route('get.sub-categories') }}",
                        type: "POST",
                        data: {
                            cat_id: cat_id
                        },
                        success: function(data) {
                            $('#sub_category').empty();
                            $('#sub_category').append('<option>--select--</option>');
                            $.each(data.data, function(index, subcategory) {
                                $('#sub_category').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                            })
                        }
                    })
                });


                $('#sub_category').on('change', function(e) {
                    var cat_id = e.target.value;
                    $.ajax({
                        url: "{{ route('get.sub-sub-categories') }}",
                        type: "POST",
                        data: {
                            cat_id: cat_id
                        },
                        success: function(data) {
                            $('#sub_sub_category').empty();
                            $('#sub_sub_category').append('<option>--select--</option>');
                            $.each(data.data, function(index, subcategory) {
                                $('#sub_sub_category').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                            })
                        }
                    })
                });
            });



        }(jQuery))
    </script>
@endpush

