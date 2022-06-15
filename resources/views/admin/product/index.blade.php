@extends('layouts.base')

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-title">
                <h4>Product List</h4>
            </div>
            <div class="box-action">
                <a href="{{ route('product.create') }}" class="btn btn-sm btn-secondary">Create New</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Category</th>
                    <th>Variant</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if($products)
                    @foreach ($products as $key => $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td style="width: 100px">
                            @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="">
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->slug }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ $product->variant->count() }}</td>
                        <td>{{ $product->price->unit_price }}</td>
                        <td>{!! styleStatus($product->is_active)!!}</td>
                        <td>
                            <div class="action">
                                <a href="{{ route('product.edit', $product->slug) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bx bx-edit"></i>
                                </a>
                                {!! Form::open(['route' => ['product.destroy', $product->slug], 'method' => 'DELETE']) !!}
                                <button type="submit" onclick="deleteSubmit(this, event)" class="btn btn-sm btn-outline-danger">
                                    <i class="bx bx-trash"></i>
                                </button>
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="box-footer">
        </div>
    </div>
@endsection
