@extends('frontend.layouts.master')
@section('title')
    Shop Now | Blog
@endsection
@section('content')
    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Bài viết mới</h4>
                        <ul>
                            <li><a href="#">Trang chủ</a></li>
                            <li><a href="#">Tin tức</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        BLOGS PAGE START
    ==============================-->
    <section id="wsus__blogs">
        <div class="container">
            @if(request()->has('search'))
                <h5>Tìm kiếm: {{request()->search}}</h5>
            @endif
            <div class="row">
                @foreach($blogs as $blog)
                    <div class="col-xl-4 col-sm-6 col-lg-4 col-xxl-3">
                        <div class="wsus__single_blog wsus__single_blog_2">
                            <a class="wsus__blog_img" href="{{route('blog-detail',$blog->slug)}}">
                                <img src="{{asset($blog->image)}}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="wsus__blog_text">
                                <a class="blog_top red" href="{{route('blog', ['category'=>$blog->category->slug])}}">{{$blog->category->name}}</a>
                                <div class="wsus__blog_text_center">
                                    <a href="{{route('blog-detail',$blog->slug)}}">{{limitText($blog->title,80)}}</a>
                                    <p class="date">{{$blog->created_at->format('d-m-Y')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
                @if(count($blogs) == 0)
                    <div class="row mt-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h3>Không tìm thấy bài viết</h3>
                            </div>
                        </div>
                    </div>
                @endif
            <div id="pagination">
                <div class="text-center">
                    <div class="mt-3 d-inline-block">
                        @if($blogs->hasPages())
                            {{$blogs->withQueryString()->links()}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BLOGS PAGE END
    ==============================-->

@endsection





