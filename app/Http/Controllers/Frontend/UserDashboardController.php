<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $totalOrder = Order::where('user_id', Auth::user()->id)->count();

        $pendingOrder = Order::where('user_id', Auth::user()->id)->where('order_status','pending')->count();

        $completeOrder = $totalOrder - $pendingOrder;

        $reviews = ProductReview::where('user_id', Auth::user()->id)->count();

        $wishlists = Wishlist::where('user_id', Auth::user()->id)->count();

        return view('frontend.dashboard.dashboard', compact('totalOrder','pendingOrder','completeOrder','reviews','wishlists'));
    }


}
