@php use App\Models\Product; @endphp
@extends('frontend.layouts.master')
@section('title')
    Shop Now | Thanh toán
@endsection
@section('content')
    <!--============================
                        BREADCRUMB START
                    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Thanh toán</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">Trang chủ</a></li>
                            <li><a href="javascript:">Thanh toán</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                        BREADCRUMB END
                    ==============================-->


    <!--============================
                        PAYMENT PAGE START
                    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="wsus__pay_info_area">
                <div class="payment">
                    <h1 class="payment-success">Thanh toán thành công</h1>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                        PAYMENT PAGE END
                    ==============================-->
@endsection

<script>
    document.addEventListener('DOMContentLoaded', async () => {

        setTimeout(() => {
            window.location.href = 'http://shopnowvn.xyz/user/orders';
        }, 2000)
    });
</script>
