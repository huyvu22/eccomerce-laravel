<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductVariantDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class VendorProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,VendorProductVariantDataTable $dataTable)
    {
        $product = Product::find($request->product);

        if($product->vendor_id !== \Auth::user()->vendor->id){
            abort(404);
        }
        return $dataTable->render('vendor.product.product-variant.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendor.product.product-variant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name'=>'required|max:200',
                'product'=>'required',
                'status'=>'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute không được vượt quá :max ký tự',
            ],
            [
                'name'=>'Tên',
                'status'=>'Trạng thái'
            ]

        );

        $variant = new ProductVariant();
        $variant->product_id = $request->product;
        $variant->name = $request->name;
        $variant->status = $request->status;
        $variant->save();
        toastr()->success('Tạo mới thành công');
        return redirect()->route('vendor.products-variant.index',['product'=>$request->product]);
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
       if($products_variant->product->vendor_id !== \Auth::user()->vendor->id){
           abort(404);
       }
        return view('vendor.product.product-variant.edit', compact('products_variant'));
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

        if($products_variant->product->vendor_id !== \Auth::user()->vendor->id){
            abort(404);
        }

        if ($request->has('switch_status')) {
            $products_variant->status = $request->switch_status;
            $products_variant->save();
            return response(['message' =>'Cập nhật trạng thái thành công']);
        } else {
            $products_variant->name = $request->name;
            $products_variant->status = $request->status;
            $products_variant->save();
            toastr()->success('Create successfully');
            return redirect()->route('vendor.products-variant.index',['product'=>$products_variant->product_id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $products_variant)
    {
        if($products_variant->product->vendor_id !== \Auth::user()->vendor->id){
            abort(404);
        }

        $variantItems = $products_variant->variantItems;
        if($variantItems->count() > 0){
            toastr()->error('Không thể xóa, vì vẫn còn thuộc tính con');
        }else {
            $products_variant->delete();
            toastr()->success('Xóa thành công');
        }
        return redirect()->back();
    }
}
