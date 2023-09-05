<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductTractController extends Controller
{
    public function index()
    {
        $orderId = session('tracked_order_id');
        $order = Order::where('id', $orderId)->first();
        return view('frontend.pages.product-tract', compact('order'));
    }

    public function tract(Request $request)
    {
        $request->validate([
            'track_id' => 'required',
        ]);

        $order = Order::where('invoice_id', $request->track_id)->first();

        if (!$order) {
            return redirect()->back()->withErrors(['track_id' => 'Order not found']);
        }

        // Store the order in the session
        return redirect()->route('product-tract.index')->with('tracked_order_id', $order->id);
    }
}
