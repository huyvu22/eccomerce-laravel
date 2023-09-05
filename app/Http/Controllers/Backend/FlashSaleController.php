<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FlashSaleItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index(FlashSaleItemDataTable $dataTable)
    {
        $flashSaleDate = FlashSale::first();
        $products = Product::where('is_approved',1)->where('status',1)->latest('id')->get();
        return $dataTable->render('admin.flash-sale.index', compact('flashSaleDate','products'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'end_date' =>'required'
        ]);

        FlashSale::updateOrCreate(
            ['id'=>5],
            ['end_date' => $request->end_date]
        );
        toastr()->success('Updated Successfully');
        return redirect()->back();
    }

    public function addProduct(Request $request)
    {
        $flashSaleItem = new FlashSaleItem();
        $flashSaleDate = FlashSale::first();

        $request->validate([
            'product' => 'required|unique:flash_sale_items,product_id',
            'show_at_home' => 'required',
            'status' => 'required'
        ],
            ['unique' => 'The product is already added in flash sale!']
        );

        $flashSaleItem->product_id = $request->product;
        $flashSaleItem->flash_sale_id = $flashSaleDate->id;
        $flashSaleItem->show_at_home = $request->show_at_home;
        $flashSaleItem->status = $request->status;

        $flashSaleItem->save();
        toastr()->success('Product Added Successfully');
        return redirect()->back();
    }
    public function switchStatus(Request $request, FlashSaleItem $flashSaleItem)
    {
        $flashSaleItem->status = $request->switch_status;
        $flashSaleItem->save();
        return response(['message' =>'Status has been updated!']);
    }
    public function switchShowAtHome(Request $request, FlashSaleItem $flashSaleItem)
    {
        $flashSaleItem->show_at_home = $request->switch_status;
        $flashSaleItem->save();
        return response(['message' =>'Show at Homepage has been updated!']);
    }

    public function destroy(FlashSaleItem $flashSaleItem)
    {
      $flashSaleItem->delete();
      toastr()->success('Deleted Successfully');
      return redirect()->back();
    }

}
