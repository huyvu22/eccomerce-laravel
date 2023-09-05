@php
    $homepageBannerSection2 = json_decode($homepageBannerSection2?->value)
@endphp
<section id="wsus__single_banner" class="wsus__single_banner_2">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                @if($homepageBannerSection2->banner_1->banner_status == 1)
                    <div class="wsus__single_banner_content">
                        <div class="wsus__single_banner_img">
                            <img src="{{asset($homepageBannerSection2->banner_1->banner_image)}}" alt="banner" class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>sell on <span>35% off</span></h6>
                            <h3>smart watch</h3>
                            <a class="shop_btn" href="{{$homepageBannerSection2->banner_1->banner_url}}">shop now</a>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-xl-6 col-lg-6">
                @if($homepageBannerSection2->banner_2->banner_status == 1)
                    <div class="wsus__single_banner_content single_banner_2">
                        <div class="wsus__single_banner_img">
                            <img src="{{asset($homepageBannerSection2->banner_2->banner_image)}}" alt="banner" class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>New Collection</h6>
                            <h3>bicycle</h3>
                            <a class="shop_btn" href="{{$homepageBannerSection2->banner_2->banner_url}}">shop now</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
