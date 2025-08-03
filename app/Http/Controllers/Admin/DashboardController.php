<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => \App\Models\Product::count(),
            'categories' => \App\Models\Category::count(),
            'orders' => \App\Models\Order::count(),
            'users' => \App\Models\User::count(),
        ];

        // Chiffre d'affaires (total des commandes payées)
        $stats['revenue'] = \App\Models\Order::whereHas('payment', function($q) {
            $q->where('status', 'payé');
        })->sum('total');

        // Suivi des paiements
        $stats['paid_orders'] = \App\Models\Order::whereHas('payment', function($q) {
            $q->where('status', 'payé');
        })->count();
        $stats['unpaid_orders'] = \App\Models\Order::whereHas('payment', function($q) {
            $q->where('status', 'non payé');
        })->count();

        // Produits les plus vendus (top 5)
        $stats['top_products'] = \App\Models\Product::select('products.*')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats'));
    }
}
