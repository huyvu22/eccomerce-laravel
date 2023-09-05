@php use App\Models\Order;use App\Models\ProductReviewGallery; @endphp
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
                        <h4>products details</h4>
                        <ul>
                            <li><a href="#">home</a></li>
                            <li><a href="#">product details</a></li>
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
            <div class="wsus__details_bg">
                <div class="row">
                    <div class="col-xl-4 col-md-5 col-lg-5" style="z-index: 99 !important;">
                        <div id="sticky_pro_zoom">
                            <div class="exzoom hidden" id="exzoom">
                                <div class="exzoom_img_box">
                                    @if(isset($product->video_link))
                                        <a class="venobox wsus__pro_det_video" data-autoplay="true" data-vbtype="video"
                                           href="{{$product->video_link}}">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    @endif

                                    <ul class='exzoom_img_ul'>
                                        @if(isset($product->thumb_image))
                                            @foreach($product->productImageGalleries as $image)
                                                <li><img class="zoom img-fluid w-100" src="{{ asset($image->image) }}" alt="product"></li>
                                            @endforeach
                                            <li><img class="zoom img-fluid w-100" src="{{ asset($product->thumb_image) }}" alt="product"></li>
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
                            <a class="title" href="javascript:;">{{@$product->name}}</a>
                            @if($product->quantity > 0)
                                <p class="wsus__stock_area"><span class="in_stock">Còn hàng</span> ({{$product->quantity}} sản phẩm)</p>
                            @elseif($product->quantity == 0)
                                <p class="wsus__stock_area"><span class="in_stock">Hết hàng</span> ({{$product->quantity}} sản phẩm)</p>
                            @endif
                            @if (checkDiscount($product))
                                <h4><span class="product_price">{{ format($product->offer_price)}}</span>
                                    <del class="old_product_price">{{ format($product->price) }}</del>
                                </h4>
                                <input type="hidden" class="input_price" value="{{$product->offer_price}} {{$product->price}}">
                            @else
                                <h4><span class="product_price">{{ format($product->price) }}</span></h4>
                                <input type="hidden" name="input_price" value="{{$product->price}}">
                            @endif

                            <p class="review">
                                @php
                                    $avgRating = $product->reviews()->avg('rating');
                                    $avgRating = round($avgRating);
                                @endphp

                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $avgRating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor

                                <span>({{$product->reviews->count()}} review)</span>

                            </p>
                            <p class="description">{!! $product->short_description !!}</p>

                            <form class="shopping-cart-form" action="{{route('add-to-cart')}}" method="post">
                                @csrf
                                <div class="wsus__selectbox">
                                    <div class="row">
                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                        @if($product->variants->count() > 0)
                                            @foreach($product->variants as $variant)
                                                @if($variant->status == 1)
                                                    <div class="col-xl-6 col-sm-6">
                                                        <h5 class="mb-2">{{$variant->name}}: </h5>
                                                        <select class="attribute select_2" name="variants_items[]">
                                                            @foreach($variant->variantItems as $variantItem)
                                                                @if($variantItem->status == 1)
                                                                    <option value="{{$variantItem->id}}"
                                                                            title="{{$variantItem->price}}" {{$variantItem->is_default == 1 ? 'selected' : ''}}>{{$variantItem->name}}</option>
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
                                    <h5>Quantity :</h5>
                                    <div class="select_number">
                                        <input class=" quantity number_area" type="text" min="1" max="100" value="1" name="qty"/>
                                    </div>
                                </div>
                                <ul class="wsus__button_area">
                                    <li>
                                        <button type="button" class="add_cart">add to cart</button>
                                    </li>
                                    <li><button style="border: none" type="button" class="buy_now" data-buy-product-route="{{ route('buy-product') }}">buy now</button></li>
                                    <li><a href="#" class="add_to_wishlist" data-route="{{ route('user.wishlist.store', ['productId' => $product->id]) }}"><i
                                                class="fal fa-heart add_to_wishlist"></i></a></li>
                                    {{--                                    <li><a href="#"><i class="far fa-random"></i></a></li>--}}
                                </ul>
                            </form>
                            <p class="brand_model"><span>brand :</span> {{$product->brand->name}}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 mt-md-5 mt-lg-0">
                        <div class="wsus_pro_det_sidebar" id="sticky_sidebar">
                            <ul>
                                <li>
                                    <span><i class="fal fa-truck"></i></span>
                                    <div class="text">
                                        <h4>Return Available</h4>
                                        <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                    </div>
                                </li>
                                <li>
                                    <span><i class="far fa-shield-check"></i></span>
                                    <div class="text">
                                        <h4>Secure Payment</h4>
                                        <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                    </div>
                                </li>
                                <li>
                                    <span><i class="fal fa-envelope-open-dollar"></i></span>
                                    <div class="text">
                                        <h4>Warranty Available</h4>
                                        <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                    </div>
                                </li>
                            </ul>
                            <div class="wsus__det_sidebar_banner">
                                <img src="images/blog_1.jpg" alt="banner" class="img-fluid w-100">
                                <div class="wsus__det_sidebar_banner_text_overlay">
                                    <div class="wsus__det_sidebar_banner_text">
                                        <p>Black Friday Sale</p>
                                        <h4>Up To 70% Off</h4>
                                        <a href="#" class="common_btn">shope now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__pro_det_description">
                        <div class="wsus__details_bg">
                            <ul class="nav nav-pills mb-3" id="pills-tab3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab7" data-bs-toggle="pill"
                                            data-bs-target="#pills-home22" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="true">Description
                                    </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact" type="button" role="tab"
                                            aria-controls="pills-contact" aria-selected="false">Vendor Info
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab2" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact2" type="button" role="tab"
                                            aria-controls="pills-contact2" aria-selected="false">Reviews
                                    </button>
                                </li>

                            </ul>
                            <div class="tab-content" id="pills-tabContent4">
                                <div class="tab-pane fade  show active " id="pills-home22" role="tabpanel"
                                     aria-labelledby="pills-home-tab7">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="wsus__description_area">
                                                {!!$product->full_description!!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-md-4">
                                                <div class="description_single">
                                                    <h6><span>1</span> Free Shipping & Return</h6>
                                                    <p>We offer free shipping for products on orders above 50$ and
                                                        offer
                                                        free delivery for all orders in US.</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4">
                                                <div class="description_single">
                                                    <h6><span>2</span> Free and Easy Returns</h6>
                                                    <p>We guarantee our products and you could get back all of your
                                                        money anytime you want in 30 days.</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4">
                                                <div class="description_single">
                                                    <h6><span>3</span> Special Financing </h6>
                                                    <p>Get 20%-50% off items over 50$ for a month or over 250$ for a
                                                        year with our special credit card.</p>
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
                                                    <img src="{{asset($product->vendor->banner)}}" alt="vensor" class="img-fluid w-100">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-xxl-7 col-md-6 mt-4 mt-md-0">
                                                <div class="wsus__pro_det_vendor_text">
                                                    <h4>{{$product->vendor->shop_name}}</h4>
                                                    <p class="rating">
                                                        @php
                                                            $avgRating = $product->reviews()->avg('rating');
                                                            $avgRating = round($avgRating);
                                                        @endphp

                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $avgRating)
                                                                <i class="fas fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor

                                                        <span>({{$product->reviews->count()}} review)</span>

                                                    </p>
                                                    <p><span>Store Name:</span> {{$product->vendor->shop_name}}</p>
                                                    <p><span>Address:</span> {{$product->vendor->address}}</p>
                                                    <p><span>Phone:</span> {{$product->vendor->phone}}</p>
                                                    <p><span>mail:</span> {{$product->vendor->email}}</p>
                                                    <a href="{{route('vendor.products',$product->vendor)}}" class="see_btn">visit store</a>
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
                                                        <h4>Reviews <span>{{count($reviews)}}</span></h4>
                                                        @foreach($reviews as $review)
                                                            <div class="wsus__main_comment">
                                                                <div class="wsus__comment_img">
                                                                    <img src="{{$review->user->image}}" alt="user"
                                                                         class="img-fluid w-100">
                                                                </div>
                                                                <div class="wsus__comment_text reply">
                                                                    <h6>{{$review->user->name}} <span>{{$review->rating}}<i
                                                                                class="fas fa-star"></i></span></h6>
                                                                    <span>{{ Carbon\Carbon::parse($review->created_at)->format('d-m-Y') }}</span>
                                                                    <p>{{$review->review}}</p>

                                                                    <ul class="">
                                                                        @if(count($review->reviewGalleries)>0)
                                                                            @foreach($review->reviewGalleries as $gallery)
                                                                                <li><img src="{{asset($gallery->image)}}" alt="product"
                                                                                         class="img-fluid w-100"></li>
                                                                            @endforeach
                                                                        @endif
                                                                    </ul>
                                                                    <a href="#" data-bs-toggle="collapse"
                                                                       data-bs-target="#flush-collapsetwo">reply</a>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                        <div class="text-center">
                                                            <div class="mt-3 d-inline-block">
                                                                @if($reviews->hasPages())
                                                                    {{$reviews->links()}}
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div id="pagination">
{{--                                                            <nav aria-label="Page navigation example">--}}
{{--                                                                <ul class="pagination">--}}
{{--                                                                    <li class="page-item">--}}
{{--                                                                        <a class="page-link" href="#"--}}
{{--                                                                           aria-label="Previous">--}}
{{--                                                                            <i class="fas fa-chevron-left"></i>--}}
{{--                                                                        </a>--}}
{{--                                                                    </li>--}}
{{--                                                                    <li class="page-item"><a--}}
{{--                                                                            class="page-link page_active" href="#">1</a>--}}
{{--                                                                    </li>--}}

{{--                                                                </ul>--}}
{{--                                                            </nav>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-5 mt-4 mt-lg-0">

                                                    @php
                                                    	$existItem = false;
                                                        $checkOrders = Order::where(['user_id' => Auth::user()?->id, 'order_status' => 'delivered'])->get();
                                                        foreach ($checkOrders as $order){
                                                               $existItem = $order->orderProducts()->where('product_id', $product->id)->exists(); // true or false
                                                        }
                                                    @endphp

                                                    @if($existItem === true)
                                                        <div class="wsus__post_comment rev_mar" id="sticky_sidebar3">
                                                            <h4>write a Review</h4>
                                                            <form action="{{route('user.review.create')}}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <p class="rating">
                                                                    <span>select your rating : </span>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-xl-12">
                                                                        <div class="wsus__single_com">
                                                                            <select name="rating" class="form-control mb-4" id="">
                                                                                <option value="">Select</option>
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
                                                                            <textarea cols="3" rows="3" name="review"
                                                                                      placeholder="Write your review"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="img_upload">
                                                                    <div class="gallery">
                                                                        <input type="file" name="images[]" multiple>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                                <input type="hidden" name="vendor_id" value="{{$product->vendor_id}}">
                                                                <button class="common_btn" type="submit">submit
                                                                    review
                                                                </button>
                                                            </form>
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
                    <div class="wsus__section_header">
                        <h3>Related Products</h3>
                        <a class="see_btn" href="{{route('products.index',['category'=> $product->category->slug])}}">see more <i class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row flash_sell_slider">
                @foreach($relatedProducts as $product)
                    <div class="col-xl-3 col-sm-6 col-lg-4">
                        <div class="wsus__product_item">
                            <span class="wsus__new">{{productType($product->product_type)}}</span>
                            @if(checkDiscount($product))
                                <span class="wsus__minus">-{{discountPercent($product->price, $product->offer_price)}}%</span>
                            @endif
                            <a class="wsus__pro_link" href="{{route('product-detail',$product->slug)}}">
                                <img src="{{asset($product->thumb_image)}}" alt="product" class="img-fluid w-100 img_1" />
                                <img src="{{asset(isset($product->productImageGalleries[0]->image) ? $product->productImageGalleries[0]->image : $product->thumb_imag) }}" alt="product" class="img-fluid w-100 img_2" />
                            </a>
                            <ul class="wsus__single_pro_icon">
                                <li><a href="#" data-bs-toggle="modal" data-bs-target="#product-type-{{$product->id}}"><i
                                            class="far fa-eye"></i></a></li>
                                <li><a href="#" class="add_to_wishlist" data-route="{{ route('user.wishlist.store', ['productId' => $product->id]) }}"><i class="fal fa-heart add_to_wishlist"></i></a></li>
                                {{--                                <li><a href="#"><i class="far fa-random"></i></a>--}}
                            </ul>
                            <div class="wsus__product_details">
                                <a class="wsus__category" href="#">{{$product->category->name}} </a>
                                <p class="wsus__pro_rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span>(133 review)</span>
                                </p>
                                <a class="wsus__pro_name" href="{{route('product-detail',$product->slug)}}">{{$product->name}}</a>
                                @if (checkDiscount($product))
                                    <p class="wsus__price">{{ format($product->offer_price) }} <del>{{ format($product->price) }}</del></p>
                                @else
                                    <p class="wsus__price">{{ format($product->price) }} </p>
                                @endif

                                <form class="shopping-cart-form" action="{{route('add-to-cart')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    @foreach($product->variants as $variant)
                                        <select class="attribute d-none" name="variants_items[]">
                                            @foreach($variant->variantItems as $variantItem)
                                                <option value="{{$variantItem->id}}"  title="{{$variantItem->price}}"  {{$variantItem->is_default == 1 ? 'selected' : ''}}>{{$variantItem->name}}</option>
                                            @endforeach
                                        </select>
                                    @endforeach
                                    <input class=" quantity" type="hidden" min="1" max="100" value="1" name="qty" />
                                    <button style="border: none" type="button" class="add_cart" >add to cart</button>
                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach



            </div>
        </div>
    </section>
    <!--============================
        RELATED PRODUCT END
    ==============================-->

@endsection

