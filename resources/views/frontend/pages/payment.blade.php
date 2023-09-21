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
                        <h4>Phương thức thanh toán</h4>
                        <ul>
                            <li><a href="{{route('home')}}">Trang chủ</a></li>
                            <li><a href="javascript:">Phương thức thanh toán</a></li>
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
                <div class="row">
                    <div class="col-xl-3 col-lg-3">
                        <div class="wsus__payment_menu" id="sticky_sidebar">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">
{{--                                <button class="nav-link common_btn active" id="v-pills-home-tab" data-bs-toggle="pill"--}}
{{--                                        data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"--}}
{{--                                        aria-selected="true">card payment</button>--}}

                                <button class="nav-link common_btn" id="v-pills-paypal-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-paypal" type="button" role="tab"
                                        aria-controls="v-pills-paypal" aria-selected="false">Paypal</button>

                                <button class="nav-link common_btn" id="v-pills-stripe-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-stripe" type="button" role="tab"
                                        aria-controls="v-pills-stripe" aria-selected="false">Stripe</button>

                                <button class="nav-link common_btn" id="v-pills-vnpay-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-vnpay" type="button" role="tab"
                                        aria-controls="v-pills-vnpay" aria-selected="false">VnPay</button>

                                <button class="nav-link common_btn" id="v-pills-cod-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-cod" type="button" role="tab"
                                        aria-controls="v-pills-cod" aria-selected="false" style="text-transform: none">Thanh toán khi nhận hàng (COD)</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="tab-content" id="v-pills-tabContent" id="sticky_sidebar">
{{--                            <div class="tab-pane fade show active" id="v-pills-paypal" role="tabpanel"--}}
{{--                                 aria-labelledby="v-pills-home-tab">--}}
{{--                                <div class="row">--}}
{{--                                    <div class="col-xl-12 m-auto">--}}
{{--                                        <div class="wsus__payment_area">--}}
{{--                                            <form>--}}
{{--                                                <div class="wsus__pay_caed_header">--}}
{{--                                                    <h5>credit or debit card</h5>--}}
{{--                                                    <img src="{{asset('frontend/images/payment5.png')}}" alt="payment" class="img-=fluid">--}}
{{--                                                </div>--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-12">--}}
{{--                                                        <input class="input" type="text"--}}
{{--                                                               placeholder="MD. MAHAMUDUL HASSAN SAZAL">--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-12">--}}
{{--                                                        <input class="input" type="text"--}}
{{--                                                               placeholder="2540 4587 **** 3215">--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-4">--}}
{{--                                                        <input class="input" type="text" placeholder="MM/YY">--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-4 ms-auto">--}}
{{--                                                        <input class="input" type="text" placeholder="1234">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="wsus__save_payment">--}}
{{--                                                    <h6><i class="fas fa-user-lock"></i> 100% secure payment with :</h6>--}}
{{--                                                    <img src="{{asset('frontend/images/payment1.png')}}" alt="payment" class="img-fluid">--}}
{{--                                                    <img src="{{asset('frontend/images/payment2.png')}}" alt="payment" class="img-fluid">--}}
{{--                                                    <img src="{{asset('frontend/images/payment3.png')}}" alt="payment" class="img-fluid">--}}
{{--                                                </div>--}}
{{--                                                <div class="wsus__save_card">--}}
{{--                                                    <div class="form-check form-switch">--}}
{{--                                                        <input class="form-check-input" type="checkbox"--}}
{{--                                                               id="flexSwitchCheckDefault">--}}
{{--                                                        <label class="form-check-label"--}}
{{--                                                               for="flexSwitchCheckDefault">save thid Card</label>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <button type="submit" class="common_btn">confirm</button>--}}
{{--                                            </form>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="tab-pane fade show active" id="v-pills-paypal" role="tabpanel"
                                 aria-labelledby="v-pills-paypal-tab">
                                <div class="row">
                                    <div class="col-xl-12 m-auto">
                                        <div class="wsus__payment_area">
                                            <a href="{{route('user.paypal.payment')}}" class="nav-link common_btn text-center">Thanh toán qua Paypal</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-stripe" role="tabpanel"
                                 aria-labelledby="v-pills-stripe-tab">
                                <div class="row">
                                    <div class="col-xl-12 m-auto">
                                        <div class="wsus__payment_area">
                                            <form action="{{route('user.stripe.payment')}}" method="post" id="checkout-form">
                                                @csrf
                                                <div id="card-element" class="form-control mb-3 p-2"></div>
                                                <input type="hidden" name="stripe_token" id="stripe-token-id">
                                                <button  type="button" class="nav-link common_btn text-center" id="pay-btn" onclick="createToken()">Thanh toán qua Stripe</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="v-pills-vnpay" role="tabpanel"
                                 aria-labelledby="v-pills-vnpay-tab">
                                <div class="row">
                                    <div class="col-xl-12 m-auto">
                                        <div class="wsus__payment_area">
                                            <form action="{{route('user.vnpay.payment')}}" method="post">
                                                @csrf
                                                <button type="submit" name="redirect" class="nav-link common_btn text-center">Thanh toán qua VnPay</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="v-pills-cod" role="tabpanel"
                                 aria-labelledby="v-pills-cod-tab">
                                <div class="row">
                                    <div class="col-xl-12 m-auto">
                                        <div class="wsus__payment_area">
                                            <a href="{{route('user.cod.payment')}}" class="nav-link common_btn text-center">Đặt hàng</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="wsus__pay_booking_summary" id="sticky_sidebar2">
                            <h5>Đơn hàng</h5>
                            <p>Tạm tính: <span>{{getCartTotal()}}</span></p>
                            <p>Phí vận chuyển: <span>{{getShippingFee()}} </span></p>
                            <p>coupon: <span>{{getCartDiscount()}} </span></p>
                            <h6>Thành tiền <span>{{getPayAmount()}}</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        PAYMENT PAGE END
    ==============================-->

@endsection
@php
    $stripeSetting = \App\Models\StripeSetting::first();
@endphp

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        let stripe = Stripe("{{$stripeSetting->client_id}}");
        let elements = stripe.elements();
        let cardElement = elements.create('card');
        cardElement.mount('#card-element')

        function createToken(){
            document.getElementById('pay-btn').disabled = true;
            stripe.createToken(cardElement).then(function(result){

                if(typeof result.error !== 'undefined'){
                    document.getElementById('pay-btn').disabled = false;
                    alert(result.error.message);
                }

                //create token success
                if(typeof result.token != 'undefined'){
                    document.getElementById('stripe-token-id').value = result.token.id;
                    document.getElementById('checkout-form').submit();
                }
            })
        }
    </script>
@endpush


