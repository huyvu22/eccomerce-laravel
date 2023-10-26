<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">
    <title>
        @yield('title')
    </title>
    <link rel="icon" type="image/png" href="{{asset('uploads/logo.png')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/modules/summernote/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery.nice-number.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery.calendar.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/add_row_custon.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/mobile_menu.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery.exzoom.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/multiple-image-video.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/ranger_style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery.classycountdown.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/venobox.min.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{asset('backend/assets/css/bootstrap-iconpicker.min.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap.min.css">


    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/responsive.css')}}">
    <!-- <link rel="stylesheet" href="css/rtl.css"> -->

</head>

<body>


<!--=============================
  DASHBOARD MENU START
==============================-->
<div class="wsus__dashboard_menu">
    <div class="wsusd__dashboard_user">
        <img src="{{Auth::user()->image ? Auth::user()->image : asset('frontend/images/ts-2.jpg')}}" alt="img" class="img-fluid">
        <p>{{Auth::user()->name}}</p>
    </div>
</div>
<!--=============================
  DASHBOARD MENU END
==============================-->


<!--=============================
  DASHBOARD START
==============================-->
@yield('content')
<!--=============================
  DASHBOARD START
==============================-->


<!--============================
    SCROLL BUTTON START
  ==============================-->
<div class="wsus__scroll_btn">
    <i class="fas fa-chevron-up"></i>
</div>
<!--============================
  SCROLL BUTTON  END
==============================-->

<!--Ajax JS-->
@include('frontend.layouts.scripts')

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="{{asset('frontend/js/main.js')}}"></script>

<!--jquery library js-->
<script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>
<!--bootstrap js-->
<script src="{{asset('frontend/js/bootstrap.bundle.min.js')}}"></script>
<!--font-awesome js-->
<script src="{{asset('frontend/js/Font-Awesome.js')}}"></script>
<!--select2 js-->
<script src="{{asset('frontend/js/select2.min.js')}}"></script>
<!--slick slider js-->
<script src="{{asset('frontend/js/slick.min.js')}}"></script>
<!--simplyCountdown js-->
<script src="{{asset('frontend/js/simplyCountdown.js')}}"></script>
<!--product zoomer js-->
<script src="{{asset('frontend/js/jquery.exzoom.js')}}"></script>
<!--nice-number js-->
<script src="{{asset('frontend/js/jquery.nice-number.min.js')}}"></script>
<!--counter js-->
<script src="{{asset('frontend/js/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery.countup.min.js')}}"></script>
<!--add row js-->
<script src="{{asset('frontend/js/add_row_custon.js')}}"></script>
<!--multiple-image-video js-->
<script src="{{asset('frontend/js/multiple-image-video.js')}}"></script>
<!--sticky sidebar js-->
<script src="{{asset('frontend/js/sticky_sidebar.js')}}"></script>
<!--price ranger js-->
<script src="{{asset('frontend/js/ranger_jquery-ui.min.js')}}"></script>
<script src="{{asset('frontend/js/ranger_slider.js')}}"></script>
<!--isotope js-->
<script src="{{asset('frontend/js/isotope.pkgd.min.js')}}"></script>
<!--venobox js-->
<script src="{{asset('frontend/js/venobox.min.js')}}"></script>
<!--classycountdown js-->
<script src="{{asset('frontend/js/jquery.classycountdown.js')}}"></script>
<!--toastr js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="{{asset('backend/assets/modules/moment.min.js')}}"></script>
<script src="{{asset('backend/assets/modules/summernote/summernote-bs4.js')}}"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="{{asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!--main/custom js-->
{{--<script src="{{asset('frontend/js/main.js')}}"></script>--}}
{{--<script src="{{asset('backend/js/script.js')}}"></script>--}}

<script>
    $('.close_icon').on('click', function () {
        $('.dashboard_sidebar').toggleClass('show_dash_menu');
    });

    $('.close_icon').on('click', function () {
        $('.dash_close').toggleClass('dash_opasity');
    });

    $('.summernote').summernote({
        height: 200,
    })

    $('.datepicker').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD',
        },
        singleDatePicker: true
    })
</script>

<script>
    @if($errors->any())
    toastr.error('Kiểm tra các lỗi bên dưới')
    @endif
</script>

@stack('scripts')
</body>

</html>

