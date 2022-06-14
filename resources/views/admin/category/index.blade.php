@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title">
                        <h4>Create New Category</h4>
                    </div>
                </div>
                <div class="box-body">
                    <form id="catForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">Name<span> *</span></label>
                            <input type="text" name="name" placeholder="Enter Name" id="" class="form-control">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="">Priority</label>
                            {!! Form::select('priority', getPriority(), null, ['class' => 'form-select form-control', 'placeholder' => 'Select Priority']) !!}
                        </div>
                        <div class="form-submit">
                            <button type="submit" class="btn btn-primary" id="add">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        <h4>Category List</h4>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Priority</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="cat-list">
                        @if($categories)
                            @foreach ($categories as $key => $category)
                                <tr id='item-{{ $category->id }}'>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->priority }}</td>
                                    <td>
                                        <div class='action'>
                                            <button type="button" id="catEdit" data-slug="{{ $category->slug }}" class="btn btn-sm btn-outline-warning"><i class='bx bx-edit'></i></button>
                                            <button type="button" id="catDelete" data-slug="{{ $category->slug }}" class="btn btn-sm btn-outline-danger"><i class='bx bx-trash'></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class='box-footer'></div>
            </div>
        </div>
    </div>
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
            $("form").on('submit',function(e){
                e.preventDefault();
                // let formData = new FormData(this);

                $.ajax("{{ route('category.store') }}",{
                    // url:"category/store",
                    // data: formData,
                    data: $("#catForm").serialize(),
                    type:'POST',
                    enctype: 'multipart/form-data',
                    dataType: 'JSON',
                    success: function(data) {
                        console.log(data)
                        if ((data.errors)) {
                            if (data.errors) {
                                $.each(data.errors, function (index, error) {
                                    $("[name=" + index + "]").parents('.form-group').find('.text-danger').text(error);
                                    $("[name=" + index + "]").parent().addClass('has-error');
                                    $('form').find("." + index).text(error);
                                });
                            }
                        }
                        else {
                            var row = '<tr id="item-'+ data.id + '">';
                                row += '<td>' + data.id + '</td>';
                                row += '<td>' + data.name + '</td>';
                                row += '<td>' + data.priority + '</td>';
                                // row += '<td>' + '<button type="button" id="edit_todo" data-id="' + data.id +'" class="btn btn-info btn-sm mr-1">Edit</button>' + '<button type="button" id="delete_todo" data-id="' + data.id +'" class="btn btn-danger btn-sm">Delete</button>' + '</td>';
                            row += '<td>' + '<div class="action">' + '<button type="button" id="catEdit" data-slug="' + data.slug +'" class="btn btn-sm btn-outline-warning">'+'<i class="bx bx-edit">'+'</i>'+'</button>' + '<button type="button" id="catDelete" data-slug="' + data.slug +'" class="btn btn-sm btn-outline-danger">'+'<i class="bx bx-trash">'+'</i>'+'</button>' + '</div>' + '</td>';
                                if($("#id").val()){
                                    $("#item-" + data.id).replaceWith(row);
                                }else{
                                    $("#cat-list").prepend(row);
                                }

                                $("#catForm").trigger('reset');
                        }
                    },
                })
            });
        }(jQuery))
    </script>
@endpush
