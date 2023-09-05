<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,ProductVariantDataTable $dataTable)
    {
        $product = Product::find($request->product);
       return $dataTable->render('admin.product.product-variant.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.product-variant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
           'name'=>'required|max:200',
           'product'=>'required|integer:',
           'status'=>'required'
       ]);

       $variant = new ProductVariant();
       $variant->product_id = $request->product;
       $variant->name = $request->name;
       $variant->status = $request->status;
       $variant->save();
       toastr()->success('Create successfully');
       return redirect()->route('admin.products-variant.index',['product'=>$request->product]);

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
    public function edit(ProductVariant $products_variant)
    {
        return view('admin.product.product-variant.edit', compact('products_variant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,ProductVariant $products_variant)
    {
        if (!$request->has('switch_status')) {
            $request->validate([
                'name'=>'required|max:200',
                'status'=>'required'
            ]);
        }

        if ($request->has('switch_status')) {
            $products_variant->status = $request->switch_status;
            $products_variant->save();
            return response(['message' =>'Status has been updated!']);
        } else {
            $products_variant->name = $request->name;
            $products_variant->status = $request->status;
            $products_variant->save();
            toastr()->success('Create successfully');
            return redirect()->route('admin.products-variant.index',['product'=>$products_variant->product_id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $products_variant)
    {
        $variantItems = $products_variant->variantItems;
        if($variantItems->count() > 0){
            toastr()->error('Delete failed, because there are more than one variant items');
        }else {
            $products_variant->delete();
            toastr()->success('Delete successfully');
        }
        return redirect()->back();
    }
}
