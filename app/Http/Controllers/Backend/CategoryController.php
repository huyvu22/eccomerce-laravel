<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CategoryDataTable;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.category.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'icon'=>'required|not_in:empty',
            'name'=>'required|max:200|unique:categories,name',
            'status'=>'required',
        ]);
        $category= new Category();

        $category->icon= $request->icon;
        $category->name= $request->name;
        $category['status']= $request->status;
        $category->slug= Str::slug($request->name);
        $category->save();
        toastr('Created Successfully','success');

        return redirect()->route('admin.category.index');
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
    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = [];

        if (!$request->has('switch_status')) {
            $rules['icon'] = 'required|not_in:empty';
            $rules['name'] = 'required|max:200|unique:categories,name,'.$category->id;
        }

        $request->validate($rules);

        if ($request->has('switch_status')) {
            $category['status'] = $request->switch_status;
            $category->save();
            return response(['message' =>'Status has been updated!']);
        } else {
            $category->icon = $request->icon;
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category['status'] = $request->status;
            $category->save();
            toastr('Updated Successfully', 'success');
            return redirect()->route('admin.category.index');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $subCategories= $category->subCategories;
        if($subCategories->count()>0){
            toastr('Can not delete '.$category->name.'! We have '.$subCategories->count().' sub category','error');
        }else{
            $category->delete();
            toastr('Delete Successfully');
        }
        return redirect()->back();

    }
}
