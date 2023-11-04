<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function blog(Request $request)
    {
        if($request->has('search')){
            $blogs = Blog::with('category')->where('title','like','%'.$request->search.'%')->where('status', 1)->orderBy('id', 'DESC')->paginate(12);
        }else if($request->has('category')){
            $category = BlogCategory::where('slug',$request->category)->where('status', 1)->first();
            $blogs = Blog::with('category')->where('category_id',$category->id)->where('status', 1)->orderBy('id', 'DESC')->paginate(12);
        }
        else{
            $blogs = Blog::with('category')->where('status', 1)->orderBy('id', 'DESC')->paginate(12);
        }
        return view('frontend.pages.blog', compact('blogs'));

    }
    public function blogDetail(string $slug)
    {
        $categories = BlogCategory::where('status',1)->get();
        $blog = Blog::with('comments')->where('slug', $slug)->where('status',1)->first();
        $moreBlogs = Blog::where('slug', '!=',$slug)->where('status',1)->orderBY('id','DESC')->take(5)->get();
        $recentBlogs = Blog::where('slug', '!=',$slug)->where('status',1)->where('category_id',$blog->category_id)->orderBY('id','DESC')->take(10)->get();
        $comments = $blog->comments()->paginate(10);
		return view('frontend.pages.blog-detail',compact('blog','moreBlogs','comments','categories','recentBlogs'));
    }

    public function comment(Request $request)
    {
        $request->validate([
            'comment' =>  'required',
        ]);
        $blogComment = new BlogComment();
        $blogComment->user_id = \Auth::user()->id;
        $blogComment->blog_id = $request->blog_id;
        $blogComment->comment = $request->comment;
        $blogComment->save();

        toastr()->success('Cảm ơn bạn đã để lại bình luận');
        return redirect()->back();
    }
}
