<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InsightController extends Controller
{
    public function index()
    {
        // Collect insights data from different tables
        $insights = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'products.name as product',
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue'),
                DB::raw('SUM(order_items.quantity * (order_items.price - products.cost)) as profit'), // Calculate profit
                DB::raw('SUM(order_items.quantity) as units_sold'),
                'orders.user_id' // Group by user_id instead of region
            )
            ->groupBy('products.name', 'orders.user_id')
            ->get();

        // Total sales
        $totalSales = DB::table('orders')
            ->sum(DB::raw('total'));

        // Orders today
        $ordersToday = DB::table('orders')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Top selling product
        $topSellingProduct = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('products.name')
            ->orderBy('total_quantity', 'desc')
            ->first();

        // Pending orders
        $pendingOrders = DB::table('orders')
            ->where('status', 'pending')
            ->count();

        // Pass the data to the view
        return view('admin.insight', compact('insights', 'totalSales', 'ordersToday', 'topSellingProduct', 'pendingOrders'));
    }
}