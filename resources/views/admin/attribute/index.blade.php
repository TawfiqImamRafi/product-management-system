@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title">
                        <h4>Create New Attribute</h4>
                    </div>
                </div>
                <div class="box-body">
                    <form id="attributeForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Name<span> *</span></label>
                            <input type="text" name="name" placeholder="Enter Name" id="" class="form-control">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
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
                        <h4>Attribute List</h4>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="attribute-list">
                        @if($attributes)
                            @foreach ($attributes as $key => $attribute)
                                <tr id='item-{{ $attribute->id }}'>
                                    <td>{{ $attribute->id }}</td>
                                    <td>{{ $attribute->name }}</td>
                                    <td>
                                        <div class='action'>
                                            <button type="button" id="attributeEdit" data-id="{{ $attribute->id }}" class="btn btn-sm btn-outline-warning"><i class='bx bx-edit'></i></button>
                                            <button type="button" id="attributeDelete" data-id="{{ $attribute->id }}" class="btn btn-sm btn-outline-danger"><i class='bx bx-trash'></i></button>
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
          <h5 class="modal-title" id="exampleModalLabel">Edit Attribute</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="attributeEditForm" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="attribute_id"  id="attribute_id">
                <div class="form-group">
                    <label for="">Name<span> *</span></label>
                    <input type="text" name="name" placeholder="Enter Name" id="attribute_name" class="form-control">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
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
            $("#attributeForm").submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                console.log(formData);

                $.ajax("{{ route('attribute.store') }}",{
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
                            //     row += '<td>' + '<img src="{{asset('data.logo')}}" alt="" height="50px" width="50px">' + '</td>';
                            //     row += '<td>' + data.name + '</td>';
                            // row += '<td>' + '<div class="action">' + '<button type="button" id="brandEdit" data-slug="' + data.slug +'" class="btn btn-sm btn-outline-warning">'+'<i class="bx bx-edit">'+'</i>'+'</button>' + '<button type="button" id="brandDelete" data-slug="' + data.slug +'" class="btn btn-sm btn-outline-danger">'+'<i class="bx bx-trash">'+'</i>'+'</button>' + '</div>' + '</td>';
                            //     if($("#id").val()){
                            //         $("#item-" + data.id).replaceWith(row);
                            //     }else{
                            //         $("#cat-list").prepend(row);
                            //     }

                                $("#attributeForm").trigger('reset');
                        }
                    },
                })
            });


            $('body').on('click', '#attributeDelete', function () {
                    var id = $(this).data('id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3c9a40',
                        cancelButtonColor: '#4c4c4c',
                        confirmButtonText: 'Yes, delete it!'
                    }).then(function (stat) {
                    
                    $.ajax({
                        type:"POST",
                        url: "{{ route('attribute.destroy') }}",
                        data: { id: id },
                        dataType: 'json',
                        beforeSend: function () {
                            $(this).attr('disabled', 'disabled');
                            $(this).html('<i class="fa fa-spinner fa-spin"></i>');
                        },
                        success: function(res){                                                  
                            $("#item-" + id).remove();                    
                        }
                    });
                });
            });


            $('body').on('click', '#attributeEdit', function () {
                var id = $(this).data('id');

                $.ajax({
                    type:"POST",
                    url: "{{ route('attribute.edit') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                    console.log(res);
                    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'))
                    myModal.show()
                    $('#attribute_id').val(res.id);
                    $('#attribute_name').val(res.name);
                }
                });
            });


            $("#attributeEditForm").submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax("{{ route('attribute.update') }}",{
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
                            //     row += '<td>' + '<img src="{{asset("' + data.logo + '")}}" alt="" height="50px" width="50px">' + '</td>';
                            //     row += '<td>' + data.name + '</td>';
                            // row += '<td>' + '<div class="action">' + '<button type="button" id="brandEdit" data-slug="' + data.slug +'" class="btn btn-sm btn-outline-warning">'+'<i class="bx bx-edit">'+'</i>'+'</button>' + '<button type="button" id="brandDelete" data-slug="' + data.slug +'" class="btn btn-sm btn-outline-danger">'+'<i class="bx bx-trash">'+'</i>'+'</button>' + '</div>' + '</td>';
                            //     if($("#id").val()){
                            //         $("#item-" + data.slug).replaceWith(row);
                            //     }else{
                            //         $("#cat-list").prepend(row);
                            //     }

                                $("#brandEditForm").trigger('reset');
                        }
                    },
                })
            });



        }(jQuery))
    </script>
@endpush
