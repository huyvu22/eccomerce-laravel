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
                        <h4>login / register</h4>
                        <ul>
                            <li><a href="{{route('home')}}">home</a></li>
                            <li><a href="javascript:void(0);">login / register</a></li>
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
                    <div class="wsus__login_reg_area">
                        <ul class="nav nav-pills mb-3" id="pills-tab2" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab2" data-bs-toggle="pill"
                                        data-bs-target="#pills-homes" type="button" role="tab" aria-controls="pills-homes"
                                        aria-selected="true">Đăng nhập
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab2" data-bs-toggle="pill"
                                        data-bs-target="#pills-profiles" type="button" role="tab"
                                        aria-controls="pills-profiles" aria-selected="true">Đăng ký
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent2">
                            <div class="tab-pane fade show active" id="pills-homes" role="tabpanel"
                                 aria-labelledby="pills-home-tab2">
                                <div class="wsus__login">
                                    <form method="post" action="{{route('login')}}">
                                        @csrf
                                        <div class="wsus__login_input">
                                            <i class="fas fa-user-tie"></i>
                                            <input type="text" id="email" name="email" value="{{old('email')}}" placeholder="Nhập email">
                                        </div>
                                        @if($errors->has('email'))
                                            <span class="text-danger d-inline-block ms-5 ps-3">{{ $errors->first('email') }}</span>
                                        @endif
                                        <div class="wsus__login_input">
                                            <i class="fas fa-key"></i>
                                            <input type="password" id="password" name="password" placeholder="Nhập mật khẩu">
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
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-profiles" role="tabpanel"
                                 aria-labelledby="pills-profile-tab2">
                                <div class="wsus__login">
                                    <form method="post" action="{{route('register')}}">
                                        @csrf
                                        <div class="wsus__login_input">
                                            <i class="fas fa-user-tie"></i>
                                            <input type="text" id="name" placeholder="Nhập tên" name="name" value="{{old('name')}}">
                                        </div>
                                        @if($errors->has('name'))
                                            <span class="text-danger d-inline-block ms-5 ps-3">{{ $errors->first('name') }}</span>
                                        @endif
                                        <div class="wsus__login_input">
                                            <i class="far fa-envelope"></i>
                                            <input type="email" id="email" placeholder="Nhập email" name="email" value="{{old('email')}}">
                                        </div>
                                        @if($errors->has('email'))
                                            <span class="text-danger d-inline-block ms-5 ps-3">{{ $errors->first('email') }}</span>
                                        @endif
                                        <div class="wsus__login_input">
                                            <i class="fas fa-key"></i>
                                            <input type="password" id="password" placeholder="Nhập mật khẩu" name="password">
                                        </div>
                                        @if($errors->has('password'))
                                            <span class="text-danger d-inline-block ms-5 ps-3">{{ $errors->first('password') }}</span>
                                        @endif
                                        <div class="wsus__login_input">
                                            <i class="fas fa-key"></i>
                                            <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu">
                                        </div>
                                        @if($errors->has('password_confirmation'))
                                            <span class="text-danger d-inline-block ms-5 ps-3">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                        <div class="wsus__login_save">
                                        </div>
                                        <button class="common_btn" type="submit">Đăng ký</button>
                                    </form>
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
