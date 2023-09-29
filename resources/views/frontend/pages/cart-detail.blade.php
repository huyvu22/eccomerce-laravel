@php
    $cartPageBanner = json_decode($cartPageBanner?->value)
@endphp
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
                        <h4>Giỏ hàng của tôi</h4>
                        <ul>
                            <li><a href="#">Trang chủ</a></li>
                            <li><a href="#">Giỏ hàng của tôi</a></li>
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
        CART VIEW PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="row">
                <div class="col-xl-9">
                    <div class="wsus__cart_list">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                <tr class="d-flex">
                                    <th class="wsus__pro_img">
                                        Sản phẩm
                                    </th>

                                    <th class="wsus__pro_name">
                                        Chi tiết
                                    </th>

                                    <th class="wsus__pro_tk">
                                        Giá
                                    </th>

                                    <th class="wsus__pro_select">
                                        Số lượng
                                    </th>

                                    <th class="wsus__pro_tk">
                                        Tổng tiền
                                    </th>
                                    <th class="wsus__pro_icon">
                                        <form class="form-delete" action="{{route('clear-cart')}}" method="post">
                                            @csrf
                                            <button type="button" class="clear-cart common_btn ">Xóa giỏ hàng</button>
                                        </form>

                                    </th>
                                </tr>
                                @if(count($cartItems)==0)
                                    <tr class="d-flex cart-body" >
                                        <td class="wsus__pro_tk text-center">
                                            <p class=" ext-center"> Giỏ hàng trống!</p>
                                        </td>
                                    </tr>
                                @endif
                                @foreach($cartItems as $item)
                                    <tr class="d-flex cart-body" >
                                        <input type="hidden" name="stock_quantity" value="{{getStockQuantityProduct($item->rowId)}}" class="product_stock_quantity">
                                        <td class="wsus__pro_img">
                                            <img src="{{asset($item->options->image)}}" alt="product" class="img-fluid w-100">
                                        </td>

                                        <td class="wsus__pro_name">
                                            <a class="m-2 text-center" href="{{route('product-detail',$item->options->slug)}}">{{$item->name}}</a>
                                            @if($item->options->variants)
                                                @foreach($item->options->variants as $key => $variant)
                                                    <span>{{$key}}: {{$variant['name']}} (+{{format($variant['price'])}})</span>
                                                @endforeach
                                            @endif
                                        </td>

                                        <td class="wsus__pro_tk">
                                            <h6>{{format($item->price + $item->options->variants_total)}}</h6>
                                        </td>

                                        <td class="wsus__pro_select">
                                            <form class="quantity-form select_number" action="{{route('cart.update-quantity')}}" method="post">
                                                @csrf
                                                <input class="quantity number_area" type="text" min="1" max="100" value="{{$item->qty}}" data-rowid="{{$item->rowId}}" name="quantity" />
                                                <input class="price" type="hidden" value="{{$item->price + $item->options->variants_total}}" name="price-total" />
                                            </form>
                                        </td>

                                        <td class="wsus__pro_tk">
                                            <h6 class="price-total" id="{{$item->rowId}}">{{format(($item->price + $item->options->variants_total) * $item->qty)}}</h6>
                                            <input type="hidden" name="price-subtotal-hidden" class="price-subtotal-hidden" data-price-total="{{$item->price + $item->options->variants_total}}">
                                        </td>

                                        <td class="wsus__pro_icon">
                                            <a href="{{route('cart.remove-item',$item->rowId)}}"><i class="far fa-times remove-cart-item"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                        <h6>Thành tiền</h6>
                        <p>Tạm tính: <span class="sub_total">{{getCartTotal()}}</span></p>
                        <p>Giảm giá: <span class="discount">{{getCartDiscount()}}</span></p>
                        <p class="total"><span>Thành tiền:</span> <span class="cart_total_amount">{{getMainCartTotal()}}</span></p>

                        <form class="coupon_form" action="{{route('apply-coupon')}}" method="post">
                            @csrf
                            <input type="text" placeholder="code 5555" name="coupon_code" class="coupon_value" value="{{session()->has('coupon') ? session()->get('coupon')['coupon_code'] : ''}}">
                            <button type="button" class="common_btn apply-btn">Áp dụng</button>
                        </form>
                        <a class="common_btn mt-4 w-100 text-center" href="{{route('user.checkout')}}">Thanh toán</a>
                        <a class="common_btn mt-1 w-100 text-center" href="{{route('home')}}"><i class="fab fa-shopify"></i> Tiếp tục mua hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="wsus__single_banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    @if($cartPageBanner->banner_1->banner_status)
                        <div class="wsus__single_banner_content">
                            <div class="wsus__single_banner_img">
                                <img src="{{asset($cartPageBanner->banner_1->banner_image)}}" alt="banner" class="img-fluid w-100">
                            </div>
                            <div class="wsus__single_banner_text">

                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-xl-6 col-lg-6">
                    @if($cartPageBanner->banner_2->banner_status)
                        <div class="wsus__single_banner_content single_banner_2">
                            <div class="wsus__single_banner_img">
                                <img src="{{asset($cartPageBanner->banner_2->banner_image)}}" alt="banner" class="img-fluid w-100">
                            </div>
                            <div class="wsus__single_banner_text">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--============================
          CART VIEW PAGE END
    ==============================-->
@endsection

@push('scripts')
    <script>

        window.addEventListener("DOMContentLoaded", (event) => {

             // Handle Update Quantity
            const decreaseBtns = document.querySelectorAll('.sub');
            const increaseBtns = document.querySelectorAll('.add');
            const priceTotalArr = document.querySelectorAll('.price-total')
            const productStockQuantity = document.querySelector('.product_stock_quantity');
            const subTotal = document.querySelector('.sub_total');

            // format price
            const formatPrice = (price)=>{
                return  parseInt(price).toLocaleString('en').replace(/,/g, '.')+'₫' ;
            }

            // Update Sub total
            function updateSubTotal() {
                const subTotalAmount = document.querySelectorAll('.price-subtotal-hidden');
                let totalPrice = 0;
                subTotalAmount.forEach((subTotal) => {
                    totalPrice += parseInt(subTotal.dataset.priceTotal);
                });
                subTotal.innerText = totalPrice.toLocaleString('en').replace(/,/g, '.') + '₫';
            }

            // update calculateCouponDiscount
            const calculateCouponDiscount = async (e) => {
                try {
                    const response = await fetch("/coupon-calculation");
                    if (response.ok) {
                        const data = await response.json();
                        console.log(data)
                        if(data.status === 'success') {
                            document.querySelector('.cart_total_amount').innerText = formatPrice(data.total);
                            document.querySelector('.discount').innerText = formatPrice(data.discount);
                        }
                    } else {
                        console.error("Error fetching cart count");
                    }
                } catch (error) {
                    console.error("An error occurred while fetching cart products:", error);
                }
            }

            // Update Price when click decrease
            if(decreaseBtns.length > 0){
                decreaseBtns.forEach((decreaseBtn=>{
                    decreaseBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        // await calculateCouponDiscount()
                        const form = e.target.closest('form');
                        const quantityInput = form.querySelector('.quantity');
                        const priceInput = form.querySelector('.price');
                        const rowId = quantityInput.dataset.rowid;
                        let priceProduct = priceInput.value
                        let quantity = parseInt(quantityInput.value) - 1;
                        if(quantity >= 1){
                            priceTotalArr.forEach((priceTotal)=>{
                               if(priceTotal.id == rowId){
                                   priceTotal.innerText = (((priceProduct) * quantity).toLocaleString('en').replace(/,/g, '.'))+'₫' ;
                                   priceTotal.nextElementSibling.dataset.priceTotal = priceProduct * quantity;
                               }
                            })
                            submitForm(form, quantity, rowId);
                            const increaseBtn = form.querySelector('.add');
                            increaseBtn.classList.remove('d-none');
                        }
                        updateSubTotal()
                    });
                }))
            }


            // Update Price when click decrease
            if(increaseBtns.length > 0){
                increaseBtns.forEach((increaseBtn=>{
                    increaseBtn.addEventListener('click',  (e) => {
                        e.preventDefault();
                        const form = e.target.closest('form');
                        const quantityInput = form.querySelector('.quantity');
                        const priceInput = form.querySelector('.price');
                        const rowId = quantityInput.dataset.rowid;
                        let priceProduct = priceInput.value
                        let quantity = parseInt(quantityInput.value) + 1;
                        if(quantity <= productStockQuantity.value + 1){
                            priceTotalArr.forEach((priceTotal)=>{
                                if(priceTotal.id == rowId){
                                    priceTotal.innerText = ((priceProduct) * quantity).toLocaleString('en').replace(/,/g, '.')+'₫' ;
                                    priceTotal.nextElementSibling.dataset.priceTotal = priceProduct * quantity;
                                }
                            })
                            submitForm(form, quantity, rowId);
                        }else {
                            increaseBtn.classList.add('d-none');
                            toastr.error('Quantity not available')
                        }

                        updateSubTotal()
                    });
                }))
            }

            // Update product when handle in cart detail page
            const sidebarProducts = document.querySelector('.mini-cart-wrapper');
            const fetchSideBarProducts = async (e) => {
                let li = '';
                try {
                    const response = await fetch("/cart-products");
                    if (response.ok) {
                        const data = await response.json();
                        let { cartProducts } = data;
                        let cartProductArr = Object.values(cartProducts);
                        if (cartProductArr.length) {
                            cartProductArr.forEach((item) => {
                                li += `<li class="mini_cart_${item.rowId}">
                                        <div class="wsus__cart_img">
                                            <a href="{{url('product-detail')}}/${item.options.slug}.html"><img src="{{asset('/')}}${item.options.image}" alt="product" class="img-fluid w-100"></a>
                                            <form class="form-delete-item"  action="{{url('cart/remove-sidebar-product')}}" method="POST">
                                                  @csrf
                                <button class="remove-item wsis__del_icon" data-rowid="${item.rowId}" type="button">&times;</button>
                                            </form>
                                        </div>
                                        <div class="wsus__cart_text">
                                            <a class="wsus__cart_title" href="{{url('product-detail')}}/${item.options.slug}.html">${item.name}</a>
                                            <p>${formatPrice(item.price + item.options.variants_total)}</p>
                                             <small>Slg: ${item.qty}</small>
                                        </div>
                                    </li>`;
                            });

                            sidebarProducts.innerHTML = li;
                            await getSubTotal();
                        }
                    } else {
                        console.error("Error fetching cart count");
                    }
                } catch (error) {
                    console.error("An error occurred while fetching cart products:", error);
                }
            };

            // Show total Price in Sidebar
            const getSubTotal = async ()=>{
                try {
                    const response = await fetch("/cart/sidebar-product-total");
                    if (response.ok) {
                        const data = await response.json();
                        document.querySelector('.mini_cart_subtotal').innerHTML = formatPrice(data.total)

                    } else {
                        console.error("Error fetching cart count");
                    }
                } catch (error) {
                    console.error("An error occurred while fetching cart count:", error);
                }
            }


            // Send form handle
            async function submitForm(form, quantity, rowId) {
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: `quantity=${quantity}&rowId=${rowId}`
                    });

                    // Handle the response
                    if (response.ok) {
                        const data = await response.json();
                        if(data.status === 'success'){
                            toastr.success(data.message);
                            await calculateCouponDiscount()
                            await fetchSideBarProducts()
                        }else if(data.status ==='error'){
                            toastr.error(data.message);
                        }
                    } else {
                        console.error('Error submitting the form');
                    }
                } catch (error) {
                    console.error('An error occurred while submitting the form:', error);
                }
            }

            //Apply Coupon
            const form = document.querySelector('.coupon_form');
            const applyBtn = form.querySelector('.apply-btn');

            applyBtn.addEventListener('click', async (e) => {
                e.preventDefault();

                const formData = new FormData(form);
                const data = new URLSearchParams(formData).toString();

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: data,
                    });
                    if (response.ok) {
                        const data = await response.json();
                        if(data.status ==='error'){
                            toastr.error(data.message);
                        }else if(data.status ==='success'){
                            await calculateCouponDiscount()
                            toastr.success(data.message);
                        }
                    } else {
                        console.error('Error submitting the form');
                    }
                } catch (error) {
                    console.error('An error occurred while submitting the form:', error);
                }
            });

            /*== Delete Cart ==*/
           document.querySelector('.table-responsive').addEventListener('click', (e)=>{
               if (e.target.classList.contains('clear-cart')) {
                   e.preventDefault();
                   const formDelete = e.target.closest('.form-delete');
                   if (formDelete) {
                       Swal.fire({
                           title: 'Are you sure?',
                           text: "You won't be able to revert this!",
                           icon: 'warning',
                           showCancelButton: true,
                           confirmButtonColor: '#3085d6',
                           cancelButtonColor: '#d33',
                           confirmButtonText: 'Yes, delete it!'
                       }).then((result) => {
                           if (result.isConfirmed) {
                               formDelete.submit();
                           }
                       });
                   }
               }
           })

        });
    </script>
@endpush
