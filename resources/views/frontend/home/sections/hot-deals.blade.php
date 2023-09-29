@php
    $homepageBannerSection3 = json_decode($homepageBannerSection3?->value)
@endphp
<section id="wsus__hot_deals" class="wsus__hot_deals_2">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__section_header">
                    <h3>Sản phẩm hot trong ngày</h3>
                </div>
            </div>
        </div>

        <div class="wsus__hot_large_item">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__section_header justify-content-start">
                        <div class="monthly_top_filter2 mb-1">

                            <button data-filter=".new_arrival" class="new-arrival-active active">new arrival</button>
                            <button data-filter=".featured">featured</button>
                            <button data-filter=".top_product">top product</button>
                            <button data-filter=".best_product">best product</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row grid2">
                @foreach($typeProducts as $key => $products)
                    @foreach($products as $product)
                    <div class="col-xl-3 col-sm-6 col-lg-4 {{$key}}">
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
                            </ul>
                            <div class="wsus__product_details">
                                <a class="wsus__category" href="#">{{$product->category->name}} </a>
                                <p class="wsus__pro_rating">
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

                                    <span>({{$product->reviews->count()}} đánh giá)</span>
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
                                    <button style="border: none" type="button" class="add_cart" >Thêm vào giỏ</button>
                                </form>

                            </div>
                        </div>
                    </div>
                    @endforeach
                @endforeach

            </div>
        </div>

        <section id="wsus__single_banner" class="home_2_single_banner">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        @if($homepageBannerSection3->banner_1->banner_status)
                            <div class="wsus__single_banner_content banner_1">
                                <div class="wsus__single_banner_img">
                                    <img src="{{asset($homepageBannerSection3->banner_1->banner_image)}}" alt="banner" class="img-fluid w-100">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="row">
                            <div class="col-12">
                                @if($homepageBannerSection3->banner_1->banner_status)
                                    <div class="wsus__single_banner_content single_banner_2">
                                        <div class="wsus__single_banner_img">
                                            <img src="{{asset($homepageBannerSection3->banner_2->banner_image)}}" alt="banner" class="img-fluid w-100">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 mt-lg-4">
                                @if($homepageBannerSection3->banner_1->banner_status)
                                    <div class="wsus__single_banner_content">
                                        <div class="wsus__single_banner_img">
                                            <img src="{{asset($homepageBannerSection3->banner_3->banner_image)}}" alt="banner" class="img-fluid w-100">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</section>

{{--popup_modal--}}
@foreach($typeProducts as $key => $products)
    @foreach($products as $product)
        <section class="product_popup_modal">
            <div class="modal fade" id="product-type-{{$product->id}}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                    class="far fa-times"></i></button>
                            <div class="row">
                                <div class="col-xl-6 col-12 col-sm-10 col-md-8 col-lg-6 m-auto display">
                                    <div class="wsus__quick_view_img">
                                        @if($product->video_link)
                                            <a class="venobox wsus__pro_det_video" data-autoplay="true" data-vbtype="video"
                                               href="{{$product->video_link}}">
                                                <i class="fas fa-play"></i>
                                            </a>
                                        @endif

                                        <div class="row modal_slider">
                                            <div class="col-xl-12">
                                                <div class="modal_slider_img">
                                                    <img src="{{asset($product->thumb_image)}}" alt="product" class="img-fluid w-100">
                                                </div>
                                            </div>
                                            @foreach($product->productImageGalleries as $image)
                                                <div class="col-xl-12">
                                                    <div class="modal_slider_img">
                                                        <img src="{{asset($image->image)}}" alt="product" class="img-fluid w-100">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-12 col-sm-12 col-md-12 col-lg-6">
                                    <div class="wsus__pro_details_text">
                                        <a class="title" href="{{route('product-detail',$product->slug)}}">{{$product->name}}</a>
                                        @if (checkDiscount($product))
                                            <h4><span class="product_price">{{format($product->offer_price)}}</span> <del class="old_product_price">{{ format($product->price) }}</del></h4>
                                            <input type="hidden" class="input_price" value="{{$product->offer_price}} {{$product->price}}">
                                        @else
                                            <h4><span class="product_price">{{format($product->price) }}</span> </h4>
                                            <input type="hidden" class="input_price" value="{{$product->price}}">
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

                                            <span>({{$product->reviews->count()}} đánh giá)</span>
                                        </p>
                                        <p class="description">{!! $product->short_description !!}</p>

                                        <form class="shopping-cart-form" action="{{route('add-to-cart')}}" method="post">
                                            @csrf
                                            <div class="wsus_pro_hot_deals">
                                                <h5>Thời gian khuyến mại : </h5>
                                                <div class="simply-countdown simply-countdown-one"></div>
                                            </div>
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
                                                                                <option value="{{$variantItem->id}}"  title="{{$variantItem->price}}"  {{$variantItem->is_default == 1 ? 'selected' : ''}}>{{$variantItem->name}}</option>
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
                                                    <input class=" quantity number_area" type="text" min="1" max="100" value="1" name="qty" />
                                                </div>
                                            </div>
                                            <ul class="wsus__button_area">
                                                <li><button type="button" class="add_cart" >Thêm vào giỏ</button></li>
                                                <li><button style="border: none" type="button" class="buy_now" data-buy-product-route="{{route('buy-product')}}">Mua ngay</button></li>
                                                <li><a href="#" class="add_to_wishlist" data-route="{{ route('user.wishlist.store', ['productId' => $product->id]) }}"><i class="fal fa-heart add_to_wishlist"></i></a></li>
                                            </ul>
                                        </form>
                                        <p class="brand_model"><span>Thương hiệu :</span> {{$product->brand->name}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endforeach

