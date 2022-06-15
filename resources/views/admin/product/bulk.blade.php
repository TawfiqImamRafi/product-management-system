@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title">
                        <h4>Bulk Product Upload</h4>
                    </div>
                </div>
                <div class="box-body">
                    <form action="{{ route('bulk.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Bulk File</label>
                            <input type="file" name="bulk_file" class="form-control" required>
                        </div>
                        <div class="form-submit">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
