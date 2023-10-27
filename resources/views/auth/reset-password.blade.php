@extends('frontend.layouts.master')
@section('content')
    <section id="wsus__login_register">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-md-10 col-lg-7 m-auto">
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <div class="wsus__change_password">
                            <h4>Đặt lại mật khẩu</h4>

                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <div class="wsus__single_pass">
                                <label>email</label>
                                <input type="email" name="email" value="{{old('email', $request->email)}}">
                            </div>
                            <div class="wsus__single_pass">
                                <label>Mật khẩu</label>
                                <input type="password" id="password" name="password" placeholder="Mật khẩu mới">
                                @if($errors->has('password'))
                                    <code>{{$errors->first('password')}}</code>
                                @endif
                            </div>
                            <div class="wsus__single_pass">
                                <label>Xác nhận mật khẩu</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu">
                                @if($errors->has('password_confirmation'))
                                    <code>{{$errors->first('password_confirmation')}}</code>
                                @endif
                            </div>
                            <button class="common_btn" type="submit">Đổi mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
