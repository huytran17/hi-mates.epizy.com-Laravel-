@extends('layouts.app')
@section('title')
    Đặt lại mật khẩu
@endsection
@section('content')
<div class="container _c-verify-reset-pwd">
    <div class="row justify-content-center _w-verify-reset-pwd">
        <div class="col-md-8 _verify-reset-pwd">
            <div class="card">
                <div class="card-header">{{ __('Thành công!') }}</div>

                <div class="card-body">
                    {{ __('Một đường dẫn khôi phục mật khẩu đã được gửi tới hòm thư của bạn.') }}
                    {{ __('Trước khi tiếp tục, vui lòng kiểm tra hòm thư của bạn.') }}
                    {{ __('Nếu bạn không nhận được thư khôi phục') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('nhấn để gửi lại') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
