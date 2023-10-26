<div class="dashboard_sidebar">
        <span class="close_icon">
          <i class="far fa-bars dash_bar"></i>
          <i class="far fa-times dash_close"></i>
        </span>
    <a href="{{route('home')}}" class="dash_logo"><img src="{{asset('frontend/images/logo.png')}}" alt="logo" class="img-fluid"></a>
    <ul class="dashboard_link">
        <li><a class="{{setActive(['home'])}}" href="{{route('home')}}"><i class="fas fa-home"></i>Mua hàng</a></li>
        <li><a class="{{setActive(['user.dashboard'])}}" href="{{route('user.dashboard')}}"><i class="fas fa-tachometer"></i>Thống kê</a></li>

        @if(auth()->user()->role == 'vendor')
            <li><a href="{{route('vendor.dashboard')}}" class="{{setActive(['vendor.dashboard'])}}"><i class="fas fa-tachometer"></i>QUản lý shop</a></li>
        @endif

        <li><a href="{{route('user.orders.index')}}" class="{{setActive(['user.orders.*'])}}"><i class="fas fa-list-ul"></i> Các đơn hàng</a></li>
        <li><a href="{{route('user.review.index')}}" class="{{setActive(['user.review.*'])}}"><i class="far fa-star"></i> Đánh giá</a></li>
        <li><a href="{{route('user.profile')}}" class="{{setActive(['user.profile.*'])}}"><i class="far fa-user"></i> Cá nhân</a></li>
        <li><a href="{{route('user.address.index')}}" class="{{setActive(['user.address.*'])}}"><i class="fal fa-map-marker-alt"></i> Địa chỉ</a></li>

        @if(auth()->user()->role !== 'vendor')
            <li><a href="{{route('user.become-vendor.index')}}" class="{{setActive(['user.become-vendor.*'])}}"><i class="fal fa-gift-card"></i>Trở thành shop</a></li>
        @endif

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
