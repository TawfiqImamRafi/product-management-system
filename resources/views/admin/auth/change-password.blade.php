@extends('layouts.base')

@section('content')
    <div class="box">
        <div class="box-header">
            <div class="box-title">
                <h4>Update password</h4>
            </div>
        </div>
        {!! Form::open(['route' => 'admin.update.password', 'method' => 'POST']) !!}
        <div class="box-body">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="form-group row">
                        <label for="" class="col-form-label col-md-5">Current Password <span>*</span></label>
                        <div class="col-md-7">
                            <input type="password" name="current_password" class="form-control" placeholder="********">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-form-label col-md-5">New Password <span>*</span></label>
                        <div class="col-md-7">
                            <input type="password" name="password" class="form-control" placeholder="********">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-form-label col-md-5">Confirm New Password <span>*</span></label>
                        <div class="col-md-7">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="*******">
                            <span class="text-danger"></span>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <button type="submit" onclick="formSubmit(this, event)" class="btn btn-success">Update Password</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer"></div>
        {!! Form::close() !!}
    </div>
@endsection


