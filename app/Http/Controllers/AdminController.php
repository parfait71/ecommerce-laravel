<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
            'users' => User::count(),
            'revenue' => Order::where('payment_status', 'payé')->sum('total'),
            'paid_orders' => Order::where('payment_status', 'payé')->count(),
            'unpaid_orders' => Order::where('payment_status', 'non payé')->count(),
            'top_products' => Product::select('name', DB::raw('SUM(order_items.quantity) as total_sold'))
                ->join('order_items', 'products.id', '=', 'order_items.product_id')
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_sold')
                ->limit(5)
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
