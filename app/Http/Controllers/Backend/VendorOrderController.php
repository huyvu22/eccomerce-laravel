<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;

class VendorOrderController extends Controller
{
    public function index(VendorOrderDataTable $dataTables)
    {
        return $dataTables->render('vendor.order.index');
    }

    public function show(Order $order)
    {

        return view('vendor.order.show', compact('order'));
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
