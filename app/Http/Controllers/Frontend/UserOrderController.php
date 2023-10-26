<?php

namespace App\Http\Controllers\Frontend;

use App\DataTables\UserOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;

class UserOrderController extends Controller
{
    public function index(UserOrderDataTable $dataTable)
    {
        return $dataTable->render('frontend.dashboard.order.index');
    }

    public function show(Order $order)
    {
        return view('frontend.dashboard.order.show', compact('order'));
    }

    public function getOrderStatus( $id, $status)
    {
        $order = Order::find($id);
        $order->order_status = $status;
        $order->save();
        return response([
            'status' => $status,
            'message' => 'Cập nhật trạng thái đơn hàng thành công'
        ]);
    }
}
