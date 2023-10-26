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
                        <div class="wsus__dashboard">
                            <div class="row">
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item green" href="{{route('user.orders.index')}}">
                                        <i class="far fa-cart-plus"></i>
                                        <p>Tất cả đơn hàng</p>
                                        <h5 style="color:#fff;">{{$totalOrder }}</h5>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item red" href="{{route('user.orders.index')}}">
                                        <i class="far fa-cart-plus"></i>
                                        <p>Đơn hàng đợi phê duyệt</p>
                                        <h5 style="color:#fff;">{{$pendingOrder }}</h5>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item blue" href="{{route('user.orders.index')}}">
                                        <i class="far fa-cart-plus"></i>
                                        <p>Đơn hàng hoàn thành</p>
                                        <h5 style="color:#fff;">{{$completeOrder}}</h5>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item sky" href="{{route('user.review.index')}}">
                                        <i class="fas fa-star"></i>
                                        <p>Đánh giá</p>
                                        <h5 style="color:#fff;">{{$reviews}}</h5>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item blue" href="{{route('user.wishlist.index')}}">
                                        <i class="far fa-heart"></i>
                                        <p>Yêu thích</p>
                                        <h5 style="color:#fff;">{{$wishlists}}</h5>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item orange" href="{{route('user.profile')}}">
                                        <i class="fas fa-user-shield"></i>
                                        <p>Thông tin các nhân</p>
                                        <h5 style="color:#fff;">+</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
