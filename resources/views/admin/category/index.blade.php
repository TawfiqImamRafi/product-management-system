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
                    <form id="catForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Name<span> *</span></label>
                            <input type="text" name="name" placeholder="Enter Name" id="" class="form-control">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="">Priority</label>
                            {!! Form::select('priority', getPriority(), null, ['class' => 'form-select form-control', 'placeholder' => 'Select Priority']) !!}
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" name="thumbnail" class="form-control" id="image-input">
                            <span class="text-danger"></span>
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
                            <th>Image</th>
                            <th>Name</th>
                            <th>Priority</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="cat-list">
                        @if($categories)
                            @foreach ($categories as $key => $category)
                                <tr id='item-{{ $category->slug }}'>
                                    <td>{{ $category->id }}</td>
                                    <td><img src="{{ $category->thumbnail ? asset($category->thumbnail): "/assets/img/no-image.png" }}" alt="" height="50px" width="50px"></td>
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
    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="catEditForm" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="slug"  id="cat_slug">
                <div class="form-group">
                    <label for="">Name<span> *</span></label>
                    <input type="text" name="name" placeholder="Enter Name" id="cat_name" class="form-control">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group">
                    <label for="">Priority</label>
                    {!! Form::select('priority', getPriority(), null, ['class' => 'form-select form-control', 'placeholder' => 'Select Priority', 'id' => 'cat_priority']) !!}
                </div>
                <div class="form-group">
                    <label for="">Image</label>
                    <input type="file" name="thumbnail" class="form-control" id="cat_img">
                    <span class="text-danger"></span>
                </div>
                <div class="form-submit">
                    <button type="submit" class="btn btn-primary" id="add">Update</button>
                </div>
            </form>
        </div>
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
            $("#catForm").submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax("{{ route('category.store') }}",{
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    enctype: 'multipart/form-data',
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
                            window.location.reload();
                            // var row = '<tr id="item-'+ data.slug + '">';
                            //     row += '<td>' + data.id + '</td>';
                            //     row += '<td>' + '<img src="{{asset('data.thumbnail')}}" alt="" height="50px" width="50px">' + '</td>';
                            //     row += '<td>' + data.name + '</td>';
                            //     row += '<td>' + data.priority + '</td>';
                            // row += '<td>' + '<div class="action">' + '<button type="button" id="catEdit" data-slug="' + data.slug +'" class="btn btn-sm btn-outline-warning">'+'<i class="bx bx-edit">'+'</i>'+'</button>' + '<button type="button" id="catDelete" data-slug="' + data.slug +'" class="btn btn-sm btn-outline-danger">'+'<i class="bx bx-trash">'+'</i>'+'</button>' + '</div>' + '</td>';
                            //     if($("#id").val()){
                            //         $("#item-" + data.id).replaceWith(row);
                            //     }else{
                            //         $("#cat-list").prepend(row);
                            //     }

                                $("#catForm").trigger('reset');
                        }
                    },
                })
            });


            $('body').on('click', '#catDelete', function () {
                    var slug = $(this).data('slug');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3c9a40',
                        cancelButtonColor: '#4c4c4c',
                        confirmButtonText: 'Yes, delete it!'
                    }).then(function (stat) {
                    if (stat.value != undefined && stat.value) {
                    $.ajax({
                        type:"POST",
                        url: "{{ route('category.destroy') }}",
                        data: { slug: slug },
                        dataType: 'json',
                        beforeSend: function () {
                            $(this).attr('disabled', 'disabled');
                            $(this).html('<i class="fa fa-spinner fa-spin"></i>');
                        },
                        success: function(res){
                            $("#item-" + slug).remove();
                        },
                    complete: function () {
                                    $(this).removeAttr('disabled');
                                }
                            });
                        }
                });
            });


            $('body').on('click', '#catEdit', function () {
                var slug = $(this).data('slug');

                $.ajax({
                    type:"POST",
                    url: "{{ route('category.edit') }}",
                    data: { slug: slug },
                    dataType: 'json',
                    success: function(res){
                    console.log(res);
                    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'))
                    myModal.show()
                    $('#cat_slug').val(res.slug);
                    $('#cat_name').val(res.name);
                    $('#cat_priority').val(res.priority);
                }
                });
            });


            $("#catEditForm").submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax("{{ route('category.update') }}",{
                    method: 'post',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    enctype: 'multipart/form-data',
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
                            window.location.reload();
                            // $('#item-'+data.slug).html('<td>Bar</td>');
                            // var row = '<tr id="item-'+ data.slug + '">';
                            //     row += '<td>' + data.id + '</td>';
                            //     row += '<td>' + '<img src="{{asset("' + data.thumbnail + '")}}" alt="" height="50px" width="50px">' + '</td>';
                            //     row += '<td>' + data.name + '</td>';
                            //     row += '<td>' + data.priority + '</td>';
                            // row += '<td>' + '<div class="action">' + '<button type="button" id="catEdit" data-slug="' + data.slug +'" class="btn btn-sm btn-outline-warning">'+'<i class="bx bx-edit">'+'</i>'+'</button>' + '<button type="button" id="catDelete" data-slug="' + data.slug +'" class="btn btn-sm btn-outline-danger">'+'<i class="bx bx-trash">'+'</i>'+'</button>' + '</div>' + '</td>';
                            //     if($("#id").val()){
                            //         $("#item-" + data.slug).replaceWith(row);
                            //     }else{
                            //         $("#cat-list").prepend(row);
                            //     }

                                $("#catEditForm").trigger('reset');
                        }
                    },
                })
            });



        }(jQuery))
    </script>
@endpush
