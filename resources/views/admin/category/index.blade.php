@extends('layouts.base')

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-title">
                <h4>Category List</h4>
            </div>
            <div class="box-action">
                <a href="{{ route('category.create') }}" class="btn btn-sm btn-secondary">Create New</a>
            </div>
        </div>
        <div class="box-body">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($categories)
                    @foreach ($categories as $key => $category)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        {{-- @if($category->thumbnail)
                            <td><img src="{{ asset($category->thumbnail) }}" alt="" height="50px" width="50px"></td>
                        @else
                            <td> <img src="/assets/img/no-image.png" width="50px" height="50px"> </td>
                        @endif --}}
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <div class="action">
                                <a href="{{ route('category.edit', $category->slug) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bx bx-edit"></i>
                                </a>
                                {!! Form::open(['route' => ['category.destroy', $category->slug], 'method' => 'DELETE']) !!}
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
        <div class="box-footer"></div>
    </div>
@endsection
