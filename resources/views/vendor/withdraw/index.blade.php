@extends('vendor.layouts.master')
@section('title')
    Shop Now - Withdraw
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
                        <h4 class="mb-3">Tất cả giao dịch rút tiền</h4>

                        <div class="wsus__dashboard">
                            <div class="row">
                                <div class="col-xl-4 col-12 col-md-4">
                                    <a class="wsus__dashboard_item green" href="javascript:void(0);">
                                        <i class="fa fa-money-bill"></i>
                                        <p>Số dư</p>
                                        <h5 style="color:#fff;">{{format($totalBalance)}}</h5>
                                    </a>
                                </div>
                                <div class="col-xl-4 col-12 col-md-4">
                                    <a class="wsus__dashboard_item green" href="javascript:void(0);">
                                        <i class="far fa-cart-plus"></i>
                                        <p> Số tiền đang chờ xử lý</p>
                                        <h5 style="color:#fff;">{{format($pendingAmountRequests)}}</h5>
                                    </a>
                                </div>
                                <div class="col-xl-4 col-12 col-md-4">
                                    <a class="wsus__dashboard_item green" href="javascript:void(0);">
                                        <i class="fa fa-money-bill"></i>
                                        <p>Đã rút</p>
                                        <h5 style="color:#fff;">{{format($totalAmountWithdraw)}}</h5>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 mt-2">
                            <a href="{{route('vendor.withdraw.create')}}" class="btn btn-primary" style="font-size: 14px"><i style="font-size: 12px" class="fas fa-plus"></i> Gửi
                                yêu cầu rút tiền</a>
                        </div>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area" style="font-size: 14px">
                                {{$dataTable->table()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush



