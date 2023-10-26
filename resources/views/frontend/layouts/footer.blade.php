@php use App\Models\FooterColumnThree;use App\Models\FooterColumnTwo;use App\Models\FooterInfo;use App\Models\FooterSocial;use App\Models\FooterTitle; @endphp
@php
    $footerInfo = FooterInfo::first();
    $footerSocials = FooterSocial::where('status',1)->get();
    $footerColumnTwo = FooterColumnTwo::where('status',1)->get();
    $footerTitle = FooterTitle::first();

    $footerColumnThree = FooterColumnThree::where('status',1)->get();
    $footerTitle = FooterTitle::first();
@endphp
        <!--============================
    FOOTER PART START
==============================-->
<footer class="footer_2">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-xl-3 col-sm-7 col-md-6 col-lg-3">
                <div class="wsus__footer_content">
                    <a class="wsus__footer_2_logo" href="#">
                        {{--                        <img src="{{asset(@$footerInfo->logo)}}" alt="logo" width="100">--}}
                        <img src="{{ asset('frontend/images/logo.png') }}" alt="log">

                    </a>
                    <p class="slogan">Cung cấp sản phẩm chất lượng từ các thương hiệu hàng đầu.</p>
                    <a class="action" href="callto:0943603845"><i class="fas fa-phone-alt"></i>
                        {{$footerInfo->phone}}</a>
                    <a class="action" href="mailto:vuduchuyds@gmail.com"><i class="far fa-envelope"></i>
                        {{$footerInfo->email}}</a>
                    <p><i class="fal fa-map-marker-alt"></i>{{$footerInfo->address}}</p>
                    <ul class="wsus__footer_social">
                        @foreach($footerSocials as $social)
                            <li><a class="{{$social->name}}" href="{{$social->url}}"><i class="{{$social->icon}}"></i></a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-5 col-md-4 col-lg-2">
                <div class="wsus__footer_content">
                    <h5>{{$footerTitle->footer_column_2_title}}</h5>
                    <ul class="wsus__footer_menu">
                        @foreach($footerColumnTwo as $link)
                            <li><a href="{{$link->url}}"><i class="fas fa-caret-right"></i> {{$link->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-sm-5 col-md-4 col-lg-2">
                <div class="wsus__footer_content">
                    <h5>{{$footerTitle->footer_column_3_title}}</h5>
                    <ul class="wsus__footer_menu">
                        @foreach($footerColumnThree as $link)
                            <li><a href="{{$link->url}}"><i class="fas fa-caret-right"></i> {{$link->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-4 col-sm-7 col-md-8 col-lg-5">
                <div class="wsus__footer_content wsus__footer_content_2">
                    <h3>Đăng ký ngay</h3>
                    <p>Để không bỏ lỡ thông tin khuyến mại, sản phẩm mới nhanh nhất</p>
                    <form action="{{route('newsletter')}}" method="post" class="form_subscribe">
                        @csrf
                        <input type="text" class="email_input" placeholder="Email..." name="email">
                        <button type="button" class="common_btn subscribe">Đăng ký</button>
                    </form>
                    <div class="footer_payment">
                        <p>Phương thức thanh toán :</p>
                        <img src="https://asset.vuahanghieu.com/assets/images/payment-method.svg" alt="card" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wsus__footer_bottom">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__copyright d-flex justify-content-center">
                        <p>{{$footerInfo->copyright}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--============================
FOOTER PART END
==============================-->
