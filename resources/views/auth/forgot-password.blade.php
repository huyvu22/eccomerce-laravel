@extends('frontend.layouts.master')
@section('title')
    Shop Now
@endsection
@section('content')
    <section id="wsus__login_register">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 m-auto">
                    <div class="wsus__forget_area">
                        <span class="qiestion_icon"><i class="fal fa-question-circle"></i></span>
                        <h4>Quên mật khẩu ?</h4>
                        <p>Nhập email của bạn để đặt mật khẩu mới</p>
                        @if (session('status'))
                            <span style="color: green">{{ session('status') }}</span>
                        @endif
                        <div class="wsus__login">
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="wsus__login_input mb-3">
                                    <i class="fal fa-envelope"></i>
                                    <input type="email" id="email" name="email" placeholder="Nhập eamil"
                                        value="{{ old('email') }}" autofocus>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="text-danger d-inline-block">{{ $errors->first('email') }}</span>
                                @endif

                                <button class="common_btn" type="submit">Gửi</button>
                            </form>
                        </div>
                        <a class="see_btn mt-4" href="{{ route('login') }}">Quay lại trang Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
