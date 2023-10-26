@extends('vendor.layouts.master')
@section('title')
    Shop Now
@endsection
@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">

            {{--Sidebar start--}}
            @include('vendor.layouts.sidebar')
            {{--Sidebar end --}}

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i> Thông tin</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <h4>basic information</h4>
                                <div class="row">
                                    <form action="{{route('vendor.profile.update')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="col-xl-9">
                                            <div class="col-xl-3 col-sm-6 col-md-6 mb-3">
                                                <div class="wsus__dash_pro_img">
                                                    <img src="{{Auth::user()->image ? Auth::user()->image : asset('frontend/images/ts-2.jpg')}}" alt="img" class="img-fluid w-100">
                                                    <input type="file" name="image">
                                                </div>
                                                @if($errors->has('image'))
                                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                                @endif
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6 col-md-6">
                                                    @if($errors->has('name'))
                                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                                    @endif
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fas fa-user-tie"></i>
                                                        <input type="text" name="name" value="{{Auth::user()->name}}" placeholder="Tên shop">
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-md-6">
                                                    @if($errors->has('email'))
                                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                                    @endif
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fal fa-envelope-open"></i>
                                                        <input type="email" name="email" value="{{Auth::user()->email}}" placeholder="Email">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <button class="common_btn mb-4 mt-2" type="submit">Cập nhập</button>
                                        </div>
                                    </form>
                                    <div class="wsus__dash_pass_change mt-2">
                                        <form action="{{route('vendor.password.update')}}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-xl-4 col-md-6">
                                                    @if($errors->has('current_password'))
                                                        <span class="text-danger d-inline-block">{{ $errors->first('current_password') }}</span>
                                                    @endif
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fas fa-unlock-alt"></i>
                                                        <input type="password" name="current_password" placeholder="Mật khẩu hiện tại">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-md-6">
                                                    @if($errors->has('password'))
                                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif
                                                    <div class="wsus__dash_pro_single mb-2">
                                                        <i class="fas fa-lock-alt"></i>
                                                        <input type="password" name="password" placeholder="Mật khẩu mới">
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-md-6">
                                                    @if($errors->has('confirm_password'))
                                                        <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                                    @endif
                                                    <div class="wsus__dash_pro_single">
                                                        <i class="fas fa-lock-alt"></i>
                                                        <input type="password" name="confirm_password" placeholder="Xác nhận lại mật khẩu">
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <button class="common_btn" type="submit">Cập nhật</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

