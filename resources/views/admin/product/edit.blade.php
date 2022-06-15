@extends('layouts.base')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                <h4>Update Product</h4>
            </div>
            <div class="box-action">
                <a href="{{ route('product.list') }}" class="btn btn-sm btn-secondary">Product List</a>
            </div>
        </div>
        {!! Form::open(['route' => ['product.update', $product->id], 'method' => 'PUT']) !!}
        <div class="box-body">
            <div class="row">
                <div class="col-lg-10 offset-md-1">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-4">Subject</label>
                        <div class="col-lg-8">
                            {!! Form::select('subject_id', selectOptions($subjects), null, ['class' => 'form-select form-control', 'placeholder' => 'Select Subject']) !!}
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-4">Product Title</label>
                        <div class="col-lg-8">
                            <textarea name="question" id="" rows="5" placeholder="Enter description" class="form-control"></textarea>
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-4">Duration</label>
                        <div class="col-lg-8">
                            <input type="text" name="duration" class="form-control" placeholder="Product Duration">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-4">Total Marks</label>
                        <div class="col-lg-8">
                            <input type="number" name="total_mark" class="form-control" placeholder="Total mark">
                            <span class="text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-4"></label>
                        <div class="col-lg-8">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="negative_marking">
                                <span class="ml-2">Is Negative Marking?</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-4">Negative Mark</label>
                        <div class="col-lg-8">
                            <input type="number" name="negative_mark" class="form-control" placeholder="0">
                            <span class="text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-4"></label>
                        <div class="col-lg-8">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" name="is_paid">
                                <span class="ml-2">is Paid?</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-4">Price</label>
                        <div class="col-lg-8">
                            <input type="number" name="price" class="form-control" placeholder="0.00">
                            <span class="text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-4">Discount Type</label>
                        <div class="col-lg-8">
                            <div class="d-flex justify-content-start align-items-center gap-4">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="discount_type" value="percentage" checked>
                                    <span class="ml-2">Discount in Percentage (%)</span>
                                </label>
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="discount_type" value="flat">
                                    <span class="ml-2">Discount in Flat</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-4">Discount</label>
                        <div class="col-lg-8">
                            <input type="number" name="discount" class="form-control" placeholder="0.00">
                            <span class="text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-4">Thumbnail</label>
                        <div class="col-lg-8">
                            <input type="file" name="thumbnail" placeholder="Enter Image" id="">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-lg-10 offset-md-1">
                    <div class="form-submit d-flex justify-content-end align-items-center">
                        <button type="submit" class="btn btn-primary" onclick="formSubmit(this, event)">Save & Continue</button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
