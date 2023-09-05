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
use Illuminate\Http\Request;
use Cart;

class ProductDetailController extends Controller
{

    public function products(Request $request)
    {
        if($request->has('category')){
            $categorySlug = str_replace('.html', '', $request->category);
            $category = Category::where('slug',$categorySlug)->first();

            $products = Product::where([
                'status' => 1,
                'category_id' => $category->id,
                'is_approved' => 1
            ])
                ->when($request->has('price_range'), function ($query) use ($request){
                    $price = explode(';',$request->price_range);
                    $from = reverseFormatNumber($price[0]);
                    $to = reverseFormatNumber($price[1]);

                    return $query->whereBetween('price', [$from, $to]);
                })
                ->paginate(12);

        }else if($request->has('sub-category')){
            $subCategorySlug = str_replace('.html', '', $request->get('sub-category'));
            $subCategory = SubCategory::where('slug',$subCategorySlug)->first();
            $products = Product::where([
                'status' => 1,
                'sub_category_id' => $subCategory->id,
                'is_approved' => 1
            ])
                ->when($request->has('price_range'), function ($query) use ($request){
                    $price = explode(';',$request->price_range);
                    $from = reverseFormatNumber($price[0]);
                    $to = reverseFormatNumber($price[1]);

                    return $query->whereBetween('price', [$from, $to]);
                })
                ->paginate(12);

        }else if ($request->has('child-category')){
            $childCategorySlug = str_replace('.html', '', $request->get('child-category'));
            $childCategory = ChildCategory::where('slug',$childCategorySlug)->first();
            $products = Product::where([
                'status' => 1,
                'child_category_id' => $childCategory->id,
                'is_approved' => 1
            ])
                ->when($request->has('price_range'), function ($query) use ($request){
                $price = explode(';',$request->price_range);
                $from = reverseFormatNumber($price[0]);
                $to = reverseFormatNumber($price[1]);

                    return $query->whereBetween('price', [$from, $to]);
            })
                ->paginate(12);

        }else if($request->has('brand')){
//            $brandSLug = str_replace('.html', '', $request->get('brand'));
            $brand = Brand::where('slug',$request->brand)->first();
            $products = Product::where([
                'status' => 1,
                'brand_id' => $brand->id,
                'is_approved' => 1
            ])
                ->when($request->has('price_range'), function ($query) use ($request){
                    $price = explode(';',$request->price_range);
                    $from = reverseFormatNumber($price[0]);
                    $to = reverseFormatNumber($price[1]);

                    return $query->whereBetween('price', [$from, $to]);
                })

            ->paginate(12);
        }else if ($request->has('search')) {
            $products = Product::where(['status' => 1, 'is_approved' => 1])
                ->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('full_description', 'like', '%' . $request->search . '%')
                        ->orWhereHas('category', function ($query) use ($request) {
                            $query->where('name', 'like', '%' . $request->search . '%')
//                                ->orWhere('full_description', 'like', '%' . $request->search . '%')
                            ;
                        });
                })
                ->when($request->has('price_range'), function ($query) use ($request) {
                    $price = explode(';', $request->price_range);
                    $from = reverseFormatNumber($price[0]);
                    $to = reverseFormatNumber($price[1]);

                    return $query->whereBetween('price', [$from, $to]);
                })
                ->paginate(12);
        }
        else{
            $products = Product::where([
                'status' => 1,
                'is_approved' => 1
            ])->orderBy('id','DESC')->paginate(12);
        }


        $categories = Category::where('status', 1)->get();
        $brands = Brand::where('status', 1)->get();

        $productPageBanner = Advertisement::where('key','product_page_banner' )->first();

        return view('frontend.pages.product',compact('products','categories', 'brands','productPageBanner',));
    }

    public function showProductDetail(string $slug)
    {
        $product = Product::with(['vendor','category','subCategory','productImageGalleries','variants', 'brand'])->where('slug',$slug)->where('status',1)->first();
        $reviews = ProductReview::where(['status' => 1, 'product_id' => $product?->id])->paginate(2);
        $relatedProducts = Product::with(['category', 'variants'])->where('slug','!=',$slug)->where('status',1)->where('category_id',$product->category_id)->take(6)->get();

        return view('frontend.pages.product-detail', compact('product','reviews', 'relatedProducts'));
    }

    public function buyProduct(Request $request)
    {
        $product = Product::find($request->product_id);

        //Check product quantity in stock
        if($product->quantity === 0){
           toastr()->error('Product stock out');
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



    public function changeListView(string $type)
    {
        \Session::put('type-view', $type);
//        if($type == 'list'){
//            return response()->json([
//                'type' => 'list',
//                'class' => 'active'
//            ]);
//        }else{
//            return response()->json([
//                'type' => 'gird',
//                'class' => 'active'
//            ]);
//        }
    }

}
