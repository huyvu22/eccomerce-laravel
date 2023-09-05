<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SellerPendingProductsDataTable;
use App\DataTables\SellerProductsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;

class SellerProductController extends Controller
{
   public function index(SellerProductsDataTable $dataTable)
   {
       return $dataTable->render('admin.product.seller-product.index');
   }

    public function pending(SellerPendingProductsDataTable $dataTable)
    {
        return $dataTable->render('admin.product.seller-pending-product.index');
    }

    public function updateApprove( $productId, $approved)
    {
        $product = Product::find($productId);
        $product->is_approved = $approved;
        $product->save();
        toastr()->success('Approve Updated successfully');
        return response(
            [
                'status' => '200',
                'message' =>'Updated Successfully'
            ]
        );
    }

}
