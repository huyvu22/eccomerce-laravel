@extends('frontend.layouts.master')
@section('title')
    Shop Now
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
                        <h4>Chi tiết bài viết</h4>
                        <ul>
                            <li><a href="#">Tin tức</a></li>
                            <li><a href="#">Chi tiết bài viết</a></li>
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
        BLOGS DETAILS START
    ==============================-->
    <section id="wsus__blog_details">
        <div class="container">
            <div class="row">
                <div class="col-xxl-9 col-xl-8 col-lg-8">
                    <div class="wsus__main_blog">
                        <div class="wsus__main_blog_img">
                            <img src="{{asset($blog->image)}}" alt="blog" class="img-fluid w-100">
                        </div>
                        <p class="wsus__main_blog_header">
                            <span><i class="fas fa-user-tie"></i> {{$blog->user->name}}</span>
                            <span><i class="fal fa-calendar-alt"></i> {{$blog->updated_at->format('d-m-Y')}}</span>
                        </p>
                        <div class="wsus__description_area">
                            <h1>{{$blog->title}}</h1>
                            {!! $blog->content !!}
                        </div>
                        <div class="wsus__share_blog">
                            <p>share:</p>
                            <ul>
                                <li><a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a class="twitter" href="https://twitter.com/share?url={{url()->current()}}&text={{$blog->title}}"><i class="fab fa-twitter"></i></a></li>
                            </ul>
                        </div>
                        @if(count($recentBlogs)>0)
                            <div class="wsus__related_post">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <h5>Các bài viết khác</h5>
                                    </div>
                                </div>
                                <div class="row blog_det_slider">
                                    @foreach($recentBlogs as $blogItem)
                                        <div class="col-xl-3">
                                            <div class="wsus__single_blog wsus__single_blog_2">
                                                <a class="wsus__blog_img" href="{{route('blog-detail',$blogItem->slug)}}">
                                                    <img src="{{asset($blogItem->image)}}" alt="blog" class="img-fluid w-100">
                                                </a>
                                                <div class="wsus__blog_text">
                                                    <a class="blog_top red" href="{{route('blog-detail',$blogItem)}}">{{$blogItem->category->name}}</a>
                                                    <div class="wsus__blog_text_center">
                                                        <a href="{{route('blog-detail',$blogItem->slug)}}">{{limitText($blogItem->title,80)}}</a>
                                                        <p class="date">{{$blogItem->created_at->format('d-m-Y')}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if(count($comments)>0)
                            <div class="wsus__comment_area">
                                <h4>comment <span>{{count($comments)}}</span></h4>

                                <div class="wsus__main_comment">
                                    @foreach($comments as $comment)
                                        <div class="wsus__comment_img">
                                            <img src="{{asset($comment->user->image) !== null ? asset($comment->user->image) :  asset('frontend/images/client_img_1.jpg')}}" alt="user"
                                                 class="img-fluid" width="50">
                                        </div>
                                        <div class="wsus__comment_text replay">
                                            <h6>{{$comment->user->name}} <span>{{$comment->created_at->format('d-m-Y')}}</span></h6>
                                            <p>{{$comment->comment}}</p>
                                        </div>
                                    @endforeach

                                </div>
                                <div id="pagination">
                                    <div class="text-center">
                                        <div class="mt-3 d-inline-block">
                                            @if($comments->hasPages())
                                                {{$comments->withQueryString()->links()}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="wsus__post_comment">
                            <h4>post a comment</h4>
                            <form action="{{route('user.blog-comment')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="wsus__single_com">
                                            <textarea rows="5" placeholder="Your Comment" name="comment"></textarea>
                                        </div>
                                        <input type="hidden" name="blog_id" value="{{$blog->id}}">
                                    </div>
                                    @if($errors->has('comment'))
                                        <br>
                                        <span class="text-danger">{{ $errors->first('comment') }}</span>
                                    @endif
                                </div>
                                <button class="common_btn" type="submit">Bình luận</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4 col-lg-4">
                    <div class="wsus__blog_sidebar" id="sticky_sidebar">
                        <div class="wsus__blog_search">
                            <h4>search</h4>
                            <form action="{{route('blog')}}" method="get">
                                <input type="text" placeholder="Search" name="search">
                                <button type="submit" class="common_btn"><i class="far fa-search"></i></button>
                            </form>
                        </div>
                        <div class="wsus__blog_category">
                            <h4>Danh mục nổi bật</h4>
                            <ul>
                                @foreach($categories as $category)
                                    <li><a href="{{route('blog', ['category'=>$category->slug])}}">{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="wsus__blog_post">
                            <h4>Các bài viết khác</h4>
                            @foreach($moreBlogs as $blogItem)
                                <div class="wsus__blog_post_single">
                                    <a href="#" class="wsus__blog_post_img">
                                        <img src="{{asset($blogItem->image)}}" alt="blog" style="height: 70px" >
                                    </a>
                                    <div class="wsus__blog_post_text">
                                        <a href="#">{{limitText($blogItem->title,55)}}</a>
                                        <p><span>{{$blogItem->created_at->format('d-m-Y')}} </span> {{count($blogItem->comments)}} Comment </p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BLOGS DETAILS END
    ==============================-->

@endsection




