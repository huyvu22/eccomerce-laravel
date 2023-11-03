<div class="dashboard_sidebar">
        <span class="close_icon">
          <i class="far fa-bars dash_bar"></i>
          <i class="far fa-times dash_close"></i>
        </span>
    <a href="{{route('home')}}" class="dash_logo"><img src="{{asset('frontend/images/logo.png')}}" alt="logo" class="img-fluid"></a>
    <ul class="dashboard_link">
        <li><a class="{{setActive(['vendor.dashboard'])}}" href="{{route('vendor.dashboard')}}"><i class="fas fa-tachometer"></i>Dashboard</a></li>
        <li><a class="{{setActive(['vendor.products.*','vendor.products-image-gallery.*','vendor.products-variant.*','vendor.products-variant-item.*'])}}"
               href="{{route('vendor.products.index')}}"><i class="fal fa-gift-card"></i> Sản phẩm</a></li>
        <li><a class="{{setActive(['vendor.review.*'])}}" href="{{route('vendor.review.index')}}"><i class="fas fa-star"></i> Đánh giá</a></li>
        <li><a class="{{setActive(['vendor.orders.*'])}}" href="{{route('vendor.orders.index')}}"><i class="far fa-cart-plus"></i> Đơn hàng</a></li>
        <li><a class="{{setActive(['vendor.shop-profile.*'])}}" href="{{route('vendor.shop-profile.index')}}"><i class="far fa-user"></i> Thông tin Shop</a></li>
        <li><a class="{{setActive(['vendor.profile',])}}" href="{{route('vendor.profile')}}"><i class="fas fa-user-shield"></i> cá nhân</a></li>
        <li><a class="{{setActive(['vendor.withdraw.*', 'vendor.withdraw-request.*'])}}" href="{{route('vendor.withdraw.index')}}"><i class="fa fa-money-bill"></i> Rút tiền</a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{route('logout')}}" onclick="event.preventDefault();
                                            this.closest('form').submit();">
                    <i class="far fa-sign-out-alt"></i>Đăng xuất</a>
            </form>

        </li>
    </ul>
</div>
