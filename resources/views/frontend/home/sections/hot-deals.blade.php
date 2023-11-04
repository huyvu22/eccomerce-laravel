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
                        <x-product-card :product="$product" :key="$key"/>
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
                                <div class="wsus__single_banner_text">
                                    <a class="shop_btn" href="{{$homepageBannerSection3->banner_1->banner_url}}">Mua ngay</a>
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
                                        <div class="wsus__single_banner_text">
                                            <a class="shop_btn" href="{{$homepageBannerSection3->banner_2->banner_url}}">Mua ngay</a>
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
                                        <div class="wsus__single_banner_text">
                                            <a class="shop_btn" href="{{$homepageBannerSection3->banner_3->banner_url}}">Mua ngay</a>
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



