@extends('layouts.app')
@section('title')
    Đăng ký
@endsection
@section('content')
<section id="SignUp">
    <div class="container">
        <div class="signup-content row">
            <div class="signup-form col-12 col-md-6">
                <h2 class="form-title">Đăng ký</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group row">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" required autocomplete="name" autofocus placeholder="Tên tài khoản">
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
                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                            </div>
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email" autofocus placeholder="E-mail">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock-alt"></i></span>
                            </div>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Mật khẩu">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-lock-alt"></i></span>
                            </div>
                            <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="Nhập lại mật khẩu">
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <button type="submit" class="btn btn-primary">
                                {{ __('Đăng ký') }}
                            </button>
                    </div>
                    <div class="form-group mb-0">
                        <a href="{{ route('login') }}" class="signin-link">Đã có tài khoản</a>
                    </div>
                </form>
            </div>
            <div class="signup-image col-12 col-md-6" style="background-image: url({{ asset('img/up.jpg') }})">
            </div>
        </div>
    </div>
</section>
@endsection
