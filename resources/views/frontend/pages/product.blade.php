@php
    $priceRange = request()->price_range;
    $brand = request()->brand;
    $from = 0;
    $to = 100000000;

    if ($priceRange ) {
        $price = explode(';', $priceRange);
        $from = isset($price[0]) && $price[0] ? $price[0] : $from;
        $to = isset($price[1]) && $price[1] ? $price[1] : $to;
    };

    $productPageBanner = json_decode($productPageBanner?->value)?->banner_1;

@endphp

@extends('frontend.layouts.master')
@section('title')
    Shop Now | Sản phẩm
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
                        <h4>Sản phẩm</h4>
                        <ul>
                            <li><a href="{{route('home')}}">Trang chủ</a></li>
                            <li><a href="javascript:">Sản phẩm</a></li>
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
        PRODUCT PAGE START
    ==============================-->
    <section id="wsus__product_page">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
{{--                    @if($productPageBanner->status == 1)--}}
{{--                        <div class="wsus__pro_page_bammer">--}}
{{--                            <img src="{{asset($productPageBanner->banner_image)}}" alt="banner" class="img-fluid w-100">--}}
{{--                            <div class="wsus__pro_page_bammer_text">--}}
{{--                                <div class="wsus__pro_page_bammer_text_center">--}}
{{--                                    <p>up to <span>70% off</span></p>--}}
{{--                                    <h5>wemen's jeans Collection</h5>--}}
{{--                                    <h3>fashion for wemen's</h3>--}}
{{--                                    <a href="{{$productPageBanner->banner_url}}" class="add_cart">Khám phá ngay</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="wsus__sidebar_filter ">
                        <p>filter</p>
                        <span class="wsus__filter_icon">
                            <i class="far fa-minus" id="minus"></i>
                            <i class="far fa-plus" id="plus"></i>
                        </span>
                    </div>
                    <div class="wsus__product_sidebar" id="sticky_sidebar">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Danh mục
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                     aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul>
                                            @foreach($categories as $category)
                                                <li><a href="{{route('products.index')}}?category={{$category->slug}}.html">{{$category->name}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Giá
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse show"
                                     aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="price_ranger">
                                            <form action="{{url()->current()}}">
                                                @foreach(request()->query() as $key => $value)
                                                    @if($key !== 'price_range')
                                                        <input type="hidden"  name="{{$key}}" value="{{$value}}"  />
                                                    @endif
                                                @endforeach
                                                <input type="hidden" id="slider_range" name="price_range" value="{{$from}};{{$to}}" class="flat-slider" />
                                                <button type="submit" class="common_btn">Lọc</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree3">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree3" aria-expanded="false"
                                            aria-controls="collapseThree">
                                        Thương hiệu
                                    </button>
                                </h2>
                                <div id="collapseThree3" class="accordion-collapse collapse show"
                                     aria-labelledby="headingThree3" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul>
                                            @foreach($brands as $brand)
                                                <li><a href="{{route('products.index')}}?brand={{$brand->slug}}">{{$brand->name}}</a></li>
                                            @endforeach
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="row">
                        <div class="col-xl-12 d-none d-md-block mt-md-4 mt-lg-0">
                            <div class="wsus__product_topbar">
                                <div class="wsus__product_topbar_left">
                                    <div class="nav nav-pills" id="v-pills-tab" role="tablist"
                                         aria-orientation="vertical">
                                        <button class="nav-link active list-view" data-id="grid" id="v-pills-home-tab" data-bs-toggle="pill"
                                                data-bs-target="#v-pills-home" type="button" role="tab"
                                                aria-controls="v-pills-home" aria-selected="true">
                                            <i class="fas fa-th"></i>
                                        </button>
                                        <button class="nav-link list-view" data-id="list" id="v-pills-profile-tab" data-bs-toggle="pill"
                                                data-bs-target="#v-pills-profile" type="button" role="tab"
                                                aria-controls="v-pills-profile" aria-selected="false">
                                            <i class="fas fa-list-ul"></i>
                                        </button>
                                    </div>
                                    <div class="wsus__topbar_select">
                                        <select class="select_2 type" name="type">
                                            <option value="default" @if (@$params['type'] == '' || @$params['sortBy'] == '') selected @endif>Sắp xếp</option>
                                            <option value="rating" @if (@$params['type'] == 'rating') selected @endif>Đánh giá nhiều</option>
                                            <option value="new_product" @if (@$params['type'] == 'new_product') selected @endif>Sản phẩm mới</option>
                                            <option value="ASC" @if (@$params['sortBy'] == 'ASC') selected @endif>Giá thấp đến cao</option>
                                            <option value="DESC" @if (@$params['sortBy'] == 'DESC') selected @endif>Giá cao đến thấp</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                 aria-labelledby="v-pills-home-tab">
                                <div class="row">

                                    @foreach($products as $product)
                                        <div class="col-xl-4  col-sm-6">
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
                                                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#product-{{$product->id}}"><i
                                                                class="far fa-eye"></i></a></li>
                                                    <li><a href="#" class="add_to_wishlist" data-route="{{ route('user.wishlist.store', ['productId' => $product->id]) }}"><i class="fal fa-heart add_to_wishlist"></i></a></li>
{{--                                                    <li><a href="#"><i class="far fa-random"></i></a>--}}
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

                                                        <span>({{$product->reviews->count()}} review)</span>
                                                    </p>
                                                    <a class="wsus__pro_name" href="{{route('product-detail',$product->slug)}}">{{limitText($product->name,50)}}</a>
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
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                 aria-labelledby="v-pills-profile-tab">
                                <div class="row">
                                    @foreach($products as $product)
                                    <div class="col-xl-12">
                                        <div class="wsus__product_item wsus__list_view">
                                            <span class="wsus__new">{{productType($product->product_type)}}</span>
                                            @if(checkDiscount($product))
                                            <span class="wsus__minus">-{{discountPercent($product->price, $product->offer_price)}}%</span>
                                            @endif
                                            <a class="wsus__pro_link" href="{{route('product-detail',$product->slug)}}">
                                                <img src="{{asset($product->thumb_image)}}" alt="product" class="img-fluid w-100 img_1" />
                                                <img src="{{asset(isset($product->productImageGalleries[0]->image) ? $product->productImageGalleries[0]->image : $product->thumb_imag) }}" alt="product" class="img-fluid w-100 img_2" />
                                            </a>
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
                                                <p class="list_description">{{$product->short_description}}</p>
                                                <ul class="wsus__single_pro_icon">
                                                    <li style="margin-right: 10px !important">
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
                                                            <button style="border: 1px solid #03a676; border-radius: 3px; background: #fff; color: #03a676" type="button" class="add_cart" >Thêm vào giỏ</button>
                                                        </form>
                                                    </li>

                                                    <li><a href="#" class="add_to_wishlist" data-route="{{ route('user.wishlist.store', ['productId' => $product->id]) }}"><i class="fal fa-heart add_to_wishlist"></i></a></li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <div class="mt-3 d-inline-block">
                        @if($products->hasPages())
                            {{$products->withQueryString()->links()}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        PRODUCT PAGE END
    ==============================-->

    <!--============================
    MODAL POPUP START
    ==============================-->

    @foreach($products as $product)
        <section class="product_popup_modal">
            <div class="modal fade" id="product-{{$product->id}}" tabindex="-1" aria-hidden="true">
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
@endsection

@push('scripts')
    <script>
       window.addEventListener('DOMContentLoaded',(e)=>{

          const orderByProduct = document.querySelector('.type');

           if (orderByProduct) {
               $(orderByProduct).on('select2:select', async (e) => {
                   const type = e.target.value;
                   const baseUrl = new URL(window.location.href);

                   if (type === 'ASC' || type === 'DESC' || type === 'rating' || type === 'new_product') {
                       baseUrl.searchParams.delete('sortBy');
                       baseUrl.searchParams.delete('type');

                       if (type === 'ASC' || type === 'DESC') {
                           baseUrl.searchParams.set('sortBy', type);
                       } else {
                           baseUrl.searchParams.set('type', type);
                       }

                       const res = await fetch(baseUrl.toString());

                       if (res.ok) {
                           window.location.href = res.url;
                       }
                   } else {
                       // Handle the case where no valid type is selected
                       baseUrl.searchParams.delete('sortBy');
                       baseUrl.searchParams.delete('type');
                       window.location.href = baseUrl.toString();
                   }

                   if (res.ok) {
                       window.location.href = res.url;
                   }
               });
           }

           //*==========PRICE SLIDER=========

           jQuery(function () {
               jQuery(".flat-slider").flatslider({
                   min: 0,
                   max: 200000000,
                   step: 10000000,
                   values: [{{reverseFormatNumber($from)}}, {{reverseFormatNumber($to)}}],
                   range: true,
                   einheit: '₫',
               });
           });

       })
    </script>
@endpush


