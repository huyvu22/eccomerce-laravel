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
                    <div class="dashboard_content">
                        <h3><i class="fal fa-gift-card"></i> Địa chỉ</h3>
                        <div class="wsus__dashboard_add">
                            <div class="row">
                                @if($userAddress->count()>0)
                                    @foreach($userAddress as $user)
                                        <div class="col-xl-6">
                                            <div class="wsus__dash_add_single">
                                                <h4>Địa chỉ nhận hàng</h4>
                                                <ul>
                                                    <li><span>name :</span> {{$user->name}}</li>
                                                    <li><span>Điện thoại :</span> {{$user->phone}}</li>
                                                    <li><span>email :</span> {{isset($user->email) ? $user->email : ''}}</li>
                                                    <li><span>Tỉnh, Thành phố :</span> {{$user->province}}</li>
                                                    <li><span>Quận, Huyện :</span> {{$user->district}}</li>
                                                    <li><span>Phường, Xã :</span> {{$user->ward}}</li>
                                                    <li><span>Địa chỉ :</span>{{$user->address}}</li>
                                                    <li><span>Ghi chú :</span>{{isset($user->note) ? $user->note : ''}}</li>
                                                </ul>
                                                <div class="wsus__address_btn">
                                                    <a href="{{route('user.address.edit',$user)}}" class="edit"><i class="fal fa-edit"></i> Sửa</a>
                                                    <a href="{{route('user.address.destroy',$user)}}" class="del"><i class="fal fa-trash-alt"></i> Xóa</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="col-12">
                                    <a href="{{route('user.address.create')}}" class="add_address_btn common_btn"><i class="far fa-plus"></i>
                                        Thêm địa chỉ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

