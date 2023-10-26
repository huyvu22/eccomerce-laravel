@php
    $address = json_decode($order->order_address);
    $shipping = json_decode($order->shipping_method);
    if(isset($order->coupon)){
            $coupon = json_decode($order->coupon);
    }
@endphp
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
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h4>Chi tiết đơn hàng</h4>
                        <div class="wsus__dashboard_profile mt-2">
                            <div class="wsus__dash_pro_area" style="font-size: 14px">
                                <div class="wsus__invoice_header invoice-print">
                                    <div class="wsus__invoice_content">
                                        <div class="row">
                                            <div class="col-xl-4 col-md-4 mb-5 mb-md-0">
                                                <div class="wsus__invoice_single">
                                                    <h5>Thông tin hóa đơn</h5>
                                                    <h6>Tên: {{$address->name}}</h6>
                                                    <p>Email: {{$address->email}}</p>
                                                    <p>Số đt: {{$address->phone}}</p>
                                                    <p>Địa chỉ: {{$address->address}}, {{$address->ward}}, {{$address->district}}, {{$address->province}}</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4 mb-5 mb-md-0">
                                                <div class="wsus__invoice_single text-md-center">
                                                    <h5>Thông tin giao hàng</h5>
                                                    <h6>Tên: {{$address->name}}</h6>
                                                    <p>Email: {{$address->email}}</p>
                                                    <p>Số đt: {{$address->phone}}</p>
                                                    <p>Địa chỉ: {{$address->address}}, {{$address->ward}}, {{$address->district}}, {{$address->province}}</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4">
                                                <div class="wsus__invoice_single text-md-end">
                                                    <h5>Mã đơn hàng: #{{$order->invoice_id}}</h5>
                                                    <h6>Trạng thái đơn hàng: {{config('order_status.order_status_admin')[$order->order_status]['status']}}</h6>
                                                    <p>Thanh tóa: {{$order->payment_status}}</p>
                                                    <p>Phương thức thanh toán: {{$order->payment_method}}</p>
                                                    <p>Mã giao dịch id: {{$order->transaction->transaction_id}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wsus__invoice_description">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th class="name">
                                                        Sản phẩm
                                                    </th>
                                                    <th class="amount">
                                                        Gian hàng
                                                    </th>

                                                    <th class="amount">
                                                        Đơn giá
                                                    </th>

                                                    <th class="quantity">
                                                        Số lượng
                                                    </th>
                                                    <th class="total">
                                                        Thành tiến
                                                    </th>
                                                </tr>
                                                @foreach($order->orderProducts as $product)
                                                    @php
                                                        $variants = json_decode($product->variants);
                                                    @endphp
                                                    <tr>
                                                        <td class="name">
                                                            <p>{{$product->product_name}}</p>
                                                            @foreach($variants as $key=>$variant)
                                                                <span>{{$key}}: {{$variant->name}}</span>
                                                            @endforeach
                                                        </td>

                                                        <td class="amount">
                                                            {{$product->vendor->shop_name}}
                                                        </td>

                                                        <td class="amount">
                                                            {{format($product->unit_price)}}
                                                        </td>

                                                        <td class="quantity">
                                                            {{$product->quantity}}
                                                        </td>
                                                        <td class="total">
                                                            {{format(($product->unit_price * $product->quantity) + $product->variant_total)}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                        <div class="wsus__invoice_footer">
                                            <p><span>Tạm tính:</span>{{format($order->sub_total)}} </p>
                                            <p><span>Coupon (-):</span>{{ $coupon ? format($coupon->discount) : 0}} </p>
                                            <p><span>Phí vận chuyển (+):</span>{{format($shipping->cost)}} </p>
                                            <p><span>Thành tiền:</span>{{format($order->amount)}} </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-warning btn-icon icon-left print_invoice"><i class="fas fa-print"></i> In</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        window.addEventListener("DOMContentLoaded", (event) => {

            const print = document.querySelector('.print_invoice');
            console.log(print);

            document.body.addEventListener('click', async (e) => {

                if (e.target.classList.contains('print_invoice')) {
                    e.preventDefault();
                    let printArea = document.querySelector('.invoice-print');
                    let defaultBody = document.body.innerHTML;
                    document.body.innerHTML = printArea.innerHTML;
                    window.print();
                    document.body.innerHTML = defaultBody;
                }
            });
        });
    </script>
@endpush


