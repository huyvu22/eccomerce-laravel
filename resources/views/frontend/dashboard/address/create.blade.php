@extends('frontend.dashboard.layouts.master')
@section('title')
    Shop Now
@endsection
@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">

            {{--Sidebar start--}}
            @include('frontend.dashboard.layouts.sidebar')
            {{--Sidebar end --}}
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="fal fa-gift-card"></i>Thêm địa chỉ</h3>
                        <div class="wsus__dashboard_add wsus__add_address">
                            <form action="{{route('user.address.store')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label>Tên <b>*</b></label>
                                            <input type="text" placeholder="Name" name="name" value="{{old('name')}}">
                                            @if($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label>email</label>
                                            <input type="email" placeholder="Email" name="email" value="{{old('email')}}">
                                            @if($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label>Điện thoại <b>*</b></label>
                                            <input type="text" placeholder="Phone" name="phone" value="{{old('phone')}}">
                                            @if($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label> Tỉnh, Thành phố<b>*</b></label>
                                            <div class="wsus__topbar_select">
                                                <select class="select_2 province" name="province">
                                                    <option value="">Chọn Tỉnh, Thành Phố</option>
                                                    @foreach($provinces  as $province)
                                                        <option value="{{$province->id}}" {{$province->_name == old('province') ? 'selected' : ''}}>{{$province->_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if($errors->has('province'))
                                                <span class="text-danger">{{ $errors->first('province') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label>Quận, Huyện<b>*</b></label>
                                            <div class="wsus__topbar_select">
                                                <select class="district select_2" name="district">
                                                    <option value="0">Chọn Quận, Huyện</option>
                                                </select>
                                            </div>
                                            @if($errors->has('district'))
                                                <span class="text-danger">{{ $errors->first('district') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label>Phường, Xã <b>*</b></label>
                                            <div class="wsus__topbar_select">
                                                <select class="ward select_2" name="ward">
                                                    <option value="0">Chọn Phường, Xã</option>
                                                </select>
                                            </div>
                                            @if($errors->has('ward'))
                                                <span class="text-danger">{{ $errors->first('ward') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label>Địa chỉ <b>*</b></label>
                                            <input type="text" placeholder="Nhà riêng / Cơ quan / Khác..." name="address" value="{{old('address')}}">
                                            @if($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__add_address_single">
                                            <label>Ghi chú</label>
                                            <textarea cols="3" rows="5" placeholder="Ghi chú" name="note">{{old('note')}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <button type="submit" class="common_btn">Tạo mới</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


