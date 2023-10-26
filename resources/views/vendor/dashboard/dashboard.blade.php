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
                    <div class="dashboard_content">
                        <div class="wsus__dashboard">
                            <div class="row">
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item green" href="{{route('vendor.orders.index')}}">
                                        <i class="far fa-cart-plus"></i>
                                        <p>Đơn hàng hôm nay</p>
                                        <h5 style="color:#fff;">{{@$todayOrders}}</h5>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item red" href="{{route('vendor.orders.index')}}">
                                        <i class="far fa-cart-plus"></i>
                                        <p> Đơn hàng chưa duyệt hôm nay </p>
                                        <h5 style="color:#fff;">{{@$todayPendingOrders}}</h5>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item blue" href="{{route('vendor.orders.index')}}">
                                        <i class="far fa-cart-plus"></i>
                                        <p>Tất cả đơn hàng</p>
                                        <h5 style="color:#fff;">{{@$totalOrders}}</h5>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item red" href="{{route('vendor.orders.index')}}">
                                        <i class="far fa-cart-plus"></i>
                                        <p>Tất cả đơn hàng đang duyệt</p>
                                        <h5 style="color:#fff;">{{@$totalPendingOrders}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item blue" href="{{route('vendor.orders.index')}}">
                                        <i class="far fa-cart-plus"></i>
                                        <p>Đơn hàng thành công</p>
                                        <h5 style="color:#fff;">{{@$totalCompleteOrders}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item green" href="{{route('vendor.products.index')}}">
                                        <i class="far fa-gift"></i>
                                        <p>Tất cả sản phấm</p>
                                        <h5 style="color:#fff;">{{@$totalProducts}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item orange" href="javascript:">
                                        <i class="far fa-money-bill"></i>
                                        <p>Lợi nhuận hôm nay</p>
                                        <h5 style="color:#fff;">{{format($todayEarnings)}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item orange" href="javascript:">
                                        <i class="far fa-money-bill-alt"></i>
                                        <p>Lợi nhuận tháng qua</p>
                                        <h5 style="color:#fff;">{{format($monthEarnings)}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item orange" href="javascript:">
                                        <i class="far fa-money-bill-alt"></i>
                                        <p>Lợi nhuận năm qua</p>
                                        <h5 style="color:#fff;">{{format($yearEarnings)}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item green" href="javascript:">
                                        <i class="far fa-money-bill-alt"></i>
                                        <p>Tổng lợi nhuận</p>
                                        <h5 style="color:#fff;">{{format($totalEarnings)}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item sky" href="{{route('vendor.review.index')}}">
                                        <i class="fas fa-star"></i>
                                        <p>Đánh giá</p>
                                        <h5 style="color:#fff;">{{@$totalReviews }}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item orange" href="{{route('vendor.profile')}}">
                                        <i class="fas fa-user-shield"></i>
                                        <p>Thông tin Shop</p>
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
