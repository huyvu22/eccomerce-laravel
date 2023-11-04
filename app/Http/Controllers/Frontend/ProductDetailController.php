<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductVariantItem;
use App\Models\SubCategory;
use Cart;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{

    public function products(Request $request)
    {
        // Base query to retrieve products
        $query = Product::withAvg('reviews', 'rating')
            ->with(['variants.variantItems','category','productImageGalleries'])
            ->withCount('reviews')
            ->where('status', 1)
            ->where('is_approved', 1);

        // Filter by category, sub-category, child-category, or brand
        if ($request->has('category')) {
            // Handle category filter
            $categorySlug = str_replace('.html', '', $request->category);
            $category = Category::where('slug', $categorySlug)->first();
            $query->where('category_id', $category->id);
        } elseif ($request->has('sub-category')) {
            // Handle sub-category filter
            $subCategorySlug = str_replace('.html', '', $request->input('sub-category'));
            $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
            $query->where('sub_category_id', $subCategory->id);
        } elseif ($request->has('child-category')) {
            // Handle child-category filter
            $childCategorySlug = str_replace('.html', '', $request->input('child-category'));
            $childCategory = ChildCategory::where('slug', $childCategorySlug)->first();
            $query->where('child_category_id', $childCategory->id);
        } elseif ($request->has('brand')) {
            // Handle brand filter
            $brand = Brand::where('slug', $request->input('brand'))->first();
            $query->where('brand_id', $brand->id);
        }

        // Filter by search keyword
        if ($request->has('search')) {
            $searchKeyword = $request->input('search');
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('name', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('full_description', 'like', '%' . $searchKeyword . '%')
                    ->orWhereHas('category', function ($cq) use ($searchKeyword) {
                        $cq->where('name', 'like', '%' . $searchKeyword . '%');
                    });
            });
        } elseif ($request->has('suggest_keywords')){
            $searchKeyword = $request->input('suggest_keywords');
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('name', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('full_description', 'like', '%' . $searchKeyword . '%')
                    ->orWhereHas('category', function ($cq) use ($searchKeyword) {
                        $cq->where('name', 'like', '%' . $searchKeyword . '%');
                    });
            });
            return response()->json([
                'status' => 'success',
                'products' => $query->get(),
            ]);
        }

        // Filter by price range
        if ($request->has('price_range')) {
            $price = explode(';', $request->input('price_range'));
            $from = reverseFormatNumber($price[0]);
            $to = reverseFormatNumber($price[1]);
            $query->whereBetween('price', [$from, $to]);
        }

        // Sort products
        if ($request->has('sortBy')) {
            $sortBy = $request->input('sortBy');
            $query->orderBy('price', $sortBy);
        }elseif ($request->has('type')){
            $type = $request->input('type');
            if($type == 'new_product'){
                $query->where('product_type', 'new_arrival');
            }else{
                $query->whereHas('reviews', function ($q) use($type){
                    $q->orderBy('rating', 'DESC');
                });
            }
        }

        // Paginate the results
        $products = $query->orderBy('id', 'DESC')->paginate(12);
        $params = $request->all();

        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();
        $productPageBanner = Advertisement::where('key','product_page_banner' )->first();

        return view('frontend.pages.product',compact('products','params','categories', 'brands','productPageBanner',));
    }

    public function showProductDetail(string $slug)
    {
        $product = Product::with(['vendor','category','subCategory','productImageGalleries','variants', 'brand'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->where('slug',$slug)
            ->where('status',1)->first();
        $reviews = ProductReview::where(['status' => 1, 'product_id' => $product?->id])->paginate(10);
        $relatedProducts = Product::with(['category', 'variants'])->where('slug','!=',$slug)->where('status',1)->where('category_id',$product->category_id)->take(6)->get();

        return view('frontend.pages.product-detail', compact('product','reviews', 'relatedProducts'));
    }


    public function showProductModal(string $id)
    {
        $product = Product::withAvg('reviews', 'rating')
            ->with(['variants','category'])
            ->withCount('reviews')
            ->find($id);
        $content =  view('frontend.layouts.product-modal', compact('product'))->render();
        return \Illuminate\Support\Facades\Response::make($content, 200, ['Content-Type' => 'text/html']);
    }

    public function buyProduct(Request $request)
    {
        $product = Product::find($request->product_id);

        //Check product quantity in stock
        if($product->quantity === 0){
           toastr()->error('Xin lỗi, sản phẩm này đã hết');
           return redirect()->back();
        }
        $variants = [];
        $variantTotalAmount = 0;

        if($request->has('variants_items')){
            foreach ($request->variants_items  as $itemId) {
                $variantsItem = ProductVariantItem::find($itemId); // 64Gb, Red
                $variants[$variantsItem->variant->name]['name'] = $variantsItem->name; // $variantsItem->variant->name : Tim dc variant (Color, Bo nho)
                $variants[$variantsItem->variant->name]['price'] = $variantsItem->price;
                $variantTotalAmount += $variantsItem->price;
            }
        }

        $productPrice = 0;
        if(checkDiscount($product)){
            $productPrice += $product->offer_price ;
        }else{
            $productPrice += $product->price ;
        }

        $cartData = [];
        $cartData['id'] = $product->id;
        $cartData['name'] = $product->name;
        $cartData['qty'] = $request->qty;
        $cartData['price'] = $productPrice;
        $cartData['weight'] = 4;
        $cartData['options']['variants'] = $variants;
        $cartData['options']['variants_total'] = $variantTotalAmount;
        $cartData['options']['image'] = $product->thumb_image;
        $cartData['options']['slug'] = $product->slug;

        Cart::add($cartData);

        return  redirect()->route('cart-detail');
    }

}
