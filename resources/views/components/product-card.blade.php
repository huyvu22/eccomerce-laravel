<div class="col-xl-3 col-sm-6 col-lg-4 {{@$key}}">
    <div class="wsus__product_item">
        <span class="wsus__new">{{productType($product->product_type)}}</span>
        @if(checkDiscount($product))
            <span class="wsus__minus">-{{discountPercent($product->price, $product->offer_price)}}%</span>
        @endif
        <a class="wsus__pro_link" href="{{route('product-detail',$product->slug)}}">
            <img loading="lazy" src="{{asset($product->thumb_image)}}" alt="product" class="img-fluid w-100 img_1"/>
            <img loading="lazy"
                 src="{{asset(isset($product->productImageGalleries[0]->image) ? $product->productImageGalleries[0]->image : $product->thumb_imag) }}"
                 alt="product" class="img-fluid w-100 img_2"/>
        </a>
        <ul class="wsus__single_pro_icon">
            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" class="show_product_modal" data-id="{{$product->id}}"><i
                        class="far fa-eye"></i></a></li>
            <li><a href="javascript:void(0);" class="add_to_wishlist"
                   data-id="{{$product->id}}" data-route="{{ route('user.wishlist.store', ['productId' => $product->id])}}"><i
                        class="far fa-heart"></i></a></li>
        </ul>
        <div class="wsus__product_details">
            <a class="wsus__category" href="#">{{$product->category->name}} </a>
            <p class="wsus__pro_rating">

                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $product->reviews_avg_rating)
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor

                <span>({{$product->reviews_count}} đánh giá)</span>
            </p>
            <a class="wsus__pro_name" href="{{route('product-detail',$product->slug)}}">{{$product->name}}</a>
            @if (checkDiscount($product))
                <p class="wsus__price">{{ format($product->offer_price) }}
                    <del>{{ format($product->price) }}</del>
                </p>
            @else
                <p class="wsus__price">{{ format($product->price) }} </p>
            @endif

            <form class="shopping-cart-form" action="{{route('add-to-cart')}}" method="post">
                @csrf
                <input type="hidden" name="product_id" value="{{$product->id}}">
                @foreach($product->variants as $variant)
                    <select class="attribute d-none" name="variants_items[]">
                        @foreach($variant->variantItems as $variantItem)
                            <option value="{{$variantItem->id}}"
                                    title="{{$variantItem->price}}" {{$variantItem->is_default == 1 ? 'selected' : ''}}>{{$variantItem->name}}</option>
                        @endforeach
                    </select>
                @endforeach
                <input class=" quantity" type="hidden" min="1" max="100" value="1" name="qty"/>
                <button style="border: none" type="button" class="add_cart">Thêm vào giỏ</button>
            </form>

        </div>
    </div>
</div>
