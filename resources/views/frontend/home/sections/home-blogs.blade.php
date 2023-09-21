<section id="wsus__blogs" class="home_blogs">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__section_header">
                    <h3>Bài viết gần đây</h3>
                    <a class="see_btn" href="{{route('blog')}}">Xem thêm <i class="fas fa-caret-right"></i></a>
                </div>
            </div>
        </div>
        <div class="row home_blog_slider">
            @foreach($blogs as $blog)
                <div class="col-xl-3">
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
    </div>
</section>
