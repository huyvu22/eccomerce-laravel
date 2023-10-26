@php
    use App\Models\Order;
    use App\Models\ProductReviewGallery;
@endphp
@extends('frontend.layouts.master')
@section('title')
    Shop Now | Chi tiết sản phẩm
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
                        <h4>Chi tiết sản phẩm</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">Trang chủ</a></li>
                            <li><a href="javascript:">Chi tiết sản phẩm</a></li>
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
                                    PRODUCT DETAILS START
                                ==============================-->
    <section id="wsus__product_details">
        <div class="container">
            <div class="wsus__details_bg_1">
                <div class="row">
                    <div class="col-xl-4 col-md-5 col-lg-5" style="z-index: 99 !important;">
                        <div id="sticky_pro_zoom">
                            <div class="exzoom hidden" id="exzoom">
                                <div class="exzoom_img_box">
                                    @if (isset($product->video_link))
                                        <a class="venobox wsus__pro_det_video" data-autoplay="true" data-vbtype="video"
                                            href="{{ $product->video_link }}">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    @endif

                                    <ul class='exzoom_img_ul'>
                                        @if (isset($product->thumb_image))
                                            @foreach ($product->productImageGalleries as $image)
                                                <li><img class="zoom img-fluid w-100" src="{{ asset($image->image) }}"
                                                        alt="product"></li>
                                            @endforeach
                                            <li><img class="zoom img-fluid w-100" src="{{ asset($product->thumb_image) }}"
                                                    alt="product"></li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="exzoom_nav"></div>
                                <p class="exzoom_btn">
                                    <a href="javascript:void(0);" class="exzoom_prev_btn"> <i
                                            class="far fa-chevron-left"></i> </a>
                                    <a href="javascript:void(0);" class="exzoom_next_btn"> <i
                                            class="far fa-chevron-right"></i> </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-md-7 col-lg-7">
                        <div class="wsus__pro_details_text">
                            <a class="title" href="javascript:;">{{ @$product->name }}</a>
                            @if ($product->quantity > 0)
                                <p class="wsus__stock_area"><span class="in_stock">Còn hàng</span> ({{ $product->quantity }}
                                    sản phẩm)</p>
                            @elseif($product->quantity == 0)
                                <p class="wsus__stock_area"><span class="in_stock">Hết hàng</span> ({{ $product->quantity }}
                                    sản phẩm)</p>
                            @endif
                            @if (checkDiscount($product))
                                <h4><span class="product_price">{{ format($product->offer_price) }}</span>
                                    <del class="old_product_price">{{ format($product->price) }}</del>
                                </h4>
                                <input type="hidden" class="input_price"
                                    value="{{ $product->offer_price }} {{ $product->price }}">
                            @else
                                <h4><span class="product_price">{{ format($product->price) }}</span></h4>
                                <input type="hidden" class="input_price" value="{{ $product->price }}">
                            @endif

                            <p class="review">
                                @php
                                    $avgRating = $product->reviews()->avg('rating');
                                    $avgRating = round($avgRating);
                                @endphp

                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $avgRating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor

                                <span>({{ $product->reviews->count() }} đánh giá)</span>

                            </p>
                            <p class="description">{!! $product->short_description !!}</p>

                            <form class="shopping-cart-form" action="{{ route('add-to-cart') }}" method="post">
                                @csrf
                                <div class="wsus__selectbox">
                                    <div class="row">
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        @if ($product->variants->count() > 0)
                                            @foreach ($product->variants as $variant)
                                                @if ($variant->status == 1)
                                                    <div class="col-xl-6 col-sm-6">
                                                        <h5 class="mb-2">{{ $variant->name }}: </h5>
                                                        <select class="attribute select_2" name="variants_items[]">
                                                            @foreach ($variant->variantItems as $variantItem)
                                                                @if ($variantItem->status == 1)
                                                                    <option value="{{ $variantItem->id }}"
                                                                        title="{{ $variantItem->price }}"
                                                                        {{ $variantItem->is_default == 1 ? 'selected' : '' }}>
                                                                        {{ $variantItem->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="wsus__quentity">
                                    <h5>Số lượng :</h5>
                                    <div class="select_number">
                                        <input class=" quantity number_area" type="text" min="1" max="100"
                                            value="1" name="qty" />
                                    </div>
                                </div>
                                <ul class="wsus__button_area">
                                    <li>
                                        <button type="button" class="add_cart">Thêm vào giỏ</button>
                                    </li>
                                    <li>
                                        <button style="border: none" type="button" class="buy_now"
                                            data-buy-product-route="{{ route('buy-product') }}">Mua ngay</button>
                                    </li>
                                    <li><a href="#" class="add_to_wishlist"
                                            data-route="{{ route('user.wishlist.store', ['productId' => $product->id]) }}"><i
                                                class="fal fa-heart add_to_wishlist"></i></a></li>
                                </ul>
                            </form>
                            <p class="brand_model"><span>Thương hiệu :</span> {{ $product->brand->name }}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 mt-md-5 mt-lg-0">
                        <div class="wsus_pro_det_sidebar" id="sticky_sidebar">
                            <ul>
                                <li>
                                    <span><i class="fal fa-truck"></i></span>
                                    <div class="text">
                                        <h4>Giao hàng nhanh chóng</h4>
                                        <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                    </div>
                                </li>
                                <li>
                                    <span><i class="far fa-shield-check"></i></span>
                                    <div class="text">
                                        <h4>Bảo mật thông tin</h4>
                                        <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                    </div>
                                </li>
                                <li>
                                    <span><i class="fal fa-envelope-open-dollar"></i></span>
                                    <div class="text">
                                        <h4>Bảo hành chính hãng</h4>
                                        <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__pro_det_description">
                        <div class="wsus__details_bg_2">
                            <ul class="nav nav-pills mb-3" id="pills-tab3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab7" data-bs-toggle="pill"
                                        data-bs-target="#pills-home22" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true">Mô tả
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact" type="button" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">Gian hàng
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab2" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact2" type="button" role="tab"
                                        aria-controls="pills-contact2" aria-selected="false">Đánh giá
                                    </button>
                                </li>

                            </ul>
                            <div class="tab-content" id="pills-tabContent4">
                                <div class="tab-pane fade  show active " id="pills-home22" role="tabpanel"
                                    aria-labelledby="pills-home-tab7">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="wsus__description_area">
                                                {!! $product->full_description !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-md-4">
                                                <div class="description_single">
                                                    <h6><span>1</span> Miễn phí vận chuyển</h6>
                                                    <p>Giao hàng miễn phí trong 24h (chỉ áp dụng khu vực nội thành)</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4">
                                                <div class="description_single">
                                                    <h6><span>2</span> Sản phẩm chính hãng</h6>
                                                    <p>Hoàn tiền 100% nếu phát hiện hàng dựng hoặc có nơi khác bán rẻ hơn.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4">
                                                <div class="description_single">
                                                    <h6><span>3</span> Số 1 về bảo hành </h6>
                                                    <p>Chính sách 1 ĐỔI 1 lên đến 1 năm. Bảo hành lên đến 5 năm với các sản
                                                        phẩm điện tử.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">
                                    <div class="wsus__pro_det_vendor">
                                        <div class="row">
                                            <div class="col-xl-6 col-xxl-5 col-md-6">
                                                <div class="wsus__vebdor_img">
                                                    <img src="{{ asset($product->vendor->banner) }}" alt="vensor"
                                                        class="img-fluid w-100">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-xxl-7 col-md-6 mt-4 mt-md-0">
                                                <div class="wsus__pro_det_vendor_text">
                                                    <h4>{{ $product->vendor->shop_name }}</h4>
                                                    <p class="rating">
                                                        @php
                                                            $avgRating = $product->reviews()->avg('rating');
                                                            $avgRating = round($avgRating);
                                                        @endphp

                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $avgRating)
                                                                <i class="fas fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor

                                                        <span>({{ $product->reviews->count() }} review)</span>

                                                    </p>
                                                    <p><span>Tên gian hàng:</span> {{ $product->vendor->shop_name }}</p>
                                                    <p><span>Địa chỉ:</span> {{ $product->vendor->address }}</p>
                                                    <p><span>Điện thoại:</span> {{ $product->vendor->phone }}</p>
                                                    <p><span>Email:</span> {{ $product->vendor->email }}</p>
                                                    <a href="{{ route('vendor.products', $product->vendor) }}"
                                                        class="see_btn">Truy cập gian hàng</a>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="wsus__vendor_details">
                                                    {!! $product->vendor->description !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-contact2" role="tabpanel"
                                    aria-labelledby="pills-contact-tab2">
                                    <div class="wsus__pro_det_review">
                                        <div class="wsus__pro_det_review_single">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-7">
                                                    <div class="wsus__comment_area">
                                                        <h4>Đánh giá <span>{{ count($reviews) }}</span></h4>
                                                        @foreach ($reviews as $review)
                                                            <div class="wsus__main_comment">
                                                                <div class="wsus__comment_img">
                                                                    <img src="{{ $review->user->image ?  $review->user->image : asset('uploads/avatar-2.png')}}" alt="user"
                                                                        class="img-fluid w-100">
                                                                </div>
                                                                <div class="wsus__comment_text reply">
                                                                    <h6>{{ $review->user->name }}
                                                                        <span>{{ $review->rating }}<i
                                                                                class="fas fa-star"></i></span>
                                                                    </h6>
                                                                    <span>{{ Carbon\Carbon::parse($review->created_at)->format('d-m-Y') }}</span>
                                                                    <p>{{ $review->review }}</p>

                                                                    <ul class="">
                                                                        @if (count($review->reviewGalleries) > 0)
                                                                            @foreach ($review->reviewGalleries as $gallery)
                                                                                <li><img src="{{ asset($gallery->image) }}"
                                                                                        alt="product"
                                                                                        class="img-fluid w-100"></li>
                                                                            @endforeach
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                        <div class="text-center">
                                                            <div class="mt-3 d-inline-block">
                                                                @if ($reviews->hasPages())
                                                                    {{ $reviews->links() }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-5 mt-4 mt-lg-0">

                                                    @php
                                                        $existItem = true;
                                                        $checkOrders = Order::where(['user_id' => Auth::user()?->id, 'order_status' => 'delivered'])->get();
                                                        foreach ($checkOrders as $order) {
                                                            $existItem = $order
                                                                ->orderProducts()
                                                                ->where('product_id', $product->id)
                                                                ->exists(); // true or false
                                                        }
                                                    @endphp
                                                        @if (auth()->check())
                                                            <div class="wsus__post_comment rev_mar" id="sticky_sidebar3">
                                                                <h4>Bình luận</h4>
                                                                <form action="{{ route('user.review.create') }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <p class="rating">
                                                                        <span>Đánh giá chất lượng : </span>
                                                                        <i class="fas fa-star"></i>
                                                                        <i class="fas fa-star"></i>
                                                                        <i class="fas fa-star"></i>
                                                                        <i class="fas fa-star"></i>
                                                                        <i class="fas fa-star"></i>
                                                                    </p>
                                                                    <div class="row">
                                                                        <div class="col-xl-12">
                                                                            <div class="wsus__single_com">
                                                                                <select name="rating"
                                                                                    class="form-control mb-4"
                                                                                    id="">
                                                                                    <option value="">Chọn</option>
                                                                                    <option value="1">1</option>
                                                                                    <option value="2">2</option>
                                                                                    <option value="3">3</option>
                                                                                    <option value="4">4</option>
                                                                                    <option value="5">5</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-12">
                                                                            <div class="col-xl-12">
                                                                                <div class="wsus__single_com">
                                                                                    <textarea cols="3" rows="3" name="review" placeholder="Bình luận"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="img_upload">
                                                                        <div class="gallery">
                                                                            <input type="file" name="images[]"
                                                                                multiple>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="product_id"
                                                                        value="{{ $product->id }}">
                                                                    <input type="hidden" name="vendor_id"
                                                                        value="{{ $product->vendor_id }}">
                                                                    <button class="common_btn" type="submit">
                                                                        Gửi
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <div class="wsus__post_comment rev_mar" id="sticky_sidebar3">
                                                                <h4>Đăng nhập để đánh giá sản phẩm</h4>
                                                                    <a href='{{route('login')}}' class="common_btn" type="submit">
                                                                        Đăng nhập
                                                                    </a>
                                                            </div>
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--============================
                                    PRODUCT DETAILS END
                                ==============================-->


    <!--============================
                                    RELATED PRODUCT START
                                ==============================-->
    <section id="wsus__flash_sell">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__section_header mt-5">
                        <h3>SẢN PHẨM LIÊN QUAN</h3>
                        <a class="see_btn"
                            href="{{ route('products.index', ['category' => $product->category->slug]) }}">Xem thêm <i
                                class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row flash_sell_slider">
                @if ($relatedProducts->count() > 0)
                    @foreach (@$relatedProducts as $product)
                        <div class="col-xl-3 col-sm-6 col-lg-4">
                            <div class="wsus__product_item">
                                <span class="wsus__new">{{ productType($product->product_type) }}</span>
                                @if (checkDiscount($product))
                                    <span
                                        class="wsus__minus">-{{ discountPercent($product->price, $product->offer_price) }}%</span>
                                @endif
                                <a class="wsus__pro_link" href="{{ route('product-detail', $product->slug) }}">
                                    <img src="{{ asset($product->thumb_image) }}" alt="product"
                                        class="img-fluid w-100 img_1" />
                                    <img src="{{ asset(isset($product->productImageGalleries[0]->image) ? $product->productImageGalleries[0]->image : $product->thumb_imag) }}"
                                        alt="product" class="img-fluid w-100 img_2" />
                                </a>
                                <ul class="wsus__single_pro_icon">
                                    <li><a href="#" data-bs-toggle="modal"
                                            data-bs-target="#product-type-{{ $product->id }}"><i
                                                class="far fa-eye"></i></a></li>
                                    <li><a href="#" class="add_to_wishlist"
                                            data-route="{{ route('user.wishlist.store', ['productId' => $product->id]) }}"><i
                                                class="fal fa-heart add_to_wishlist"></i></a></li>
                                </ul>
                                <div class="wsus__product_details">
                                    <a class="wsus__category" href="#">{{ $product->category->name }} </a>
                                    <p class="wsus__pro_rating">
                                        @php
                                            $avgRating = $product->reviews()->avg('rating');
                                            $avgRating = round($avgRating);
                                        @endphp

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $avgRating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor

                                        <span>({{ $product->reviews->count() }} đánh giá)</span>
                                    </p>
                                    <a class="wsus__pro_name"
                                        href="{{ route('product-detail', $product->slug) }}">{{ $product->name }}</a>
                                    @if (checkDiscount($product))
                                        <p class="wsus__price">{{ format($product->offer_price) }}
                                            <del>{{ format($product->price) }}</del>
                                        </p>
                                    @else
                                        <p class="wsus__price">{{ format($product->price) }} </p>
                                    @endif

                                    <form class="shopping-cart-form" action="{{ route('add-to-cart') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        @foreach ($product->variants as $variant)
                                            <select class="attribute d-none" name="variants_items[]">
                                                @foreach ($variant->variantItems as $variantItem)
                                                    <option value="{{ $variantItem->id }}"
                                                        title="{{ $variantItem->price }}"
                                                        {{ $variantItem->is_default == 1 ? 'selected' : '' }}>
                                                        {{ $variantItem->name }}</option>
                                                @endforeach
                                            </select>
                                        @endforeach
                                        <input class=" quantity" type="hidden" min="1" max="100"
                                            value="1" name="qty" />
                                        <button style="border: none" type="button" class="add_cart">Thêm vào
                                            giỏ</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!--============================
                                    RELATED PRODUCT END
                                ==============================-->

    <!--==========================
                            PRODUCT MODAL VIEW START
                            ===========================-->
    @foreach ($relatedProducts as $product)
        <section class="product_popup_modal">
            <div class="modal fade" id="product-type-{{ $product->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                    class="far fa-times"></i></button>
                            <div class="row">
                                <div class="col-xl-6 col-12 col-sm-10 col-md-8 col-lg-6 m-auto display">
                                    <div class="wsus__quick_view_img">
                                        @if ($product->video_link)
                                            <a class="venobox wsus__pro_det_video" data-autoplay="true"
                                                data-vbtype="video" href="{{ $product->video_link }}">
                                                <i class="fas fa-play"></i>
                                            </a>
                                        @endif

                                        <div class="row modal_slider">
                                            <div class="col-xl-12">
                                                <div class="modal_slider_img">
                                                    <img src="{{ asset($product->thumb_image) }}" alt="product"
                                                        class="img-fluid w-100">
                                                </div>
                                            </div>
                                            @foreach ($product->productImageGalleries as $image)
                                                <div class="col-xl-12">
                                                    <div class="modal_slider_img">
                                                        <img src="{{ asset($image->image) }}" alt="product"
                                                            class="img-fluid w-100">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="wsus__pro_details_text">
                                        <a class="title"
                                            href="{{ route('product-detail', $product->slug) }}">{{ $product->name }}</a>
                                        @if (checkDiscount($product))
                                            <h4><span class="product_price">{{ format($product->offer_price) }}</span>
                                                <del class="old_product_price">{{ format($product->price) }}</del>
                                            </h4>
                                            <input type="hidden" class="input_price"
                                                value="{{ $product->offer_price }} {{ $product->price }}">
                                        @else
                                            <h4><span class="product_price">{{ format($product->price) }}</span></h4>
                                            <input type="hidden" class="input_price" value="{{ $product->price }}">
                                        @endif
                                        <p class="review">
                                            @php
                                                $avgRating = $product->reviews()->avg('rating');
                                                $avgRating = round($avgRating);
                                            @endphp

                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $avgRating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor

                                            <span>({{ $product->reviews->count() }} đánh giá)</span>
                                        </p>
                                        <p class="description">{!! $product->short_description !!}</p>

                                        <form class="shopping-cart-form" action="{{ route('add-to-cart') }}"
                                            method="post">
                                            @csrf
                                            <div class="wsus__selectbox">
                                                <div class="row">
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    @if ($product->variants->count() > 0)
                                                        @foreach ($product->variants as $variant)
                                                            @if ($variant->status == 1)
                                                                <div class="col-xl-6 col-sm-6">
                                                                    <h5 class="mb-2">{{ $variant->name }}: </h5>
                                                                    <select class="attribute select_2"
                                                                        name="variants_items[]">
                                                                        @foreach ($variant->variantItems as $variantItem)
                                                                            @if ($variantItem->status == 1)
                                                                                <option value="{{ $variantItem->id }}"
                                                                                    title="{{ $variantItem->price }}"
                                                                                    {{ $variantItem->is_default == 1 ? 'selected' : '' }}>
                                                                                    {{ $variantItem->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="wsus__quentity">
                                                <h5>Số lượng :</h5>
                                                <div class="select_number">
                                                    <input class=" quantity number_area" type="text" min="1"
                                                        max="100" value="1" name="qty" />
                                                </div>
                                            </div>
                                            <ul class="wsus__button_area">
                                                <li>
                                                    <button type="button" class="add_cart">Thêm vào giỏ</button>
                                                </li>
                                                <li>
                                                    <button style="border: none" type="button" class="buy_now"
                                                        data-buy-product-route="{{ route('buy-product') }}">Mua
                                                        ngay</button>
                                                </li>
                                                <li><a href="#" class="add_to_wishlist"
                                                        data-route="{{ route('user.wishlist.store', ['productId' => $product->id]) }}"><i
                                                            class="fal fa-heart add_to_wishlist"></i></a></li>
                                            </ul>
                                        </form>
                                        <p class="brand_model"><span>Thương hiệu :</span> {{ $product->brand->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach

    <!--==========================
                              PRODUCT MODAL VIEW END
                            ===========================-->

@endsection
