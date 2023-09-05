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
                        <h4>check out</h4>
                        <ul>
                            <li><a href="{{route('home')}}">home</a></li>
                            <li><a href="javascript:">check out</a></li>
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
                            <h5>Shipping Details</h5>
                            <button class="btn common_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New Address</button>
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
                                                    Select Address
                                                </label>
                                            </div>
                                            <ul>
                                                <li><span>Name :</span> {{$address->name}}</li>
                                                <li><span>Phone :</span> {{$address->phone}}</li>
                                                <li><span>Email :</span> {{isset($address->email) ? $address->email : ''}}</li>
                                                <li><span>Province,City:</span> {{$address->province}}</li>
                                                <li><span>District :</span> {{$address->district}}</li>
                                                <li><span>Ward :</span> {{$address->ward}}</li>
                                                <li><span>Address :</span> {{$address->address}}</li>
                                                <li><span>Note :</span> {{$address->note}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="wsus__order_details" id="sticky_sidebar">
                        <p class="wsus__product">shipping Methods</p>
                        @foreach($shippingMethods as $shippingMethod)
                            @if(getCartTotal()>=$shippingMethod->min_cost)
                                <div class="form-check">
                                    <input class="form-check-input shipping_method" type="radio" name="exampleRadios" id="exampleRadios-{{$shippingMethod->id}}"
                                           value="{{$shippingMethod->id}}" data-cost="{{$shippingMethod->cost}}" >
                                    <label class="form-check-label" for="exampleRadios-{{$shippingMethod->id}}">
                                        {{$shippingMethod->name}}
                                        <span>cost: {{format($shippingMethod->cost)}}</span>
{{--                                            <span>(1 - 2 days)</span>--}}
                                    </label>
                                </div>
                            @elseif(getCartTotal()<$shippingMethod->min_cost)
                                <div class="form-check">
                                    <input class="form-check-input shipping_method" type="radio" name="exampleRadios" id="exampleRadios-{{$shippingMethod->id}}"
                                           value="{{$shippingMethod->id}}" data-cost="{{$shippingMethod->cost}}">
                                    <label class="form-check-label" for="exampleRadios-{{$shippingMethod->id}}">
                                        {{$shippingMethod->name}}
                                        <span>(3 - 5 days)</span>
                                    </label>
                                </div>
                            @endif
                        @endforeach
                        <div class="wsus__order_details_summery">
                            <p>subtotal: <span>{{getCartTotal()}}</span></p>
                            <p>shipping fee: <span class="shipping_fee">0₫</span></p>
                            <p>coupon: <span>{{getCartDiscount()}}</span></p>
                            <p><b>total:</b> <span><b class="total_amount" data-cost="{{getCartTotalRaw()}}">{{getMainCartTotal()}}</b></span></p>
                        </div>
                        <div class="terms_area">
                            <div class="form-check">
                                <input class="form-check-input agree-term" type="checkbox" value="" id="flexCheckChecked3"
                                       checked>
                                <label class="form-check-label" for="flexCheckChecked3">
                                    I have read and agree to the website <a href="#">terms and conditions *</a>
                                </label>
                            </div>
                        </div>

                        <form action="{{route('user.checkout.form-submit')}}" class="check_out_form" method="post">
                            @csrf
                            <input type="hidden" name="shipping_method_id" class="shipping_method_id" value="">
                            <input type="hidden" name="shipping_address_id" class="shipping_address_id" value="">
                        </form>

                        <a href="" class="common_btn submit_checkout">Place Order</a>
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
                        <h5 class="modal-title" id="exampleModalLabel">add new address</h5>
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
                                            <input type="text" placeholder="Name" name="name" value="{{old('name')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                            @if($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Phone" name="phone" value="{{old('phone')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                            @if($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Email (Optional)" name="email" value="{{old('email')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                            @if($errors->has('province'))
                                                <span class="text-danger">{{ $errors->first('province') }}</span>
                                            @endif
                                        <div class="wsus__check_single_form">
                                            <select class="select_2 province" name="province">
                                                <option value="0">Province, City *</option>
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
                                                <option value="0">District *</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                            @if($errors->has('ward'))
                                                <span class="text-danger">{{ $errors->first('ward') }}</span>
                                            @endif
                                        <div class="wsus__check_single_form">
                                            <select class="select_2 ward" name="ward">
                                                <option value="0">Ward *</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                            @if($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Address *" name="address" value="{{old('address')}}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="wsus__check_single_form">
                                            <textarea cols="3" rows="3" placeholder="Note" name="note">{{old('note')}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="wsus__check_single_form">
                                            <button type="submit" class="btn btn-primary">Save</button>
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

        const formatPrice = (price)=>{
            return  parseInt(price).toLocaleString('en').replace(/,/g, '.')+'₫' ;
        }


        if (provinceSelect) {
            $(provinceSelect).on('select2:select', async (e) => {
                const provinceId = e.params.data.id;
                if(provinceId >0){
                    // const endpoint = `./province/${provinceId}`;
                    const endpoint = isEditMode ? `../checkout/province/${provinceId}` : `./checkout/province/${provinceId}`;

                    const res = await fetch(endpoint);
                    const data = await res.json();
                    if (data.status === 'success') {
                        let option = '<option value="0">Chọn Quận, Huyện</option>\n';
                        let { districts } = data;
                        if (districts.length) {
                            districts.forEach(({ id, _name }) => {
                                option += `<option value="${id}">${_name}</option>\n`;
                            });
                        }
                        districtSelect.innerHTML = option;
                    }
                    wardSelect.innerHTML = '<option value="0">Chọn Phường, Xã</option>\n';
                }else {
                    districtSelect.innerHTML = '<option value="0">Chọn Quận, Huyện</option>\n';
                    wardSelect.innerHTML = '<option value="0">Chọn Phường, Xã</option>\n';
                }
            });
        }

        if (districtSelect) {
            $(districtSelect).on('select2:select', async (e) => {
                const districtId = e.params.data.id;
                if(districtId >0){
                    const endpoint = isEditMode ? `../checkout/district/${districtId}` : `./checkout/district/${districtId}`;
                    const res = await fetch(endpoint);
                    const data = await res.json();
                    if (data.status === 'success') {
                        let option = '<option value="0">Chọn Phường, Xã</option>\n';
                        let { wards } = data;
                        if (wards.length) {
                            wards.forEach(({ id, _name }) => {
                                option += `<option value="${id}">${_name}</option>\n`;
                            });
                        }
                        wardSelect.innerHTML = option;
                    }
                }else {
                    wardSelect.innerHTML = '<option value="0">Chọn Phường, Xã</option>\n';
                }
            });
        }

        // Unchecked when reload page
        const radioInputs = document.querySelectorAll('input[type="radio"]');
        radioInputs.forEach((input) => {
            input.checked = false;
        });


        //Handle Shipping Fee
        const shippingMethod = document.querySelectorAll('.shipping_method');
        document.querySelector('.shipping_method_id').value = '';
        document.querySelector('.shipping_address_id').value = '';
        if(shippingMethod){
            shippingMethod.forEach(method =>{
                method.addEventListener('click', (e) =>{
                    document.querySelector('.shipping_method_id').value = method.value;
                    document.querySelector('.shipping_fee').innerText = formatPrice(method.dataset.cost);
                    let totalAmount =  parseInt(document.querySelector('.total_amount').dataset.cost) + parseInt(method.dataset.cost);
                    document.querySelector('.total_amount').innerText = formatPrice(totalAmount);
                })
            })
        }

        //handle shipping address
        const shippingAddress = document.querySelectorAll('.shipping_address')
        if(shippingAddress){
            shippingAddress.forEach(address =>{
                address.addEventListener('click', (e) =>{
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


        document.querySelector('.submit_checkout').addEventListener('click', async (e) =>{
            e.preventDefault();
            const shippingMethodId =  document.querySelector('.shipping_method_id').value;
            const shippingAddressId =  document.querySelector('.shipping_address_id').value

            if(shippingMethodId ===''){
                toastr.error('Chọn phương thức vận chuyển ')
            }else if(shippingAddressId === ''){
                toastr.error('Chọn địa chỉ giao hàng')
            }else if(!agreeTerm){
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



