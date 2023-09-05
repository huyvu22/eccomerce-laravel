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
                                        <p>Today's Order</p>
                                        <h5 style="color:#fff;">{{@$todayOrders}}</h5>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item red" href="{{route('vendor.orders.index')}}">
                                        <i class="far fa-cart-plus"></i>
                                        <p> today's Pending Order </p>
                                        <h5 style="color:#fff;">{{@$todayPendingOrders}}</h5>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item blue" href="{{route('vendor.orders.index')}}">
                                        <i class="far fa-cart-plus"></i>
                                        <p>Total Order</p>
                                        <h5 style="color:#fff;">{{@$totalOrders}}</h5>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item red" href="{{route('vendor.orders.index')}}">
                                        <i class="far fa-cart-plus"></i>
                                        <p>Total Pending Order</p>
                                        <h5 style="color:#fff;">{{@$totalPendingOrders}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item blue" href="{{route('vendor.orders.index')}}">
                                        <i class="far fa-cart-plus"></i>
                                        <p>Total Complete Order</p>
                                        <h5 style="color:#fff;">{{@$totalCompleteOrders}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item green" href="{{route('vendor.products.index')}}">
                                        <i class="far fa-gift"></i>
                                        <p>Total Products</p>
                                        <h5 style="color:#fff;">{{@$totalProducts}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item orange" href="javascript:">
                                        <i class="far fa-money-bill"></i>
                                        <p>today's earnings</p>
                                        <h5 style="color:#fff;">{{format($todayEarnings)}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item orange"  href="javascript:">
                                        <i class="far fa-money-bill-alt"></i>
                                        <p>This Month's earnings</p>
                                        <h5 style="color:#fff;">{{format($monthEarnings)}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item orange"  href="javascript:">
                                        <i class="far fa-money-bill-alt"></i>
                                        <p>This Year's earnings</p>
                                        <h5 style="color:#fff;">{{format($yearEarnings)}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item green"  href="javascript:">
                                        <i class="far fa-money-bill-alt"></i>
                                        <p>Total Earning</p>
                                        <h5 style="color:#fff;">{{format($totalEarnings)}}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item sky" href="{{route('vendor.review.index')}}">
                                        <i class="fas fa-star"></i>
                                        <p>reviews</p>
                                        <h5 style="color:#fff;">{{@$totalReviews }}</h5>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item orange" href="{{route('vendor.profile')}}">
                                        <i class="fas fa-user-shield"></i>
                                        <p>shop profile</p>
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
