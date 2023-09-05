<div class="dashboard_sidebar">
        <span class="close_icon">
          <i class="far fa-bars dash_bar"></i>
          <i class="far fa-times dash_close"></i>
        </span>
    <a href="{{route('home')}}" class="dash_logo"><img src="{{asset('frontend/images/logo.png')}}" alt="logo" class="img-fluid"></a>
    <ul class="dashboard_link">
        <li><a class="{{setActive(['vendor.dashboard'])}}" href="{{route('vendor.dashboard')}}"><i class="fas fa-tachometer"></i>Dashboard</a></li>
{{--        @if(auth()->user()->role == 'vendor')--}}
{{--            <li><a class="" href="{{route('user.dashboard')}}"><i class="fas fa-tachometer"></i>User Dashboard</a></li>--}}
{{--        @endif--}}
        <li><a class="{{setActive(['vendor.products.*','vendor.products-image-gallery.*','vendor.products-variant.*','vendor.products-variant-item.*'])}}" href="{{route('vendor.products.index')}}"><i class="fal fa-gift-card"></i> Products</a></li>
        <li><a class="{{setActive(['vendor.review.*'])}}" href="{{route('vendor.review.index')}}"><i class="fas fa-star"></i> Review</a></li>
        <li><a class="{{setActive(['vendor.orders.*'])}}" href="{{route('vendor.orders.index')}}"><i class="far fa-cart-plus"></i> Orders</a></li>
        <li><a class="{{setActive(['vendor.shop-profile.*'])}}" href="{{route('vendor.shop-profile.index')}}"><i class="far fa-user"></i> Seller Profile</a></li>
        <li><a class="{{setActive(['vendor.profile',])}}" href="{{route('vendor.profile')}}"><i class="fas fa-user-shield"></i> My Profile</a></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{route('logout')}}" onclick="event.preventDefault();
                                            this.closest('form').submit();">
                    <i class="far fa-sign-out-alt"></i>Log out</a>
            </form>

        </li>
    </ul>
</div>