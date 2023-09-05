<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\NewsletterSubscrible;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $todayOrders = Order::whereDate('created_at',Carbon::today())->count();

        $todayPendingOrders = Order::whereDate('created_at',Carbon::today())
            ->where('order_status', 'pending')
            ->count();

        $totalOrders = Order::count();

        $totalPendingOrders = Order::where('order_status', 'pending')->count();

        $totalCancelOrders = Order::where('order_status', 'canceled')->count();

        $totalDeliveredOrders = Order::where('order_status', 'delivered')->count();

        $todayEarnings = Order::whereDate('created_at',Carbon::today())->where('order_status','!=', 'canceled')->where('payment_status', 1)->sum('sub_total');

        $monthEarnings = Order::whereMonth('created_at',Carbon::now()->month)->where('order_status','!=', 'canceled')->where('payment_status', 1)->sum('sub_total');

        $yearEarnings = Order::whereYear('created_at',Carbon::now()->year)->where('order_status','!=', 'canceled')->where('payment_status', 1)->sum('sub_total');

        $totalBrands = Brand::count();

        $totalReviews = ProductReview::count();

        $totalBlogs = Blog::count();

        $totalProducts = Product::count();

        $totalCategories = Category::count();

        $totalSubscribers = NewsletterSubscrible::count();

        $totalVendors = Vendor::count();

        $totalUsers = User::where('role','user')->count();

        return view('admin.dashboard', compact(
            'todayOrders',
            'todayPendingOrders',
                'totalOrders',
                'totalPendingOrders',
                'totalCancelOrders',
                'totalDeliveredOrders',
                'todayEarnings',
                'monthEarnings',
                'yearEarnings',
                'totalReviews',
                'totalProducts',
                'totalBlogs',
                'totalBrands',
                'totalCategories',
                'totalSubscribers',
                'totalVendors',
                'totalUsers'
            )
        );
    }

    public function login()
    {
        return view('admin.auth.login');
    }

    public function logout()
    {
        return view('admin.auth.login');
    }
}
