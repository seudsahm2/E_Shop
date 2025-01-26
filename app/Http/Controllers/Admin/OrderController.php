<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->get();
        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        $order->save();

        $totalOrders = Order::count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $canceledOrders = Order::where('status', 'canceled')->count();

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully.',
            'totalOrders' => $totalOrders,
            'shippedOrders' => $shippedOrders,
            'deliveredOrders' => $deliveredOrders,
            'canceledOrders' => $canceledOrders,
        ]);
    }
    public function show($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        return view('admin.order', compact('order'));
    }
}
