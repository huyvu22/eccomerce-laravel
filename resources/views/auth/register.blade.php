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
                        <h4>Đăng ký</h4>
                        <ul>
                            <li><a href="{{route('home')}}">Trang chủ</a></li>
                            <li><a href="javascript:void(0);">Đăng ký</a></li>
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
                        <h4 class="text-center">Đăng ký</h4>
                        <div class="tab-content" id="pills-tabContent2">
                            <div class="tab-pane fade show active" id="pills-profiles" role="tabpanel"
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

                                        <button class="common_btn mt-3" type="submit">Đăng ký</button>
                                        <a class="see_btn mt-3" href="{{route('login')}}">Quay lại đăng nhập</a>

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
