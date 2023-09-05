<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BlogCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BlogCategoryDataTable $dataTable)
    {
		return $dataTable->render('admin.blog.blog-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.blog-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:200|unique:blog_categories,name',
            'status' => 'required',
        ]);

        $blogCategory = new BlogCategory();
        $blogCategory->name = $request->name;
        $blogCategory->slug = Str::slug($request->name);
        $blogCategory->status = $request->status;
        $blogCategory->save();

        toastr()->success('Created Successfully');
        return redirect()->route('admin.blog-category.index');
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
    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog.blog-category.edit', compact('blogCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {

        if ($request->has('switch_status')) {
            $blogCategory->status = $request->switch_status;
            $blogCategory->save();
            return response(['message' => 'Status has been updated!']);
        } else {
            $request->validate([
                'name' => 'required|max:200|unique:blog_categories,name,' . $blogCategory->id,
            ]);
            $blogCategory->name = $request->name;
            $blogCategory->slug = Str::slug($request->name);
            $blogCategory->status = $request->status;
            $blogCategory->save();
            toastr('Updated Successfully', 'success');
            return redirect()->route('admin.blog-category.index');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();
        toastr('Delete Successfully', 'success');
        return redirect()->back();
    }
}
