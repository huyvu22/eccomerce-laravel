@php use App\Models\Product; @endphp
@extends('frontend.layouts.master')
@section('title')
    Shop Now
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
                            <li><a href="{{route('home')}}">Trang chủ</a></li>
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
                    <h1 class="payment-success"></h1>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        PAYMENT PAGE END
    ==============================-->
@endsection

<script>
    document.addEventListener('DOMContentLoaded', async ()=>{

        document.querySelector('.payment-success').innerText = 'Loading...'
        const url = new URL(window.location.href);
        const params = url.searchParams;
        const vnp_Amount = params.get('vnp_Amount');
        const vnp_ResponseCode = params.get('vnp_ResponseCode');
        const vnp_TransactionNo = params.get('vnp_TransactionNo');

        const response = await fetch(`http://ecommerce.test/user/vnpay/checkout?vnp_Amount=${vnp_Amount}&vnp_TransactionNo=${vnp_TransactionNo}&vnp_ResponseCode=${vnp_ResponseCode}`);
        let data = await response.json();
        if(data.status === 'success'){
            document.querySelector('.payment-success').innerText = data.message
            toastr.success('Đặt hàng thành công!')
            setTimeout(()=>{
                window.location.href = 'http://ecommerce.test';
            }, 5000)
        }


    });
</script>



