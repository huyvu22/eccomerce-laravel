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
                        <h4 class="mb-2">Thông tin rút tiền</h4>

                        <div class="wsus__dashboard_profile">
                            <div class="row">
                                <div class="wsus__dash_pro_area col-md-6">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td><b>Phương thức</b></td>
                                            <td>{{$withdrawRequest->method}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Phí rút tiền</b></td>
                                            <td>{{($withdrawRequest->withdraw_charge) / ($withdrawRequest->total_amount) *100 }}%</td>
                                        </tr>
                                        <tr>
                                            <td><b>Tổng tiền rút</b></td>
                                            <td>{{format($withdrawRequest->total_amount)}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Phí</b></td>
                                            <td>{{format($withdrawRequest->withdraw_charge)}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Thực nhận</b></td>
                                            <td>{{format($withdrawRequest->withdraw_amount)}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Thông tin chuyển tiền</b></td>
                                            <td>{!! nl2br(str_replace('-', '<br>', e($withdrawRequest->account_info))) !!}</td>


                                        </tr>
                                        <tr>
                                            <td><b>Trạng thái</b></td>
                                            <td>
                                                @switch($withdrawRequest->status)
                                                    @case('pending')
                                                        <i class="badge bg-warning">Đang xử lý</i>
                                                        @break

                                                    @case('paid')
                                                        <i class="badge bg-success">Thành công</i>
                                                        @break

                                                    @default
                                                        <i class="badge bg-danger">Không thành công</i>
                                                @endswitch
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection





