<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BlogDataTable;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Str;

class BlogController extends Controller
{
    use \App\Traits\ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BlogDataTable $dataTable)
    {

        return $dataTable->render('admin.blog.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('blog.add',Blog::class);
        $categories = BlogCategory::where('status', 1)->get();
        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:3000',
            'title' => 'required|max:200|unique:blogs,title',
            'category' => 'required',
            'content' => 'required',
            'status' => 'required',
        ]);

        $imagePath = $this->uploadImage($request, 'image', 'uploads');


        $blog = new Blog();
        $blog->image = $imagePath;
        $blog->title = $request->title;
        $blog->slug = Str::slug($request->title);
        $blog->category_id = $request->category;
        $blog->user_id = \Auth::user()->id;
        $blog->content = $request->content;
        $blog->status = $request->status;
        $blog->save();

        toastr()->success('Created Successfully');
        return redirect()->route('admin.blog.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $this->authorize('blog.edit',$blog);
        $categories = BlogCategory::where('status', 1)->get();
        return view('admin.blog.edit', compact('categories','blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $this->authorize('blog.edit',$blog);
        if ($request->has('switch_status')) {
            $blog->status = $request->switch_status;
            $blog->save();
            return response(['message' => 'Status has been updated!']);
        } else {
            $request->validate([
                'image' => 'nullable|image|max:3000',
                'title' => 'required|max:200|unique:blogs,title,'.$blog->id,
                'category' => 'required',
                'content' => 'required',
                'status' => 'required',
            ]);
            $imagePath = $this->updateImage($request, 'image', 'uploads', $blog->image);

            $blog->image =  $imagePath ?? $blog->image;
            $blog->title = $request->title;
            $blog->slug = Str::slug($request->title);
            $blog->category_id = $request->category;
            $blog->user_id = \Auth::user()->id;
            $blog->content = $request->content;
            $blog->status = $request->status;
            $blog->save();
            toastr('Updated Successfully', 'success');
            return redirect()->route('admin.blog.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $this->authorize('blog.delete',$blog);
        /* Delete main image*/
        $this->deleteImage($blog->image);

        $blog->comments()->delete();
        $blog->delete();
        toastr('Deleted Successfully', 'success');
        return redirect()->back();
    }
}
