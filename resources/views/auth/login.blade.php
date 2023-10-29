@extends('frontend.layouts.master')
@section('title')
    Shop Now
@endsection
@section('content')
    <!--============================
         BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Đăng nhập</h4>
                        <ul>
                            <li><a href="{{route('home')}}">Trang chủ</a></li>
                            <li><a href="javascript:void(0);">Đăng nhập</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->


    <!--============================
       LOGIN/REGISTER PAGE START
    ==============================-->
    <section id="wsus__login_register">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 m-auto">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="wsus__login_reg_area">
                        <h4 class="text-center">Đăng nhập</h4>
                        <div class="tab-content" id="pills-tabContent2">
                            <div class="tab-pane fade show active" id="pills-homes" role="tabpanel"
                                 aria-labelledby="pills-home-tab2">
                                <div class="wsus__login">
                                    <form method="post" action="{{route('login')}}">
                                        @csrf
                                        <div class="wsus__login_input">
                                            <i class="fas fa-user-tie"></i>
                                            <input type="text" id="email" name="email" value="userdemo@gmail.com" placeholder="Nhập email">
                                        </div>
                                        @if($errors->has('email'))
                                            <span class="text-danger d-inline-block ms-5 ps-3">{{ $errors->first('email') }}</span>
                                        @endif
                                        <div class="wsus__login_input">
                                            <i class="fas fa-key"></i>
                                            <input type="password" id="password" name="password" value="12345678" placeholder="Nhập mật khẩu">
                                        </div>
                                        @if($errors->has('password'))
                                            <span class="text-danger d-inline-block ms-5 ps-3">{{ $errors->first('password') }}</span>
                                        @endif

                                        <div class="wsus__login_save">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                       id="flexSwitchCheckDefault">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">
                                                    Nhớ mật khẩu</label>
                                            </div>
                                            <a class="forget_p" href="{{route('password.request')}}">Quên mật khẩu ?</a>
                                        </div>
                                        <button class="common_btn" type="submit">Đăng nhập</button>
                                        <p class="social_text"><span>hoặc đăng nhập bằng</span></p>
                                        <ul class="wsus__login_link">
                                            <li><a href="{{route('login.google')}}"><i class="fab fa-google"></i></a></li>
                                            <li><a href="{{route('login.facebook')}}"><i class="fab fa-facebook-f"></i></a></li>
                                        </ul>
                                    </form>
                                    <a class="see_btn mt-2" href="{{route('register')}}">Đăng ký</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
       LOGIN/REGISTER PAGE END
    ==============================-->
@endsection
