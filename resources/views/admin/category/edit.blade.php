@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title">
                        <h4>Edit Category</h4>
                    </div>
                    <div class="box-action">
                        <a href="{{ route('category.list') }}" class="btn btn-sm btn-secondary">Category List</a>
                    </div>
                </div>
                <div class="box-body">
                    {!! Form::open(['route' => ['category.update', $category->id], 'method' => 'PUT']) !!}
                    <div class="form-group">
                        <label for="">Name<span> *</span></label>
                        <input type="text" name="name" placeholder="Enter Name" id="" class="form-control" value="{{ $category->name }}">
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea type="tel" name="description" id="" rows="5" placeholder="Enter description" class="form-control">{{ $category->description }}</textarea>
                    </div>
                    <div class="form-submit">
                        <button type="submit" class="btn btn-primary" onclick="formSubmit(this, event)">Update</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
