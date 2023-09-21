<!--============================
    BANNER PART 2 START
==============================-->
<section id="wsus__banner">
    {{-- <div class="container"> --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="wsus__banner_content">
                <div class="row banner_slider">
                    @if ($sliders_2->count() > 0)
                        @foreach ($sliders_2 as $slider)
                            <div class="col-xl-12">
                                <div class="wrapper_slider">
                                    <div class="wsus__single_slider" style="background: url({{ $slider->banner }});">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
</section>
<!--============================
    BANNER PART 2 END
==============================-->
