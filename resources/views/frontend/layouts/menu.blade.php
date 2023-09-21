@php use App\Models\Category;use App\Models\SubCategory; @endphp
@php
    $categories = Category::where('status',1)
    ->with(['subCategories'=>function($query){
        $query->where('status',1);
        $query->with(['childCategories'=>function($query){
                $query->where('status',1);
        }
        ]);
    }])
    ->get();
@endphp
<nav class="wsus__main_menu d-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="relative_contect d-flex">
                    <div class="wsus_menu_category_bar">
                        <i class="far fa-bars"></i>
                    </div>
                    <ul class="wsus_menu_cat_item show_home toggle_menu">
                        {{--                        <li><a href="#"><i class="fas fa-star"></i> hot promotions</a></li>--}}

                        @foreach($categories as $category)
                            <li><a class="{{$category->subCategories->count() > 0 ? 'wsus__droap_arrow' : ''}}" href="{{route('products.index')}}?category={{$category->slug}}.html"><i class="{{$category->icon}}"></i>{{ $category->name}}</a>
                                @if($category->subCategories->count()>0)
                                    <ul class="wsus_menu_cat_droapdown">
                                        @foreach($category->subCategories as $subCategory)
                                            <li><a href="{{route('products.index')}}?sub-category={{$subCategory->slug}}.html">{{$subCategory->name}}<i class="{{$subCategory->childCategories->count()>0?'fas fa-angle-right':''}}"></i></a>
                                                @if($subCategory->childCategories->count()>0)
                                                    <ul class="wsus__sub_category">
                                                        @foreach($subCategory->childCategories as $childCategory)
                                                            <li><a href="{{route('products.index')}}?child-category={{$childCategory->slug}}.html">{{$childCategory->name}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <ul class="wsus__menu_item">
                        <li><a class="active" href="{{url('/')}}">Trang chủ</a></li>
                        <li><a href="{{route('vendor.index')}}">Gian hàng</a></li>
                        <li><a href="{{route('flash-sale')}}">Khuyến mại</a></li>
                        <li><a href="{{route('blog')}}">Tin tức</a></li>
                        <li><a href="{{route('about')}}">Về chúng tôi</a></li>
                        <li><a href="{{route('contact')}}">Liên hệ</a></li>
                    </ul>
                    <ul class="wsus__menu_item wsus__menu_item_right">
                        <li><a href="{{route('product-tract.index')}}">Tra cứu đơn hàng</a></li>
                        @if(auth()->check())
                            @if(auth()->user()->role === 'user')
                                <li><a href="{{route('user.dashboard')}}">Thông tin cá nhân</a></li>
                            @elseif(auth()->user()->role === 'vendor')
                                <li><a href="{{route('vendor.dashboard')}}">Thông tin cá nhân</a></li>
                            @elseif(auth()->user()->role === 'admin')
                                <li><a href="{{route('admin.dashboard')}}">Thông tin cá nhân</a></li>
                            @endif
                        @endif
                        @if(auth()->check())
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{route('logout')}}" onclick="event.preventDefault();
                                            this.closest('form').submit();">Đăng xuất</a>
                                </form>
                            </li>
                        @else
                            <li><a href="{{route('login')}}">Đăng nhập</a></li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<!--============================
MAIN MENU END
==============================-->


<!--============================
MOBILE MENU START
==============================-->
<section id="wsus__mobile_menu">
    <span class="wsus__mobile_menu_close"><i class="fal fa-times"></i></span>
    <ul class="wsus__mobile_menu_header_icon d-inline-flex">

        <li>
            <a href="{{ route('user.wishlist.index') }}">
                <i class="fal fa-heart"></i>
                <span class="count_wishlist_item">
            					{{ (auth()->check()) ? (\App\Models\Wishlist::where('user_id', auth()->user()->id)->count()) : 0 }}
        						</span>
            </a>
        </li>

        @if(auth()->check())
            @if(auth()->user()->role === 'user')
                <li><a href="{{route('user.dashboard')}}"><i class="far fa-user"></i></a></li>
            @elseif(auth()->user()->role === 'vendor')
                <li><a href="{{route('vendor.dashboard')}}"><i class="far fa-user"></i></a></li>
            @elseif(auth()->user()->role === 'admin')
                <li><a href="{{route('admin.dashboard')}}"><i class="far fa-user"></i></a></li>
            @endif
        @else
            <li><a href="{{route('login')}}"><i class="far fa-user"></i></a></li>
        @endif
    </ul>

    <form action="{{route('products.index')}}" method="get">
        <input type="text" placeholder="Search..." name="search" value="{{isset(request()->search) ? request()->search : ''}}">
        <button type="submit"><i class="far fa-search"></i></button>
    </form>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                    role="tab" aria-controls="pills-home" aria-selected="true">Danh mục
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                    role="tab" aria-controls="pills-profile" aria-selected="false">Menu
            </button>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="wsus__mobile_menu_main_menu">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <ul class="wsus_mobile_menu_category">
                        @foreach($categories as $categoryItem)
                            <li><a href="#" class="{{$categoryItem->subCategories->count()>0 ?'accordion-button': ''}} collapsed" data-bs-toggle="collapse"
                                   data-bs-target="#flush-collapseThreew-{{$loop->index}}" aria-expanded="false"
                                   aria-controls="flush-collapseThreew-{{$loop->index}}">
                                    <i class="{{$categoryItem->icon}}"></i>
                                    {{$categoryItem->name}}
                                </a>
                                @if($categoryItem->subCategories->count()>0)
                                    <div id="flush-collapseThreew-{{$loop->index}}" class="accordion-collapse collapse"
                                         data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <ul>
                                                @foreach($categoryItem->subCategories as $subCategoryItem)
                                                    <li><a href="{{route('products.index')}}?sub-category={{$subCategoryItem->slug}}.html">{{$subCategoryItem->name}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="wsus__mobile_menu_main_menu">
                <div class="accordion accordion-flush" id="accordionFlushExample2">
                    <ul>
                        <li><a href="{{route('home')}}">Trang chủ</a></li>
                        <li><a href="{{route('vendor.index')}}">Gian hàng</a></li>
                        <li><a href="{{route('blog')}}">Tin tức</a></li>
                        <li><a href="{{route('about')}}">Về chúng tôi</a></li>
                        <li><a href="{{route('contact')}}">Liên hệ</a></li>
                        <li><a href="{{route('product-tract.index')}}">Tra cứu đơn hàng</a></li>
                        <li><a href="{{route('flash-sale')}}">Khuyến mại</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
MOBILE MENU END
==============================-->
