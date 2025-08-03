<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserAnalyticsController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        // Statistiques personnelles
        $stats = [
            'total_orders' => $user->orders()->count(),
            'total_spent' => $user->orders()->sum('total'),
            'average_order' => $user->orders()->avg('total') ?? 0,
            'favorite_category' => $this->getFavoriteCategory($user),
            'last_order_date' => $user->orders()->latest()->first()?->created_at,
            'orders_this_month' => $user->orders()->whereMonth('created_at', now()->month)->count(),
            'spent_this_month' => $user->orders()->whereMonth('created_at', now()->month)->sum('total'),
        ];

        // Graphiques de tendances d'achat (6 derniers mois)
        $purchaseTrends = $this->getPurchaseTrends($user);
        
        // Produits les plus achetés par l'utilisateur
        $topProducts = $this->getTopProducts($user);
        
        // Recommandations personnalisées
        $recommendations = $this->getPersonalizedRecommendations($user);
        
        // Historique détaillé des commandes
        $recentOrders = $user->orders()->with(['items.product'])->latest()->take(5)->get();
        
        // Statistiques par catégorie
        $categoryStats = $this->getCategoryStats($user);
        
        // Évolution des dépenses
        $spendingEvolution = $this->getSpendingEvolution($user);

        return view('user.analytics.dashboard', compact(
            'stats', 
            'purchaseTrends', 
            'topProducts', 
            'recommendations', 
            'recentOrders',
            'categoryStats',
            'spendingEvolution'
        ));
    }

    private function getPurchaseTrends($user)
    {
        $trends = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $orders = $user->orders()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->get();
            
            $trends[] = [
                'month' => $date->format('M Y'),
                'orders_count' => $orders->count(),
                'total_spent' => $orders->sum('total'),
                'average_order' => $orders->avg('total') ?? 0
            ];
        }
        
        return $trends;
    }

    private function getTopProducts($user)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.user_id', $user->id)
            ->select('products.name', 'products.image', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();
    }

    private function getPersonalizedRecommendations($user)
    {
        // Basé sur les catégories préférées
        $favoriteCategories = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.user_id', $user->id)
            ->select('products.category_id', DB::raw('COUNT(*) as purchase_count'))
            ->groupBy('products.category_id')
            ->orderByDesc('purchase_count')
            ->limit(3)
            ->pluck('category_id');

        return Product::whereIn('category_id', $favoriteCategories)
            ->whereNotIn('id', $user->orders()->with('items')->get()->flatMap->items->pluck('product_id'))
            ->inRandomOrder()
            ->limit(4)
            ->get();
    }

    private function getFavoriteCategory($user)
    {
        $category = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.user_id', $user->id)
            ->select('categories.name', DB::raw('COUNT(*) as purchase_count'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('purchase_count')
            ->first();

        return $category ? $category->name : 'Aucune préférence';
    }

    private function getCategoryStats($user)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.user_id', $user->id)
            ->select(
                'categories.name',
                DB::raw('COUNT(DISTINCT orders.id) as orders_count'),
                DB::raw('SUM(order_items.quantity) as total_items'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_spent')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_spent')
            ->get();
    }

    private function getSpendingEvolution($user)
    {
        $evolution = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $total = $user->orders()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total');
            
            $evolution[] = [
                'month' => $date->format('M'),
                'total' => $total
            ];
        }
        
        return $evolution;
    }

    public function exportData()
    {
        $user = auth()->user();
        $orders = $user->orders()->with(['items.product'])->get();
        
        $data = [
            'user_info' => [
                'name' => $user->name,
                'email' => $user->email,
                'member_since' => $user->created_at->format('d/m/Y')
            ],
            'orders' => $orders->map(function($order) {
                return [
                    'order_id' => $order->id,
                    'date' => $order->created_at->format('d/m/Y'),
                    'status' => $order->status,
                    'total' => $order->total,
                    'items' => $order->items->map(function($item) {
                        return [
                            'product' => $item->product->name,
                            'quantity' => $item->quantity,
                            'price' => $item->price
                        ];
                    })
                ];
            })
        ];
        
        return response()->json($data);
    }
} 