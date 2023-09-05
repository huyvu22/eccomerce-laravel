<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    public function index()
    {
        $flashSaleItems = FlashSaleItem::where('status',1)->orderBy('id','ASC')->paginate(10);
        $flashSaleDate = FlashSale::first();
        return view('frontend.pages.flash-sale', compact('flashSaleItems', 'flashSaleDate'));
    }
}
