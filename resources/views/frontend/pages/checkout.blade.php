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
        CHECK OUT PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="wsus__check_form">
                        <div class="d-flex justify-content-between">
                            <h5>Chi tiết vận chuyển</h5>
                            <button class="btn common_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Thêm địa chỉ nhận hàng</button>
                        </div>
                        <div class="row">
                            @if($addresses->count() > 0)
                                @foreach($addresses as $address)
                                    <div class="col-xl-6">
                                        <div class="wsus__checkout_single_address">
                                            <div class="form-check">
                                                <input class="form-check-input shipping_address" data-id="{{$address->id}}" type="radio" name="flexRadioDefault"
                                                       id="flexRadioDefault-{{$address->id}}">
                                                <label class="form-check-label" for="flexRadioDefault-{{$address->id}}">
                                                    Chọn địa chỉ
                                                </label>
                                            </div>
                                            <ul>
                                                <li><span>Tên :</span> <b>{{$address->name}}</b></li>
                                                <li><span>Số điện thoại :</span> <b>{{$address->phone}}</b></li>
                                                <li><span>Email :</span> <b>{{isset($address->email) ? $address->email : ''}}</b></li>
                                                <li><span>Tỉnh, TP:</span> <b>{{$address->province}}</b></li>
                                                <li><span>Quận, Huyện :</span> <b>{{$address->district}}</b></li>
                                                <li><span>Phường, Xã :</span> <b>{{$address->ward}}</b></li>
                                                <li><span>Địa chỉ :</span> <b>{{$address->address}}</b></li>
                                                <li><span>Ghi chú :</span> <b>{{$address->note}}</b></li>
                                            </ul>

                                            <form action="{{ route('user.address.destroy', $address) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn"><span class="wsus_close_mini_cart text-danger"><i class="far fa-times"
                                                                                                                                    aria-hidden="true"></i></span></button>

                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="wsus__order_details" id="sticky_sidebar">
                        <p class="wsus__product">Phương thức vận chuyển</p>
                        @foreach($shippingMethods as $shippingMethod)
                            @if(getCartTotal()>=$shippingMethod->min_cost)
                                <div class="form-check">
                                    <input class="form-check-input shipping_method" type="radio" name="exampleRadios" id="exampleRadios-{{$shippingMethod->id}}"
                                           value="{{$shippingMethod->id}}" data-cost="{{$shippingMethod->cost}}">
                                    <label class="form-check-label" for="exampleRadios-{{$shippingMethod->id}}">
                                        {{$shippingMethod->name}}
                                        <span>phí vận chuyển: {{format($shippingMethod->cost)}}</span>
                                        {{--                                            <span>(1 - 2 days)</span>--}}
                                    </label>
                                </div>
                            @elseif(getCartTotal()<$shippingMethod->min_cost)
                                <div class="form-check">
                                    <input class="form-check-input shipping_method" type="radio" name="exampleRadios" id="exampleRadios-{{$shippingMethod->id}}"
                                           value="{{$shippingMethod->id}}" data-cost="{{$shippingMethod->cost}}">
                                    <label class="form-check-label" for="exampleRadios-{{$shippingMethod->id}}">
                                        {{$shippingMethod->name}}
                                        <span>(3 - 5 ngày)</span>
                                    </label>
                                </div>
                            @endif
                        @endforeach
                        <div class="wsus__order_details_summery">
                            <p>Tạm tính: <span>{{getCartTotal()}}</span></p>
                            <p>Phí vận chuyển (+): <span class="shipping_fee">0₫</span></p>
                            <p>coupon (-): <span>{{getCartDiscount()}}</span></p>
                            <p><b>Thành tiền:</b> <span><b class="total_amount" data-cost="{{getCartTotalRaw()}}">{{getMainCartTotal()}}</b></span></p>
                        </div>
                        <div class="terms_area">
                            <div class="form-check">
                                <input class="form-check-input agree-term" type="checkbox" value="" id="flexCheckChecked3"
                                       checked>
                                <label class="form-check-label" for="flexCheckChecked3">
                                    Tôi đồng ý với các <a href="#">điều khoản và điều kiện *</a>
                                </label>
                            </div>
                        </div>

                        <form action="{{route('user.checkout.form-submit')}}" class="check_out_form" method="post">
                            @csrf
                            <input type="hidden" name="shipping_method_id" class="shipping_method_id" value="">
                            <input type="hidden" name="shipping_address_id" class="shipping_address_id" value="">
                        </form>

                        <a href="" class="common_btn submit_checkout">Đặt hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="wsus__popup_address">
        <div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm địa chỉ nhận hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="wsus__check_form p-3">
                            <form action="{{route('user.checkout.address-create')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Tên" name="name" value="{{old('name')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Số điện thoại" name="phone" value="{{old('phone')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Email (Tùy chọn)" name="email" value="{{old('email')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if($errors->has('province'))
                                            <span class="text-danger">{{ $errors->first('province') }}</span>
                                        @endif
                                        <div class="wsus__check_single_form">
                                            <select class="select_2 province" name="province">
                                                <option value="0">Tỉnh, Thành phố *</option>
                                                @foreach($provinces  as $province)
                                                    <option value="{{$province->id}}" {{$province->_name == old('province') ? 'selected' : ''}}>{{$province->_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if($errors->has('district'))
                                            <span class="text-danger">{{ $errors->first('district') }}</span>
                                        @endif
                                        <div class="wsus__check_single_form">
                                            <select class="select_2 district" name="district">
                                                <option value="0">Quận, Huyện *</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if($errors->has('ward'))
                                            <span class="text-danger">{{ $errors->first('ward') }}</span>
                                        @endif
                                        <div class="wsus__check_single_form">
                                            <select class="select_2 ward" name="ward">
                                                <option value="0">Phường, Xã *</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        @if($errors->has('address'))
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Địa chỉ *" name="address" value="{{old('address')}}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="wsus__check_single_form">
                                            <textarea cols="3" rows="3" placeholder="Ghi chú" name="note">{{old('note')}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="wsus__check_single_form">
                                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============================
        CHECK OUT PAGE END
    ==============================-->

@endsection

@push('scripts')
    <script>
        window.addEventListener("DOMContentLoaded", (event) => {
            /* Handle Address */
            const provinceSelect = document.querySelector('.select_2.province');
            const districtSelect = document.querySelector('.select_2.district');
            const wardSelect = document.querySelector('.select_2.ward');
            const isEditMode = window.location.pathname.endsWith('/edit');

            const formatPrice = (price) => {
                return parseInt(price).toLocaleString('en').replace(/,/g, '.') + '₫';
            }


            if (provinceSelect) {
                $(provinceSelect).on('select2:select', async (e) => {
                    const provinceId = e.params.data.id;
                    if (provinceId > 0) {
                        // const endpoint = `./province/${provinceId}`;
                        const endpoint = isEditMode ? `../checkout/province/${provinceId}` : `./checkout/province/${provinceId}`;

                        const res = await fetch(endpoint);
                        const data = await res.json();
                        if (data.status === 'success') {
                            let option = '<option value="0">Chọn Quận, Huyện</option>\n';
                            let {districts} = data;
                            if (districts.length) {
                                districts.forEach(({id, _name}) => {
                                    option += `<option value="${id}">${_name}</option>\n`;
                                });
                            }
                            districtSelect.innerHTML = option;
                        }
                        wardSelect.innerHTML = '<option value="0">Chọn Phường, Xã</option>\n';
                    } else {
                        districtSelect.innerHTML = '<option value="0">Chọn Quận, Huyện</option>\n';
                        wardSelect.innerHTML = '<option value="0">Chọn Phường, Xã</option>\n';
                    }
                });
            }

            if (districtSelect) {
                $(districtSelect).on('select2:select', async (e) => {
                    const districtId = e.params.data.id;
                    if (districtId > 0) {
                        const endpoint = isEditMode ? `../checkout/district/${districtId}` : `./checkout/district/${districtId}`;
                        const res = await fetch(endpoint);
                        const data = await res.json();
                        if (data.status === 'success') {
                            let option = '<option value="0">Chọn Phường, Xã</option>\n';
                            let {wards} = data;
                            if (wards.length) {
                                wards.forEach(({id, _name}) => {
                                    option += `<option value="${id}">${_name}</option>\n`;
                                });
                            }
                            wardSelect.innerHTML = option;
                        }
                    } else {
                        wardSelect.innerHTML = '<option value="0">Chọn Phường, Xã</option>\n';
                    }
                });
            }

            // Unchecked when reload page
            const radioInputs = document.querySelectorAll('input[type="radio"]');
            radioInputs.forEach((input) => {
                input.checked = false;
            });

            //Handle total amount
            const shippingMethod = document.querySelectorAll('.shipping_method');
            document.querySelector('.shipping_method_id').value = '';
            document.querySelector('.shipping_address_id').value = '';
            if (shippingMethod) {
                shippingMethod.forEach(method => {
                    method.addEventListener('click', (e) => {
                        document.querySelector('.shipping_method_id').value = method.value;
                        document.querySelector('.shipping_fee').innerText = formatPrice(method.dataset.cost);
                        let totalAmount = parseInt(document.querySelector('.total_amount').dataset.cost) + parseInt(method.dataset.cost) - +{{getCartDiscountRaw()}};
                        document.querySelector('.total_amount').innerText = formatPrice(totalAmount);
                    })
                })
            }

            //handle shipping address
            const shippingAddress = document.querySelectorAll('.shipping_address')
            if (shippingAddress) {
                shippingAddress.forEach(address => {
                    address.addEventListener('click', (e) => {
                        document.querySelector('.shipping_address_id').value = address.dataset.id;
                    })
                })
            }

            // handle submit check out form
            const checkboxTerm = document.querySelector('.agree-term');
            let agreeTerm = checkboxTerm.checked;
            checkboxTerm.addEventListener('change', (e) => {
                agreeTerm = e.target.checked;
            });


            document.querySelector('.submit_checkout').addEventListener('click', async (e) => {
                e.preventDefault();
                const shippingMethodId = document.querySelector('.shipping_method_id').value;
                const shippingAddressId = document.querySelector('.shipping_address_id').value

                if (shippingMethodId === '') {
                    toastr.error('Chọn phương thức vận chuyển ')
                } else if (shippingAddressId === '') {
                    toastr.error('Chọn địa chỉ giao hàng')
                } else if (!agreeTerm) {
                    toastr.error('Bạn phải đồng ý với các điều khoản để tiếp tục đặt hàng')
                } else {
                    const form = document.querySelector('.check_out_form');
                    const formData = new FormData(form);
                    const data = new URLSearchParams(formData).toString();

                    try {
                        document.querySelector('.submit_checkout').innerHTML = '<i class="fas fa-spinner fa-spin fa-1x"></i>';

                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: data,
                        });

                        document.querySelector('.submit_checkout').innerHTML = 'Đặt hàng';

                        if (response.ok) {
                            const responseData = await response.json();
                            if (responseData.status === 'success') {
                                toastr.success('Đặt hàng thành công');
                                window.location.href = responseData.redirect_url;
                            }
                        } else {
                            console.error('Error submitting the form');
                        }
                    } catch (error) {
                        console.error('An error occurred while submitting the form:', error);
                    }
                }
            })

        });
    </script>
@endpush



