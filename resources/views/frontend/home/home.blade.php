@extends('frontend.layouts.master')

@section('title')
Shop Now
@endsection
@section('content')

    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>

{{--    @include('frontend.layouts.header')--}}


{{--    @include('frontend.layouts.menu')--}}


<!--============================
    BANNER PART 2 START
==============================-->
@include('frontend.home.sections.banner-slider')

<!--============================
    BANNER PART 2 END
==============================-->


<!--============================
    FLASH SELL START
==============================-->
@include('frontend.home.sections.flash-sales')
<!--============================
    FLASH SELL END
==============================-->


<!--============================
   MONTHLY TOP PRODUCT START
==============================-->
@include('frontend.home.sections.top-category-product')
<!--============================
   MONTHLY TOP PRODUCT END
==============================-->


<!--============================
    BRAND SLIDER START
==============================-->
{{--@include('frontend.home.sections.brand-slider')--}}
<!--============================
    BRAND SLIDER END
==============================-->


<!--============================
    SINGLE BANNER START
==============================-->
@include('frontend.home.sections.single-banner')
<!--============================
    SINGLE BANNER END
==============================-->


<!--============================
    HOT DEALS START
==============================-->
@include('frontend.home.sections.hot-deals')
<!--============================
    HOT DEALS END
==============================-->


<!--============================
    ELECTRONIC PART START
==============================-->
@include('frontend.home.sections.single-category-product-slider-1')
<!--============================
    ELECTRONIC PART END
==============================-->


<!--============================
    ELECTRONIC PART START
==============================-->
@include('frontend.home.sections.single-category-product-slider-2')
<!--============================
    ELECTRONIC PART END
==============================-->


<!--============================
    LARGE BANNER  START
==============================-->
{{--@include('frontend.home.sections.large-banner')--}}
<!--============================
    LARGE BANNER  END
==============================-->


<!--============================
    WEEKLY BEST ITEM START
==============================-->
@include('frontend.home.sections.weekly-best-item')
<!--============================
    WEEKLY BEST ITEM END
==============================-->


<!--============================
  HOME SERVICES START
==============================-->
@include('frontend.home.sections.home-services')
<!--============================
    HOME SERVICES END
==============================-->


<!--============================
    HOME BLOGS START
==============================-->
@include('frontend.home.sections.home-blogs')
<!--============================
    HOME BLOGS END
==============================-->

@endsection

@push('scripts')
<script>


    document.addEventListener('DOMContentLoaded', function () {

        window.addEventListener('DOMContentLoaded',()=>{
            window.onload = function(){
                document.querySelector('.default-active').click();
                document.querySelector('.new-arrival-active').click();
                document.body.classList.add("loaded");
                // setTimeout(() => {
                //     document.body.classList.add("loaded");
                // }, 100);
            }
        });

    });
</script>
@endpush

