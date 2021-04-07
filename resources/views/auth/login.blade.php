@extends('layouts.app')
@section('title')
    Đăng nhập
@endsection
@section('content')
<section id="SignIn">
    <div class="container">
        <div class="signin-content row">
            <div class="signin-image col-12 col-md-6" style="background-image: url({{ asset('img/in.jpg') }})">
            </div>
            <div class="signin-form col-12 col-md-6">
                <h2 class="form-title">Đăng nhập</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Tên đăng nhập">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="Mật khẩu">
                        </div>
                    </div>
                    <div class="form-group form-checkbox">
                        <input type="checkbox" name="remember" id="remember" class="agree-term">
                        <label for="remember" class="label-agree-term"><span><span></span></span>{{ __('Ghi nhớ') }}</label>
                    </div>
                    <div class="form-group row mb-0">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Đăng nhập') }}
                        </button>
                    </div>
                    <div class="form-group mb-0">
                        <a href="{{ route('forgot-password') }}" class="forgot-pwd-link">{{ __('Quên mật khẩu?') }}</a>
                        <br>
                        <a href="{{ route('register') }}" class="signup-link">Đăng ký</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
