@extends('layouts.app')
@section('title')
    Hồ sơ cá nhân
@endsection
@section('content')
<div class="container">
    <div class="user-profile">
    <div class="header text-center">
        <div class="avatar">
            <img src="{{ $user->profile_photo_path }}" alt="{{ $user->slug }}" width="80" height="80" class="rounded-circle">
        </div>
        <div class="title">
            <p>{{ $user->name }}</p>
        </div>
        <div class="created_at">
            <u><p>Ngày tham gia: {{ $user->dmy_created_at }}</p></u>
        </div>
    </div>
    <div class="body col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h5>Thay đổi ảnh đại diện</h5>
                </div>
            </div>
            <div class="card-body">
                <div class="des-avt">
                    <a href="{{ route('client.user.delavt') }}">Xóa ảnh hiện tại</a>
                </div>
                <form action="{{ route('client.user.udtavt.request') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="u_avt" class="col-md-4 col-form-label text-md-right">{{ __('Thay đổi') }}</label>
                        <div class="col-md-6">
                            <input id="u_avt" type="file" class="form-control-file @error('u_avt') is-invalid @enderror" name="u_avt" accept="image/*" required>
                            @error('u_avt')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h5>Thông tin cá nhân</h5>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('client.user.udtinfo.request') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tên hiển thị') }}</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="name" value="{{ $user->name }}" required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="u_c_pwd" class="col-md-4 col-form-label text-md-right">{{ __('Nhập mật khẩu') }}</label>
                        <div class="col-md-6">
                            <input id="u_c_pwd" type="password" class="form-control @error('u_c_pwd') is-invalid @enderror" name="u_c_pwd" required>
                            @error('u_c_pwd')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h5>Bảo mật</h5>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('client.user.udtpwd.request') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label for="u_pwd" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu hiện tại') }}</label>
                        <div class="col-md-6">
                            <input id="u_pwd" type="password" class="form-control @error('u_pwd') is-invalid @enderror" name="u_pwd" required>
                            @error('u_pwd')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="u_npwd" class="col-md-4 col-form-label text-md-right">{{ __('Mật khẩu mới') }}</label>
                        <div class="col-md-6">
                            <input id="u_npwd" type="password" class="form-control @error('u_npwd') is-invalid @enderror" name="u_npwd" required>
                            @error('u_npwd')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="u_repwd" class="col-md-4 col-form-label text-md-right">{{ __('Xác nhận mật khẩu mới') }}</label>
                        <div class="col-md-6">
                            <input id="u_repwd" type="password" class="form-control @error('u_repwd') is-invalid @enderror" name="u_repwd" required>
                            @error('u_repwd')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
