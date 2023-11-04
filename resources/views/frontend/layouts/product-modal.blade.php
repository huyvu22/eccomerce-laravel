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
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12 col-sm-12 col-md-12 col-lg-6">
            <div class="wsus__pro_details_text">
                <a class="title" href="{{route('product-detail',$product->slug)}}">{{$product->name}}</a>
                @if (checkDiscount($product))
                    <h4><span class="product_price">{{format($product->offer_price)}}</span>
                        <del class="old_product_price">{{ format($product->price) }}</del>
                    </h4>
                    <input type="hidden" class="input_price" value="{{$product->offer_price}} {{$product->price}}">
                @else
                    <h4><span class="product_price">{{format($product->price) }}</span></h4>
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
                        <h5>Số lượng :</h5>
                        <div class="select_number">
                            <input class=" quantity number_area" type="text" min="1" max="100" value="1" name="qty"/>
                        </div>
                    </div>
                    <ul class="wsus__button_area">
                        <li>
                            <button type="button" class="add_cart">Thêm vào giỏ</button>
                        </li>
                        <li>
                            <button style="border: none" type="button" class="buy_now" data-buy-product-route="{{route('buy-product')}}">Mua ngay</button>
                        </li>
                        <li><a href="#" class="add_to_wishlist" data-route="{{ route('user.wishlist.store', ['productId' => $product->id]) }}"><i
                                    class="fal fa-heart add_to_wishlist"></i></a></li>
                    </ul>
                </form>
                <p class="brand_model"><span>Thương hiệu :</span> {{$product->brand->name}}</p>
            </div>
        </div>
    </div>
</div>



