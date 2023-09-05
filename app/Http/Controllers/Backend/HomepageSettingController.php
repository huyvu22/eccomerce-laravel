<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\HomePageSetting;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class HomepageSettingController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)->get();
        $popularCategorySection = HomePageSetting::where('key', 'popular_category_section')->first();
        $productSliderSectionOne = HomePageSetting::where('key', 'product_sliders_section_one')->first();
        $productSliderSectionTwo = HomePageSetting::where('key', 'product_sliders_section_two')->first();
        $productSliderSectionThree = HomePageSetting::where('key', 'product_sliders_section_three')->first();
        return view('admin.homepage-setting.index', compact('categories','popularCategorySection','productSliderSectionOne','productSliderSectionTwo', 'productSliderSectionThree'));
    }

    public function updatePopularCategorySection(Request $request)
    {
        $request->validate([
            'category_1' => 'required',
            'category_2' => 'required',
            'category_3' => 'required',
            'category_4' => 'required',
        ]);
       $data =[
           [
               'category' =>$request->category_1,
               'sub_category' =>$request->sub_category_1,
               'child_category' =>$request->child_category_1,
           ],
           [
               'category' =>$request->category_2,
               'sub_category' =>$request->sub_category_2,
               'child_category' =>$request->child_category_2,
           ],
           [
               'category' =>$request->category_3,
               'sub_category' =>$request->sub_category_3,
               'child_category' =>$request->child_category_3,
           ],
           [
               'category' =>$request->category_4,
               'sub_category' =>$request->sub_category_4,
               'child_category' =>$request->child_category_4,
           ]
       ];

        HomePageSetting::updateOrCreate(
            [
                'key' =>'popular_category_section',
            ],
            [
                'value'=>json_encode($data)
            ]
        );
        toastr()->success('Updated Successfully');
        return redirect()->back();

    }

    public function updateProductSlidersSectionOne(Request $request)
    {
        $request->validate([
            'category' => 'required',
        ]);
        $data =[
                'category' =>$request->category,
                'sub_category' =>$request->sub_category,
                'child_category' =>$request->child_category,
        ];

        HomePageSetting::updateOrCreate(
            [
                'key' =>'product_sliders_section_one',
            ],
            [
                'value'=>json_encode($data)
            ]
        );
        toastr()->success('Updated Successfully');
        return redirect()->back();
    }

    public function updateProductSlidersSectionTwo(Request $request)
    {

        $request->validate([
            'category' => 'required',
        ]);
        $data =[
            'category' =>$request->category,
            'sub_category' =>$request->sub_category,
            'child_category' =>$request->child_category,
        ];

        HomePageSetting::updateOrCreate(
            [
                'key' =>'product_sliders_section_two',
            ],
            [
                'value'=>json_encode($data)
            ]
        );
        toastr()->success('Updated Successfully');
        return redirect()->back();
    }

    public function updateProductSlidersSectionThree(Request $request)
    {

        $request->validate([
            'category_1' => 'required',
            'category_2' => 'required',
        ]);
        $data =[
            [
                'category' =>$request->category_1,
                'sub_category' =>$request->sub_category_1,
                'child_category' =>$request->child_category_1,
            ],
            [
                'category' =>$request->category_2,
                'sub_category' =>$request->sub_category_2,
                'child_category' =>$request->child_category_2,
            ],
        ];

        HomePageSetting::updateOrCreate(
            [
                'key' =>'product_sliders_section_three',
            ],
            [
                'value'=>json_encode($data)
            ]
        );
        toastr()->success('Updated Successfully');
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
    public function getChildCategory($subCategoryId)
    {
        $childCategories = ChildCategory::where('sub_category_id', $subCategoryId)->get();
        return response()->json([
            'status' =>'success',
            'childCategories' => $childCategories
        ]);
    }
}
