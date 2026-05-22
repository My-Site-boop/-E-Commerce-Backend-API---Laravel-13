<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::sum('total_amount'),

            'low_stock_products' => Product::where('stock_quantity', '<=', 5)
                ->select('id', 'name', 'stock_quantity')
                ->get(),

            'active_categories' => Category::where('status', 1)->count(),

            'latest_orders' => OrderResource::collection(
                Order::with(['user', 'items.product'])
                    ->latest()
                    ->take(5)
                    ->get()
            ),
        ];

        return ApiResponse::success('Dashboard Data', $data);
    }
}