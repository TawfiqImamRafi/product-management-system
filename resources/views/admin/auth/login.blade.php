@extends('layouts.app')

@section('content')
<div class="login-container">
    <div class="login-content">
        <div class="login-header">
            <div class="logo">
                <img src="{{ asset('assets/images/elearning-logo.svg') }}" alt="">
                <h5>Login to access your panel!!</h5>
            </div>
        </div>
        <div class="login-body">
            {!! Form::open(['route' => 'admin.login.submit', 'method' => 'POST']) !!}
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bx bx-user"></i>
                        </span>
                        <input id="email" type="text" placeholder="Enter email or username" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bx bx-key"></i>
                        </span>
                        <input id="password" type="password" placeholder="********" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="rem_me" {{ old('remember') ? 'checked' : '' }}>
                        <label for="rem_me">Remember Me</label>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-success w-100" type="submit">Log In</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
