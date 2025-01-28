<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('min_price')) {
            $query->where('total', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('total', '<=', $request->max_price);
        }

        if ($request->filled('min_quantity') || $request->filled('max_quantity')) {
            $query->whereHas('items', function ($q) use ($request) {
                if ($request->filled('min_quantity')) {
                    $q->havingRaw('SUM(quantity) >= ?', [$request->min_quantity]);
                }
                if ($request->filled('max_quantity')) {
                    $q->havingRaw('SUM(quantity) <= ?', [$request->max_quantity]);
                }
            });
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->get();

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

        // Recalculate the order count based on the current filter criteria
        $query = Order::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('min_price')) {
            $query->where('total', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('total', '<=', $request->max_price);
        }

        if ($request->filled('min_quantity') || $request->filled('max_quantity')) {
            $query->whereHas('items', function ($q) use ($request) {
                if ($request->filled('min_quantity')) {
                    $q->havingRaw('SUM(quantity) >= ?', [$request->min_quantity]);
                }
                if ($request->filled('max_quantity')) {
                    $q->havingRaw('SUM(quantity) <= ?', [$request->max_quantity]);
                }
            });
        }
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

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
