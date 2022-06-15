@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title">
                        <h4>Create New Brand</h4>
                    </div>
                </div>
                <div class="box-body">
                    <form id="brandForm" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Name<span> *</span></label>
                            <input type="text" name="name" placeholder="Enter Name" id="" class="form-control">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="">Logo</label>
                            <input type="file" name="logo" class="form-control" id="image-input">
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
                        <h4>Brand List</h4>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Logo</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="brand-list">
                        @if($brands)
                            @foreach ($brands as $key => $brand)
                                <tr id='item-{{ $brand->slug }}'>
                                    <td>{{ $brand->id }}</td>
                                    <td><img src="{{ $brand->logo ? asset($brand->logo): "/assets/img/no-image.png" }}" alt="" height="50px" width="50px"></td>
                                    <td>{{ $brand->name }}</td>
                                    <td>
                                        <div class='action'>
                                            <button type="button" id="brandEdit" data-slug="{{ $brand->slug }}" class="btn btn-sm btn-outline-warning"><i class='bx bx-edit'></i></button>
                                            <button type="button" id="brandDelete" data-slug="{{ $brand->slug }}" class="btn btn-sm btn-outline-danger"><i class='bx bx-trash'></i></button>
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
          <h5 class="modal-title" id="exampleModalLabel">Edit Brand</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="brandEditForm" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="slug"  id="brand_slug">
                <div class="form-group">
                    <label for="">Name<span> *</span></label>
                    <input type="text" name="name" placeholder="Enter Name" id="brand_name" class="form-control">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>
                <div class="form-group">
                    <label for="">Logo</label>
                    <input type="file" name="logo" class="form-control" id="brand_img">
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
            $("#brandForm").submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                console.log(formData);

                $.ajax("{{ route('brand.store') }}",{
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
                            // console.log(JSON.stringify(data.logo))
                            //  var row = '<tr id="item-'+ data.slug + '">';
                            //      row += '<td>' + data.id + '</td>';
                            //      row += '<td>' + '<img src="' + data.logo +'" alt="" height="50px" width="50px">' + '</td>';
                            //      row += '<td>' + data.name + '</td>';
                            //  row += '<td>' + '<div class="action">' + '<button type="button" id="brandEdit" data-slug="' + data.slug +'" class="btn btn-sm btn-outline-warning">'+'<i class="bx bx-edit">'+'</i>'+'</button>' + '<button type="button" id="brandDelete" data-slug="' + data.slug +'" class="btn btn-sm btn-outline-danger">'+'<i class="bx bx-trash">'+'</i>'+'</button>' + '</div>' + '</td>';
                            //      if($("#id").val()){
                            //          $("#item-" + data.id).replaceWith(row);
                            //      }else{
                            //          $("#brand-list").prepend(row);
                            //      }

                                $("#brandForm").trigger('reset');
                        }
                    },
                })
            });


            $('body').on('click', '#brandDelete', function () {
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
                                type: "POST",
                                url: "{{ route('brand.destroy') }}",
                                data: {slug: slug},
                                dataType: 'json',
                                beforeSend: function () {
                                    $(this).attr('disabled', 'disabled');
                                    $(this).html('<i class="fa fa-spinner fa-spin"></i>');
                                },
                                success: function (res) {
                                    $("#item-" + slug).remove();
                                },
                                complete: function () {
                                    $(this).removeAttr('disabled');
                                }
                            });
                        }
                });
            });


            $('body').on('click', '#brandEdit', function () {
                var slug = $(this).data('slug');

                $.ajax({
                    type:"POST",
                    url: "{{ route('brand.edit') }}",
                    data: { slug: slug },
                    dataType: 'json',
                    success: function(res){
                    console.log(res);
                    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'))
                    myModal.show()
                    $('#brand_slug').val(res.slug);
                    $('#brand_name').val(res.name);
                }
                });
            });


            $("#brandEditForm").submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax("{{ route('brand.update') }}",{
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
