<!--============================
    HEADER START
==============================-->
<header>
    <div class="container">
        <div class="row">
            <div class="col-2 col-md-1 d-lg-none">
                <div class="wsus__mobile_menu_area">
                    <span class="wsus__mobile_menu_icon"><i class="fal fa-bars"></i></span>
                </div>
            </div>
            <div class="col-xl-2 col-7 col-md-8 col-lg-2">
                <div class="wsus_logo_area">
                    <a class="wsus__header_logo" href="{{ url('/') }}">
                        <img src="{{ asset('frontend/images/logo.png') }}" alt="logo" class="img-fluid w-100">
                    </a>
                </div>
            </div>
            <div class="col-xl-5 col-md-6 col-lg-4 d-none d-lg-block">
                <div class="wsus__search">
                    <form action="{{ route('products.index') }}" method="get">
                        <input type="text" placeholder="Search..." class="search_keyword" name="search"
                               value="{{ isset(request()->search) ? request()->search : '' }}">
                        <button type="submit"><i class="far fa-search"></i></button>
                    </form>
                    <div class="autocomplete-suggestions">
                        <div class="autocomplete-suggestions">
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-5 col-3 col-md-3 col-lg-6">
                <div class="wsus__call_icon_area">
                    <div class="wsus__call_area">
                        <div class="wsus__call">
                            <i class="fas fa-user-headset"></i>
                        </div>
                        <div class="wsus__call_text">
                            <p>eshopvn@gmail.com</p>
                            <p>+94 943603845</p>
                        </div>
                    </div>
                    <ul class="wsus__icon_area">
                        <li>
                            <a href="{{ route('user.wishlist.index') }}" class="wsus__heart_icon">
                                <i class="fal fa-heart"></i>
                                <span class="count_wishlist_item">
                                    {{ auth()->check() ? \App\Models\Wishlist::where('user_id', auth()->user()->id)->count() : 0 }}
                                </span>
                            </a>
                        </li>
                        <li><a class="wsus__cart_icon" href="#"><i class="fal fa-shopping-bag"></i><span
                                    class="cart-count">{{ Cart::content()->count() }}</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="wsus__mini_cart">
        <h4>Giỏ hàng <span class="wsus_close_mini_cart"><i class="far fa-times"></i></span></h4>
        <ul class="mini-cart-wrapper">
            @foreach (Cart::content() as $item)
                <li class="mini_cart_{{ $item->rowId }}">
                    <div class="wsus__cart_img">
                        <a href="{{ route('product-detail', $item->options->slug) }}"><img
                                src="{{ asset($item->options->image) }}" alt="product" class="img-fluid w-100"></a>
                        <form class="form-delete-item" action="{{ route('cart.remove-sidebar-product') }}"
                              method="post">
                            @csrf
                            <button class="remove-item wsis__del_icon" data-rowid="{{ $item->rowId }}" type="button">
                                &times;
                            </button>
                        </form>

                    </div>
                    <div class="wsus__cart_text">
                        <a class="wsus__cart_title"
                           href="{{ route('product-detail', $item->options->slug) }}">{{ $item->name }}</a>
                        <p>{{ format($item->price) }} </p>
                        <small>Qty: {{ $item->qty }}</small>
                    </div>
                </li>
            @endforeach
            @if (Cart::content()->count() === 0)
                <li class="alert alert-danger text-center">Giỏ hàng trống!</li>
            @endif
        </ul>
        <div class="mini_cart_actions {{ Cart::content()->count() > 0 ? '' : 'd-none' }}">
            <h5>Tạm tính <span class="mini_cart_subtotal">{{ getCartTotal() }}</span></h5>
            <div class="wsus__minicart_btn_area">
                <a class="common_btn" href="{{ route('cart-detail') }}">Giỏ hàng</a>
                <a class="common_btn" href="{{ route('user.checkout') }}">Thanh toán</a>
            </div>
        </div>
    </div>

</header>
<!--============================
HEADER END
==============================-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const formatPrice = (price) => {
            return parseInt(price).toLocaleString('en').replace(/,/g, '.') + '₫';
        }

        const searchKeyword = document.querySelector('.search_keyword')
        const tableSuggestion = document.querySelector('.autocomplete-suggestions');

        const debounceSearch = debounce(async (searchKeywordValue) => {
            if (searchKeywordValue !== '') {
                const res = await fetch(
                    `{{ env('APP_URL') }}/products?suggest_keywords=${searchKeywordValue}`);
                const data = await res.json();
                let productArr = data.products;
                tableSuggestion.innerHTML = '';
                tableSuggestion.style.display = 'block';
                if (productArr.length) {

                    let html = '';
                    productArr.forEach((product) => {
                        html +=
                            `<div class="autocomplete-suggestion">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td><a href="{{ env('APP_URL') }}/${product.slug}.html"><img src="{{ env('APP_URL') }}/${product.thumb_image}" alt="img" width="100"></a></td>
                                                <td><a href="{{ env('APP_URL') }}/product-detail/${product.slug}.html" class="product-name">${product.name}</a><br>
                                                    <span class="product-price" style="color: orangered"><b>Giá: ${formatPrice(product.offer_price)}</b> ${formatPrice(product.price)}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>`;
                    });

                    tableSuggestion.innerHTML = html;
                    tableSuggestion.style.display = 'block';
                } else {
                    tableSuggestion.innerHTML =
                        `<div class="autocomplete-suggestion">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <b>Không tìm thấy kết quả</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>`;
                }
            } else {
                tableSuggestion.style.display = 'none';
            }
        }, 500);

        searchKeyword.addEventListener('input', (e) => {
            const searchKeywordValue = e.target.value;
            if (searchKeywordValue !== '') {
                debounceSearch(searchKeywordValue);
            }
        });
    });
</script>
