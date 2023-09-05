<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ChildCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\HomePageSetting;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ChildCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.child-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories= Category::where('status',1)->get();

       return view('admin.child-category.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' =>'required',
            'sub_category'=>'required',
            'name'=>'required|max:200|unique:child_categories,name',
            'status'=>'required',
        ]);

        $childCategory = new ChildCategory();
        $childCategory->category_id = $request->category;
        $childCategory->sub_category_id = $request->sub_category;
        $childCategory->name = $request->name;
        $childCategory->slug = Str::slug($request->name);
        $childCategory->status = $request->status;
        $childCategory->save();
        toastr('Created Successfully');
        return redirect()->route('admin.child-category.index');
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
    public function edit(ChildCategory $childCategory)
    {
        $categories = Category::where('status',1)->get();
        $subCategories = SubCategory::where('category_id',$childCategory->category_id)->get();
        return view('admin.child-category.edit', compact('categories','subCategories','childCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ChildCategory $childCategory)
    {
        $rules = [];

        if (!$request->has('switch_status')) {
            $rules['category'] = 'required';
            $rules['sub_category'] = 'required';
            $rules['name'] = 'required|max:200|unique:child_categories,name,'.$childCategory->id;
            $rules['status'] = 'required';
        }

        $request->validate($rules);

        if ($request->has('switch_status')) {

            $childCategory->status = $request->switch_status;
            $childCategory->save();
            return response(['message' =>'Status has been updated!']);

        } else {
            $childCategory->category_id = $request->category;
            $childCategory->sub_category_id = $request->sub_category;
            $childCategory->name = $request->name;
            $childCategory->slug = Str::slug($request->name);
            $childCategory->status = $request->status;
            $childCategory->save();
            toastr('Updated Successfully');
            return redirect()->route('admin.child-category.index');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChildCategory $childCategory)
    {
        if(Product::where('child_category_id', $childCategory->id)->count()){
            toastr('This item contain relation, can not delete it','error');
            return redirect()->back();
        }

        $homePageSettings = HomePageSetting::all();
        foreach ($homePageSettings as $homePageSetting) {
            $items = json_decode($homePageSetting->value, true);

            //Ver 1
//            foreach ($items as $item) {
////                $childCategoryId = $item['child_category'];
////                if($childCategoryId == $childCategory->id){
////                    toastr('This item contain relation, can not delete it','error');
////                    return redirect()->back();
////                }
////            }

            //Ver 2
            $collection = collect($items);
            if($collection->contains('child_category', $childCategory->id)){
                toastr('This item contain relation, can not delete it','error');
                return redirect()->back();
            }

        }


        $childCategory->delete();
        toastr('Deleted Successfully');
        return redirect()->back();
    }

    public function getSubCategory($categoryId)
    {
        $subCategories = SubCategory::where('category_id', $categoryId)->where('status',1)->get();
        return response()->json([
            'status' =>'success',
            'subCategories' => $subCategories
        ]);
    }
}
