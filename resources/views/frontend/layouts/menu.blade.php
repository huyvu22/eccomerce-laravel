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

                        {{--                        <li><a href="#"><i class="fas fa-home-lg-alt"></i> Home & Garden</a></li>--}}
                        {{--                        <li><a href="#"><i class="far fa-camera"></i> Accessories</a></li>--}}
                        {{--                        <li><a href="#"><i class="fas fa-heartbeat"></i> Healthy & Beauty</a></li>--}}
                        {{--                        <li><a href="#"><i class="fal fa-gift-card"></i> Gift Ideas</a></li>--}}
                        {{--                        <li><a href="#"><i class="fal fa-gamepad-alt"></i> Toy & Games</a></li>--}}
                        {{--                        <li><a href="#"><i class="fal fa-gem"></i> View All Categories</a></li>--}}
                    </ul>

                    <ul class="wsus__menu_item">
                        <li><a class="active" href="{{url('/')}}">home</a></li>
                        <li><a href="product_grid_view.html">shop <i class="fas fa-caret-down"></i></a>
                            <div class="wsus__mega_menu">
                                <div class="row">
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="wsus__mega_menu_colum">
                                            <h4>women</h4>
                                            <ul class="wsis__mega_menu_item">
                                                <li><a href="#">New Arrivals</a></li>
                                                <li><a href="#">Best Sellers</a></li>
                                                <li><a href="#">Trending</a></li>
                                                <li><a href="#">Clothing</a></li>
                                                <li><a href="#">Shoes</a></li>
                                                <li><a href="#">Bags</a></li>
                                                <li><a href="#">Accessories</a></li>
                                                <li><a href="#">Jewlery & Watches</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="wsus__mega_menu_colum">
                                            <h4>men</h4>
                                            <ul class="wsis__mega_menu_item">
                                                <li><a href="#">New Arrivals</a></li>
                                                <li><a href="#">Best Sellers</a></li>
                                                <li><a href="#">Trending</a></li>
                                                <li><a href="#">Clothing</a></li>
                                                <li><a href="#">Shoes</a></li>
                                                <li><a href="#">Bags</a></li>
                                                <li><a href="#">Accessories</a></li>
                                                <li><a href="#">Jewlery & Watches</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="wsus__mega_menu_colum">
                                            <h4>category</h4>
                                            <ul class="wsis__mega_menu_item">
                                                <li><a href="#"> Healthy & Beauty</a></li>
                                                <li><a href="#">Gift Ideas</a></li>
                                                <li><a href="#">Toy & Games</a></li>
                                                <li><a href="#">Cooking</a></li>
                                                <li><a href="#">Smart Phones</a></li>
                                                <li><a href="#">Cameras & Photo</a></li>
                                                <li><a href="#">Accessories</a></li>
                                                <li><a href="#">View All Categories</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3">
                                        <div class="wsus__mega_menu_colum">
                                            <h4>women</h4>
                                            <ul class="wsis__mega_menu_item">
                                                <li><a href="#">New Arrivals</a></li>
                                                <li><a href="#">Best Sellers</a></li>
                                                <li><a href="#">Trending</a></li>
                                                <li><a href="#">Clothing</a></li>
                                                <li><a href="#">Shoes</a></li>
                                                <li><a href="#">Bags</a></li>
                                                <li><a href="#">Accessories</a></li>
                                                <li><a href="#">Jewlery & Watches</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li><a href="{{route('vendor.index')}}">vendor</a></li>
                        <li><a href="{{route('blog')}}">blog</a></li>
                        <li><a href="daily_deals.html">campain</a></li>
                        <li class="wsus__relative_li"><a href="#">pages <i class="fas fa-caret-down"></i></a>
                            <ul class="wsus__menu_droapdown">
                                <li><a href="404.html">404</a></li>
                                <li><a href="faqs.html">faq</a></li>
                                <li><a href="invoice.html">invoice</a></li>
                                <li><a href="about_us.html">about</a></li>
                                <li><a href="product_grid_view.html">product</a></li>
                                <li><a href="check_out.html">check out</a></li>
                                <li><a href="team.html">team</a></li>
                                <li><a href="change_password.html">change password</a></li>
                                <li><a href="custom_page.html">custom page</a></li>
                                <li><a href="forget_password.html">forget password</a></li>
                                <li><a href="privacy_policy.html">privacy policy</a></li>
                                <li><a href="product_category.html">product category</a></li>
                                <li><a href="brands.html">brands</a></li>
                            </ul>
                        </li>
                        <li><a href="{{route('product-tract.index')}}">track order</a></li>
                        <li><a href="daily_deals.html">daily deals</a></li>
                    </ul>
                    <ul class="wsus__menu_item wsus__menu_item_right">
                        <li><a href="{{route('contact')}}">contact</a></li>
                        @if(auth()->check())
                            @if(auth()->user()->role === 'user')
                                <li><a href="{{route('user.dashboard')}}">my account</a></li>
                            @elseif(auth()->user()->role === 'vendor')
                                <li><a href="{{route('vendor.dashboard')}}">my account</a></li>
                            @elseif(auth()->user()->role === 'admin')
                                <li><a href="{{route('admin.dashboard')}}">my account</a></li>
                            @endif
                        @endif
                        @if(auth()->check())
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{route('logout')}}" onclick="event.preventDefault();
                                            this.closest('form').submit();">Log out</a>
                                </form>
                            </li>
                        @else
                            <li><a href="{{route('login')}}">login</a></li>
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
                    role="tab" aria-controls="pills-home" aria-selected="true">Categories
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                    role="tab" aria-controls="pills-profile" aria-selected="false">main menu
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
                        <li><a href="{{route('home')}}">home</a></li>
                        <li><a href="{{route('vendor.index')}}">vendor</a></li>
                        <li><a href="{{route('blog')}}">blog</a></li>
                        <li><a href="{{route('about')}}">about us</a></li>
                        <li><a href="{{route('contact')}}">contact</a></li>
                        <li><a href="{{route('product-tract.index')}}">track order</a></li>
                        <li><a href="{{route('flash-sale')}}">Flash Sale</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
MOBILE MENU END
==============================-->
