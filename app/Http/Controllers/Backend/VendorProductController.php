<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Models\ProductVariant;
use App\Models\SubCategory;
use Auth;
use Illuminate\Http\Request;
use Str;

class VendorProductController extends Controller
{
    use \App\Traits\ImageUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(VendorProductDataTable $dataTable)
    {
        return $dataTable->render('vendor.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status',1)->get();
        $brands = Brand::where('status',1)->get();
        return view('vendor.product.create',compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'name' => 'required|max:200',
            'category' => 'required',
            'sub_category' => 'required',
            'child_category' => 'required',
            'brand' => 'required',
            'sku' => 'nullable',
            'price' => 'required',
            'offer_price' => 'nullable',
            'offer_start_date' => 'nullable',
            'offer_end_date' => 'nullable',
            'stock_quantity' => 'required',
            'Video_link' => 'nullable',
            'short_description' => 'required|max:600',
            'full_description' => 'required',
            'product_type' => 'nullable',
            'seo_title' => 'nullable|max:200',
            'seo_description' => 'nullable',
            'status' => 'required',
        ]);

        $imagePath= $this->uploadImage( $request, 'image','uploads');

        $product = new Product();

        $product->thumb_image = $imagePath;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->vendor_id = Auth::user()->vendor->id;
        $product->category_id = $request->category;
        $product->sub_category_id = $request->sub_category;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->quantity = $request->stock_quantity;
        $product->video_link = $request->video_link;
        $product->short_description = $request->short_description;
        $product->full_description = $request->full_description;
        $product->product_type = $request->product_type;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;
        $product->is_approved = 0;
        $product->status = $request->status;

        $product->save();
        toastr('Created Successfully','success');
        return redirect()->route('vendor.products.index');
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
    public function edit(Product $product)
    {
        /*Check user insert id on Url to edit product not theirs*/
        if($product->vendor_id !== Auth::user()->vendor->id){
            abort('404');
        }
        $categories = Category::where('status',1)->get();
        $subCategories = SubCategory::where('category_id',$product->category_id)->get();
        $childCategories = ChildCategory::where('sub_category_id',$product->sub_category_id)->get();
        $brands = Brand::where('status',1)->get();
        return view('vendor.product.edit', compact('product','childCategories','subCategories','categories','brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if (!$request->has('switch_status')) {
            $request->validate([
                'image' => 'nullable|image|max:2048',
                'name' => 'required|max:200',
                'category' => 'required',
                'sub_category' => 'required',
                'child_category' => 'required',
                'brand' => 'required',
                'sku' => 'nullable',
                'price' => 'required',
                'offer_price' => 'nullable',
                'offer_start_date' => 'nullable',
                'offer_end_date' => 'nullable',
                'stock_quantity' => 'required',
                'Video_link' => 'nullable',
                'short_description' => 'required|max:600',
                'full_description' => 'required',
                'product_type' => 'nullable',
                'seo_title' => 'nullable|max:200',
                'seo_description' => 'nullable',
                'status' => 'required',
            ]);
        }
        /*Check user insert id on Url to edit product not theirs*/
        if($product->vendor_id !== Auth::user()->vendor->id){
            abort('404');
        }

        if ($request->has('switch_status')) {
            $product->status = $request->switch_status;
            $product->save();
            return response(['message' =>'Status has been updated!']);
        } else {
            $imagePath = $this->updateImage($request, 'image', 'uploads', $product->thumb_image);
            $product->thumb_image = $imagePath ?? $product->thumb_image;
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->vendor_id = Auth::user()->vendor->id;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->child_category_id = $request->child_category;
            $product->brand_id = $request->brand;
            $product->sku = $request->sku;
            $product->price = $request->price;
            $product->offer_price = $request->offer_price;
            $product->offer_start_date = $request->offer_start_date;
            $product->offer_end_date = $request->offer_end_date;
            $product->quantity = $request->stock_quantity;
            $product->video_link = $request->video_link;
            $product->short_description = $request->short_description;
            $product->full_description = $request->full_description;
            $product->product_type = $request->product_type;
            $product->seo_title = $request->seo_title;
            $product->seo_description = $request->seo_description;
            $product->is_approved = $product->is_approved;
            $product->status = $request->status;

            $product->save();
            toastr('Updated Successfully', 'success');
            return redirect()->route('vendor.products.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $galleryImages = ProductImageGallery::where('product_id', $product->id)->get();

        /* Delete main image*/
        $this->deleteImage($product->thumb_image);

        /* Delete main gallery images */
        if($galleryImages->count() > 0){
            foreach ($galleryImages as $image){
                $this->deleteImage($image->image);
                $image->delete();
            }
        }

        /* Delete main product variants */
        $variants = ProductVariant::where('product_id', $product->id)->get();
        if($variants->count() > 0){
            foreach ($variants as $variant){
                $variant->variantItems()->delete(); // variantItems: relationship
                $variant->delete();

            }
        }

        $product->delete();
        toastr('Delete Successfully','success');
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
//        return $subCategoryId;
        $childCategories = ChildCategory::where('sub_category_id', $subCategoryId)->get();
        return response()->json([
            'status' =>'success',
            'childCategories' => $childCategories
        ]);
    }
}
