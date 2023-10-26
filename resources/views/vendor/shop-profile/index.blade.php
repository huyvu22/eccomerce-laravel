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
                        <h3><i class="far fa-user"></i>Thông tin shop</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{route('vendor.shop-profile.store')}}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group mb-3">
                                        <label for="">Ảnh đại diện</label>
                                        <br>
                                        <img width="200" src="{{asset($profile->banner)}}" alt="">
                                    </div>
                                    <div class="form-group mb-3 mt-3">
                                        <label for="">Banner</label>
                                        <input type="file" name="banner" class="form-control" style="font-size: 14px">
                                        @if($errors->has('banner'))
                                            <span class="text-danger">{{ $errors->first('banner') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3 mt-3">
                                        <label for="">Tên shop</label>
                                        <input type="text" name="shop_name" value="{{$profile->shop_name}}" class="form-control" style="font-size: 14px">
                                        @if($errors->has('shop_name'))
                                            <span class="text-danger">{{ $errors->first('shop_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3 mt-3">
                                        <label for="">Số điện thoại</label>
                                        <input type="text" name="phone" class="form-control" value="{{$profile->phone}}" style="font-size: 14px">
                                        @if($errors->has('type'))
                                            <span class="text-danger">{{ $errors->first('type') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group  mb-3 mt-3">
                                        <label for="">Email</label>
                                        <input type="text" name="email" class="form-control" value="{{$profile->email}}" style="font-size: 14px">
                                        @if($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group  mb-3 mt-3">
                                        <label for="">Địa chỉ</label>
                                        <input type="text" name="address" class="form-control" value="{{$profile->address}}" style="font-size: 14px">
                                        @if($errors->has('address'))
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group  mb-3 mt-3">
                                        <label for="">Mô tả</label>
                                        <textarea name="description" class="summernote" style="font-size: 14px">{{$profile->description}}</textarea>
                                        @if($errors->has('description'))
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3 mt-3">
                                        <label for="">Facebook</label>
                                        <input type="text" name="fb_link" class="form-control" value="{{$profile->fb_link}}" style="font-size: 14px">
                                        @if($errors->has('fb_link'))
                                            <span class="text-danger">{{ $errors->first('fb_link') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3 mt-3">
                                        <label for="">Twitter</label>
                                        <input type="text" name="tw_link" class="form-control" value="{{$profile->tw_link}}" style="font-size: 14px">
                                        @if($errors->has('tw_link'))
                                            <span class="text-danger">{{ $errors->first('tw_link') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3 mt-3">
                                        <label for="">Instagram</label>
                                        <input type="text" name="insta_link" class="form-control" value="{{$profile->insta_link}}" style="font-size: 14px">
                                        @if($errors->has('insta_link'))
                                            <span class="text-danger">{{ $errors->first('insta_link') }}</span>
                                        @endif
                                        <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


