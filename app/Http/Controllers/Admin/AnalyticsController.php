<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnalyticsExport;

class AnalyticsController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_revenue' => Order::whereHas('payment', function($q) {
                $q->where('status', 'payé');
            })->sum('total'),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'conversion_rate' => $this->calculateConversionRate(),
            'paid_orders' => Order::whereHas('payment', function($q) {
                $q->where('status', 'payé');
            })->count(),
            'unpaid_orders' => Order::whereHas('payment', function($q) {
                $q->where('status', 'non payé');
            })->count(),
        ];

        // Top produits les plus vendus
        $stats['top_products'] = Product::select('products.id', 'products.name', 'products.price', 'products.category_id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.category_id')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        // Évolution des ventes par mois
        $stats['monthly_sales'] = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total_sales, COUNT(*) as order_count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Nouveaux utilisateurs par mois
        $stats['monthly_users'] = User::selectRaw('MONTH(created_at) as month, COUNT(*) as new_users')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Métriques avancées
        $advancedMetrics = [
            'customer_lifetime_value' => $this->calculateCustomerLifetimeValue(),
            'repeat_customer_rate' => $this->calculateRepeatCustomerRate(),
            'average_time_to_purchase' => $this->calculateAverageTimeToPurchase(),
            'geographic_distribution' => $this->getGeographicDistribution(),
            'top_performing_hours' => $this->getTopPerformingHours(),
        ];

        // Données pour les graphiques
        $chartData = [
            'top_products' => $stats['top_products'],
            'category_performance' => $this->getCategoryPerformance(),
            'sales_trend' => $this->getSalesTrend(),
            'user_growth' => $this->getUserGrowth(),
            'revenue_by_month' => $this->getRevenueByMonth(),
            'order_status_distribution' => $this->getOrderStatusDistribution(),
        ];

        return view('admin.analytics.dashboard', compact('stats', 'advancedMetrics', 'chartData'));
    }

    private function calculateConversionRate()
    {
        $totalVisitors = User::count() * 10; // Simulation
        $totalOrders = Order::count();
        return $totalVisitors > 0 ? round(($totalOrders / $totalVisitors) * 100, 2) : 0;
    }

    private function calculateCustomerLifetimeValue()
    {
        $avgOrderValue = Order::whereHas('payment', function($q) {
            $q->where('status', 'payé');
        })->avg('total') ?? 0;
        $avgOrdersPerCustomer = Order::whereHas('payment', function($q) {
            $q->where('status', 'payé');
        })->count() / max(User::count(), 1);
        
        return round($avgOrderValue * $avgOrdersPerCustomer, 2);
    }

    private function calculateRepeatCustomerRate()
    {
        $totalCustomers = User::count();
        $repeatCustomers = Order::select('user_id')
            ->groupBy('user_id')
            ->havingRaw('count(*) > 1')
            ->count();
        
        return $totalCustomers > 0 ? round(($repeatCustomers / $totalCustomers) * 100, 2) : 0;
    }

    private function calculateAverageTimeToPurchase()
    {
        // Simulation - en réalité, il faudrait tracker les sessions
        return rand(15, 45); // minutes
    }

    private function getGeographicDistribution()
    {
        // Simulation - en réalité, il faudrait des données géographiques
        return [
            ['region' => 'Abidjan', 'orders' => rand(50, 200)],
            ['region' => 'Bouaké', 'orders' => rand(20, 80)],
            ['region' => 'San-Pédro', 'orders' => rand(10, 50)],
            ['region' => 'Korhogó', 'orders' => rand(5, 30)],
            ['region' => 'Autres', 'orders' => rand(10, 40)],
        ];
    }

    private function getTopPerformingHours()
    {
        $hours = [];
        for ($i = 0; $i < 24; $i++) {
            $orders = Order::whereRaw('HOUR(created_at) = ?', [$i])->count();
            $hours[] = [
                'hour' => $i,
                'orders' => $orders,
            ];
        }
        
        return collect($hours)->sortByDesc('orders')->take(5)->values();
    }

    private function getCategoryPerformance()
    {
        return Category::withCount('products')->get()->map(function($category) {
            $revenue = Order::whereHas('payment', function($q) {
                $q->where('status', 'payé');
            })->whereHas('orderItems.product', function($q) use ($category) {
                $q->where('category_id', $category->id);
            })->sum('total');
            
            $category->total_revenue = $revenue;
            return $category;
        })->sortByDesc('total_revenue');
    }

    private function getSalesTrend()
    {
        $days = 30;
        $data = [];
        
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subDays($i);
            $revenue = Order::whereHas('payment', function($q) {
                $q->where('status', 'payé');
            })->whereDate('created_at', $date)->sum('total');
            
            $data[] = [
                'date' => $date->format('Y-m-d'),
                'revenue' => $revenue,
                'orders' => Order::whereDate('created_at', $date)->count(),
            ];
        }
        
        return $data;
    }

    private function getUserGrowth()
    {
        $months = 12;
        $data = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $users = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $data[] = [
                'month' => $date->format('Y-m'),
                'users' => $users,
            ];
        }
        
        return $data;
    }

    private function getRevenueByMonth()
    {
        $months = 12;
        $data = [];
        
        for ($i = $months - 1; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $revenue = Order::whereHas('payment', function($q) {
                $q->where('status', 'payé');
            })->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total');
            
            $data[] = [
                'month' => $date->format('Y-m'),
                'revenue' => $revenue,
            ];
        }
        
        return $data;
    }

    private function getOrderStatusDistribution()
    {
        return Order::select('status', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->status => $item->count];
            });
    }

    // Export PDF des analytics
    public function exportPdf()
    {
        $stats = [
            'total_revenue' => Order::whereHas('payment', function($q) {
                $q->where('status', 'payé');
            })->sum('total'),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'conversion_rate' => $this->calculateConversionRate(),
            'paid_orders' => Order::whereHas('payment', function($q) {
                $q->where('status', 'payé');
            })->count(),
            'unpaid_orders' => Order::whereHas('payment', function($q) {
                $q->where('status', 'non payé');
            })->count(),
        ];

        // Top produits
        $stats['top_products'] = Product::select('products.id', 'products.name', 'products.price', 'products.category_id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.category_id')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        // Évolution des ventes
        $stats['monthly_sales'] = Order::selectRaw('MONTH(created_at) as month, SUM(total) as total_sales, COUNT(*) as order_count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $pdf = PDF::loadView('admin.analytics.pdf', compact('stats'));
        
        return $pdf->download('analytics-eazystore-' . date('Y-m-d') . '.pdf');
    }

    // Export Excel des analytics
    public function exportExcel()
    {
        return Excel::download(new AnalyticsExport, 'analytics-eazystore-' . date('Y-m-d') . '.xlsx');
    }
} 