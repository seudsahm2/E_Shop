<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Sale::sum('amount');
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $totalProducts = Product::count();

        // Fetch sales data for the chart with month names
        $salesData = Sale::select(
            DB::raw('DATE_FORMAT(created_at, "%M") as month'), // Full month names
            DB::raw('SUM(amount) as total')
        )->groupBy('month')->orderByRaw('MIN(created_at)')->get()->pluck('total', 'month')->toArray();

        $salesChartData = [
            'labels' => array_keys($salesData) ?: ['No Data'], // Default to 'No Data' if empty
            'data' => array_values($salesData) ?: [0]
        ];

        // Fetch orders data for the chart with all days of the week
        $ordersData = Order::select(
            DB::raw('DAYNAME(created_at) as day'),
            DB::raw('COUNT(*) as total')
        )->groupBy('day')
            ->orderByRaw('FIELD(day, "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday")') // Preserve order of days
            ->get()->pluck('total', 'day')->toArray();

        $ordersChartData = [
            'labels' => array_keys($ordersData) ?: ['No Data'],
            'data' => array_values($ordersData) ?: [0]
        ];

        // Fetch pie chart data with product names
        $pieData = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.name as product',
                DB::raw('SUM(order_items.quantity) as total')
            )->groupBy('products.name')->get()->pluck('total', 'product')->toArray();

        $pieChartData = [
            'labels' => array_keys($pieData) ?: ['No Data'],
            'data' => array_values($pieData) ?: [0]
        ];

        // Fetch user growth data with month names
        $growthData = User::select(
            DB::raw('DATE_FORMAT(created_at, "%M") as month'), // Full month names
            DB::raw('COUNT(*) as total')
        )->groupBy('month')->orderByRaw('MIN(created_at)')->get()->pluck('total', 'month')->toArray();

        $growthChartData = [
            'labels' => array_keys($growthData) ?: ['No Data'],
            'data' => array_values($growthData) ?: [0]
        ];

        return view('admin.dashboard', compact(
            'totalSales',
            'totalOrders',
            'totalUsers',
            'totalProducts',
            'salesChartData',
            'ordersChartData',
            'pieChartData',
            'growthChartData'
        ));
    }
}
