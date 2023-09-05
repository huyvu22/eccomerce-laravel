<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;

class ProductVariantItemController extends Controller
{
    public function index(ProductVariantItemDataTable $dataTable, $productId, $variantId)
    {
        $product = Product::find($productId);
        $variant = ProductVariant::find($variantId);
        return $dataTable->render('admin.product.product-variant-item.index', compact('variant', 'product'));
    }

    public function create(string $productId,string $variantId)
    {
        $product = Product::find($productId);
        $variant = ProductVariant::find($variantId);
        return view('admin.product.product-variant-item.create', compact('product','variant'));
    }

    public function store(Request $request)
    {
       $request->validate([
           'variant_id' => 'required|integer',
           'item_name' => 'required|max:200',
           'price' => 'required|integer',
           'is_default' => 'required',
           'status' => 'required'
       ]);

       $variantItem = new ProductVariantItem();
       $variantItem->product_variant_id = $request->variant_id;
       $variantItem->name = $request->item_name;
       $variantItem->price = $request->price;
       $variantItem->is_default = $request->is_default;
       $variantItem->status = $request->status;
       $variantItem->save();
       toastr()->success('Created successfully');
       return redirect()->route('admin.products-variant-item.index',['productId'=>$request->product_id,'variantId'=>$request->variant_id]);
    }

    public function edit(ProductVariantItem $variantItem)
    {
        return view('admin.product.product-variant-item.edit',compact('variantItem'));
    }

    public function update(Request $request,ProductVariantItem $variantItem)
    {
        if (!$request->has('switch_status')) {
            $request->validate([
                'item_name' => 'required|max:200',
                'price' => 'required|integer',
                'is_default' => 'required',
                'status' => 'required'
            ]);
        }
        if ($request->has('switch_status')) {
            $variantItem->status = $request->switch_status;
            $variantItem->save();
            return response(['message' =>'Status has been updated!']);
        } else {

            $variantItem->name = $request->item_name;
            $variantItem->price = $request->price;
            $variantItem->is_default = $request->is_default;
            $variantItem->status = $request->status;
            $variantItem->save();
            toastr()->success('Created successfully');
            return redirect()->route('admin.products-variant-item.index',['productId'=>$variantItem->variant->product_id,'variantId'=>$variantItem->product_variant_id]);
        }

    }

    public function destroy(ProductVariantItem $variantItem)
    {
        $variantItem->delete();
        toastr()->success('Delete successfully');
        return redirect()->back();
    }
}
