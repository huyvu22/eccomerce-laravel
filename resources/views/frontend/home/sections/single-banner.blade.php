@php
    $homepageBannerSection2 = json_decode($homepageBannerSection2?->value)
@endphp
<section id="wsus__single_banner" class="wsus__single_banner_2">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 text-center">
                @if($homepageBannerSection2->banner_1->banner_status == 1)
                    <div class="wsus__single_banner_content">
                        <div class="wsus__single_banner_text">
                            <a class="shop_btn" href="{{$homepageBannerSection2->banner_1->banner_url}}">Mua ngay</a>
                        </div>
                        <div class="wsus__single_banner_img">
                            <img src="{{asset($homepageBannerSection2->banner_1->banner_image)}}" alt="banner" class="img-fluid w-100">
                        </div>

                    </div>
                @endif
            </div>
            <div class="col-xl-6 col-lg-6">
                @if($homepageBannerSection2->banner_2->banner_status == 1)
                    <div class="wsus__single_banner_content single_banner_2">
                        <div class="wsus__single_banner_text">
                            <a class="shop_btn" href="{{$homepageBannerSection2->banner_2->banner_url}}">Mua ngay</a>
                        </div>
                        <div class="wsus__single_banner_img">
                            <img src="{{asset($homepageBannerSection2->banner_2->banner_image)}}" alt="banner" class="img-fluid w-100">
                        </div>

                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
