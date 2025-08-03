<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AnalyticsExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Résumé' => new AnalyticsSummarySheet(),
            'Ventes par mois' => new MonthlySalesSheet(),
            'Top produits' => new TopProductsSheet(),
            'Utilisateurs' => new UsersSheet(),
            'Catégories' => new CategoriesSheet(),
        ];
    }
}

class AnalyticsSummarySheet implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        $data = [
            [
                'Métrique' => 'Chiffre d\'affaires total',
                'Valeur' => number_format(Order::whereHas('payment', function($q) {
                    $q->where('status', 'payé');
                })->sum('total'), 0, ',', ' ') . ' FCFA',
            ],
            [
                'Métrique' => 'Total commandes',
                'Valeur' => Order::count(),
            ],
            [
                'Métrique' => 'Total utilisateurs',
                'Valeur' => User::count(),
            ],
            [
                'Métrique' => 'Total produits',
                'Valeur' => Product::count(),
            ],
            [
                'Métrique' => 'Total catégories',
                'Valeur' => Category::count(),
            ],
            [
                'Métrique' => 'Commandes payées',
                'Valeur' => Order::whereHas('payment', function($q) {
                    $q->where('status', 'payé');
                })->count(),
            ],
            [
                'Métrique' => 'Commandes en attente',
                'Valeur' => Order::whereHas('payment', function($q) {
                    $q->where('status', 'non payé');
                })->count(),
            ],
        ];

        return collect($data);
    }

    public function headings(): array
    {
        return ['Métrique', 'Valeur'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '667EEA']]],
        ];
    }
}

class MonthlySalesSheet implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Order::selectRaw('MONTH(created_at) as month, SUM(total) as total_sales, COUNT(*) as order_count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public function headings(): array
    {
        return ['Mois', 'Ventes (FCFA)', 'Nombre de Commandes', 'Panier Moyen'];
    }

    public function map($sale): array
    {
        $months = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
            5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];
        
        $avgCart = $sale->order_count > 0 ? $sale->total_sales / $sale->order_count : 0;
        
        return [
            $months[$sale->month] ?? $sale->month,
            number_format($sale->total_sales, 0, ',', ' ') . ' FCFA',
            $sale->order_count,
            number_format($avgCart, 0, ',', ' ') . ' FCFA',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '28A745']]],
        ];
    }
}

class TopProductsSheet implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Product::select('products.id', 'products.name', 'products.price', 'products.category_id')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.category_id')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();
    }

    public function headings(): array
    {
        return ['Rang', 'Produit', 'Prix', 'Quantité Vendue', 'Revenus Générés'];
    }

    public function map($product): array
    {
        static $rank = 0;
        $rank++;
        
        return [
            '#' . $rank,
            $product->name,
            number_format($product->price, 0, ',', ' ') . ' FCFA',
            $product->total_sold ?? 0,
            number_format(($product->price * ($product->total_sold ?? 0)), 0, ',', ' ') . ' FCFA',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'color' => ['rgb' => 'DC3545']]],
        ];
    }
}

class UsersSheet implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return User::select('id', 'name', 'email', 'created_at', 'is_admin')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nom', 'Email', 'Date d\'inscription', 'Admin'];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->created_at->format('d/m/Y H:i'),
            $user->is_admin ? 'Oui' : 'Non',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '6C757D']]],
        ];
    }
}

class CategoriesSheet implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Category::select('id', 'name', 'description', 'created_at')
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return ['ID', 'Nom', 'Description', 'Date de création'];
    }

    public function map($category): array
    {
        return [
            $category->id,
            $category->name,
            $category->description ?? 'Aucune description',
            $category->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'color' => ['rgb' => 'FFC107']]],
        ];
    }
} 