@extends('layouts.base')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">
                <h4>Create Product</h4>
            </div>
            <div class="box-action">
                <a href="{{ route('product.list') }}" class="btn btn-sm btn-secondary">Product List</a>
            </div>
        </div>
        {!! Form::open(['route' => 'product.store', 'method' => 'POST']) !!}
        <div class="box-body">
            <input type="hidden" name="admin_id" value="{{ Auth::guard('admin')->user()->id }}">
            <div class="form-group">
                <label for="">Name<span> *</span></label>
                <input type="text" name="name" placeholder="Enter Name" id="cat_name" class="form-control">
                <span class="text-danger">{{ $errors->first('name') }}</span>
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <textarea name="description" rows="5" placeholder="Enter description" class="form-control"></textarea>
                <span class="text-danger">{{ $errors->first('description') }}</span>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="">Category</label>
                        <input type="text" name="name" placeholder="Enter Name" id="cat_name" class="form-control">
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="">Sub Category</label>
                        <input type="text" name="name" placeholder="Enter Name" id="cat_name" class="form-control">
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="">Sub Sub Category</label>
                        <input type="text" name="name" placeholder="Enter Name" id="cat_name" class="form-control">
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Brand</label>
                        <input type="text" name="name" placeholder="Enter Name" id="cat_name" class="form-control">
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Unit</label>
                        <input type="text" name="name" placeholder="Enter Name" id="cat_name" class="form-control">
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Unit Price</label>
                        <input type="text" name="name" placeholder="Enter Name" id="cat_name" class="form-control">
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="">Purchase Price</label>
                        <input type="text" name="name" placeholder="Enter Name" id="cat_name" class="form-control">
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
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
