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
                    <th>Thumbnail</th>
                    <th>Q.Name</th>
                    <th>Subject</th>
                    <th>Questions</th>
                    <th>Duration</th>
                    <th>Question Type</th>
                    <th>Price</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @if($productzes)
                    @foreach ($productzes as $key => $product)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td style="width: 100px">
                            @if($product->thumbnail)
                                <img src="{{ asset($product->thumbnail) }}" alt="">
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->subject->name }}</td>
                        <td class="text-center">{{ $product->questions->count() }}</td>
                        <td>{{ $product->duration }}</td>
                        <td>{{ $product->product_type }}</td>
                        <td>{{ $product->price }}</td>
                        <td>
                            <div class="action">
                                <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bx bx-edit"></i>
                                </a>
                                {!! Form::open(['route' => ['product.destroy', $product->id], 'method' => 'DELETE']) !!}
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
            {{ $productzes->links() }}
        </div>
    </div>
@endsection
