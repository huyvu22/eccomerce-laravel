<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use Carbon\Carbon;

class VendorController extends Controller
{
    public function dashboard()
    {
        $todayOrders = Order::whereDate('created_at',Carbon::today())->whereHas('orderProducts', function ($query){
            $query->where('vendor_id',\Auth::user()->vendor->id);
        })->count();

        $todayPendingOrders = Order::whereDate('created_at',Carbon::today())
            ->where('order_status', 'pending')
            ->whereHas('orderProducts', function ($query){
            $query->where('vendor_id',\Auth::user()->vendor->id);
        })->count();

        $totalOrders = Order::whereHas('orderProducts', function ($query){
            $query->where('vendor_id',\Auth::user()->vendor->id);
        })->count();

        $totalPendingOrders = Order::where('order_status', 'pending')->whereHas('orderProducts', function ($query){
            $query->where('vendor_id',\Auth::user()->vendor->id);
        })->count();

        $totalCompleteOrders = Order::where('order_status', 'delivered')->whereHas('orderProducts', function ($query){
            $query->where('vendor_id',\Auth::user()->vendor->id);
        })->count();

       $totalProducts = Product::where('vendor_id',\Auth::user()->vendor->id)->count();

       $todayEarnings = Order::whereDate('created_at',Carbon::today())
           ->where('payment_status', 1)
           ->where('order_status', 'delivered')
           ->whereHas('orderProducts', function ($query){
           $query->where('vendor_id',\Auth::user()->vendor->id);
       })->sum('sub_total');

        $monthEarnings = Order::whereMonth('created_at',Carbon::now()->month)
            ->where('payment_status', 1)
            ->where('order_status', 'delivered')
            ->whereHas('orderProducts', function ($query){
            $query->where('vendor_id',\Auth::user()->vendor->id);
        })->sum('sub_total');

        $yearEarnings = Order::whereYear('created_at',Carbon::now()->year)
            ->where('payment_status', 1)
            ->where('order_status', 'delivered')
            ->whereHas('orderProducts', function ($query){
                $query->where('vendor_id',\Auth::user()->vendor->id);
        })->sum('sub_total');

        $totalEarnings = Order::where('order_status', 'delivered')
            ->whereHas('orderProducts', function ($query){
                $query->where('vendor_id',\Auth::user()->vendor->id);
        })->sum('sub_total');

        $totalReviews = ProductReview::whereHas('product', function ($query){
            $query->where('vendor_id',\Auth::user()->vendor->id);
        })->count();


        return view('vendor.dashboard.dashboard',
            compact('todayOrders',
                'todayPendingOrders',
                'totalOrders',
                'totalPendingOrders',
                'totalCompleteOrders',
                'totalProducts',
                'todayEarnings',
                'monthEarnings',
                'yearEarnings',
                'totalEarnings',
                'totalReviews'
            )
        );
    }
}
