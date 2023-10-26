@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('admin.order.index')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-cart-plus"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Today's Order</h4>
                            </div>
                            <div class="card-body">
                                {{$todayOrders}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('admin.order.index')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Today's Pending Order</h4>
                            </div>
                            <div class="card-body">
                                {{$todayPendingOrders}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('admin.order.index')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-cart-plus"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Orders</h4>
                            </div>
                            <div class="card-body">
                                {{$totalOrders}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('admin.pending-orders')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Pending Order</h4>
                            </div>
                            <div class="card-body">
                                {{$totalPendingOrders}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('admin.canceled-orders')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-window-close"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Canceled Order</h4>
                            </div>
                            <div class="card-body">
                                {{$totalCancelOrders}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('admin.delivered-orders')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Delivered Order</h4>
                            </div>
                            <div class="card-body">
                                {{$totalDeliveredOrders}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Today's Earning</h4>
                        </div>
                        <div class="card-body">
                            {{$todayEarnings}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Month's Earning</h4>
                        </div>
                        <div class="card-body">
                            {{format($monthEarnings)}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Year's Earning</h4>
                        </div>
                        <div class="card-body">
                            {{format($monthEarnings)}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('admin.brand.index')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-copyright"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Brands</h4>
                            </div>
                            <div class="card-body">
                                {{$totalBrands}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('admin.vendors.index')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Vendors</h4>
                            </div>
                            <div class="card-body">
                                {{$totalVendors}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('admin.review.index')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Reviews</h4>
                            </div>
                            <div class="card-body">
                                {{$totalReviews}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('admin.blog.index')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Blog</h4>
                            </div>
                            <div class="card-body">
                                {{$totalBlogs}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('admin.category.index')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Categories</h4>
                            </div>
                            <div class="card-body">
                                {{$totalCategories}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('admin.subscriber.index')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Subscribes</h4>
                            </div>
                            <div class="card-body">
                                {{$totalSubscribers}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('admin.customers.index')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total customer</h4>
                            </div>
                            <div class="card-body">
                                {{$totalUsers}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </section>
@endsection
