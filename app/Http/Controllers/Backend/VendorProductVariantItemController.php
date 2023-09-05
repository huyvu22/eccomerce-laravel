<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductVariantItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantItem;
use Illuminate\Http\Request;

class VendorProductVariantItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(VendorProductVariantItemDataTable $dataTable, $productId, $variantId)
    {
        $product = Product::find($productId);
        $variant = ProductVariant::find($variantId);

        if($product->id !== $variant->product_id){
            abort(404);
        }
        return $dataTable->render('vendor.product.product-variant-item.index', compact('variant', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $productId,string $variantId)
    {
        $product = Product::find($productId);
        $variant = ProductVariant::find($variantId);
        return view('vendor.product.product-variant-item.create', compact('product','variant'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
        return redirect()->route('vendor.products-variant-item.index',['productId'=>$request->product_id,'variantId'=>$request->variant_id]);
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
    public function edit(ProductVariantItem $variantItem)
    {
        if($variantItem->product_variant_id !== $variantItem->variant->id){
            abort(404);
        }

        return view('vendor.product.product-variant-item.edit',compact('variantItem'));
    }

    /**
     * Update the specified resource in storage.
     */
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
            return redirect()->route('vendor.products-variant-item.index',['productId'=>$variantItem->variant->product_id,'variantId'=>$variantItem->product_variant_id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariantItem $variantItem)
    {
        $variantItem->delete();
        toastr()->success('Delete successfully');
        return redirect()->back();
    }
}
