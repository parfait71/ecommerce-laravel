@extends('layouts.app')

@section('header')
    <div class="text-center" data-aos="fade-up">
        <h1 class="display-5 fw-bold mb-3">
            <i class="fas fa-chart-line me-3"></i>Mon Tableau de Bord
        </h1>
        <p class="lead mb-0">Analysez vos habitudes d'achat et découvrez des recommandations personnalisées</p>
    </div>
@endsection

@section('content')
    <style>
    /* Forcer le fond clair sur toutes les cartes du dashboard utilisateur */
    .card-modern,
    .stats-card,
    .product-card,
    .card-body {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%) !important;
        color: #2c3e50 !important;
        border: 1px solid #e9ecef !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
        border-radius: 16px !important;
    }

    .card-modern *,
    .stats-card *,
    .product-card *,
    .card-body * {
        color: inherit !important;
    }

    /* Styles spécifiques pour les cartes de statistiques */
    .stats-card {
        text-align: center;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12) !important;
    }

    .stats-card i {
        color: #667eea !important;
    }

    .stats-card h4 {
        color: #2c3e50 !important;
        font-weight: 700;
    }

    .stats-card p {
        color: #495057 !important;
    }

    /* Styles pour les sous-cartes */
    .bg-light {
        background: #f8f9fa !important;
        border: 1px solid #e9ecef !important;
        border-radius: 12px !important;
    }

    /* Styles pour les tableaux */
    .table {
        background: white !important;
        border-radius: 12px !important;
        overflow: hidden;
    }

    .table thead th {
        background: #f8f9fa !important;
        color: #2c3e50 !important;
        border-bottom: 1px solid #e9ecef !important;
    }

    .table tbody td {
        color: #495057 !important;
        border-bottom: 1px solid #e9ecef !important;
    }

    /* Styles pour les boutons */
    .btn-outline-primary {
        border-color: #667eea !important;
        color: #667eea !important;
    }

    .btn-outline-primary:hover {
        background: #667eea !important;
        color: white !important;
    }

    .btn-outline-success {
        border-color: #28a745 !important;
        color: #28a745 !important;
    }

    .btn-outline-success:hover {
        background: #28a745 !important;
        color: white !important;
    }

    /* Styles pour les badges */
    .badge {
        border-radius: 20px !important;
        padding: 0.5rem 1rem !important;
        font-weight: 600 !important;
    }

    /* Styles pour les icônes dans les états vides */
    .text-muted {
        color: #6c757d !important;
    }

    .fa-3x {
        color: #adb5bd !important;
    }
    </style>
    <!-- Statistiques personnelles -->
    <div class="row g-4 mb-5">
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
            <div class="stats-card">
                <i class="fas fa-shopping-cart fa-2x mb-3 text-primary"></i>
                <h4 class="fw-bold">{{ $stats['total_orders'] }}</h4>
                <p class="mb-0">Total commandes</p>
            </div>
        </div>
        
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
            <div class="stats-card">
                <i class="fas fa-money-bill-wave fa-2x mb-3 text-success"></i>
                <h4 class="fw-bold">{{ number_format($stats['total_spent'], 0, ',', ' ') }} FCFA</h4>
                <p class="mb-0">Total dépensé</p>
            </div>
        </div>
        
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
            <div class="stats-card">
                <i class="fas fa-chart-bar fa-2x mb-3 text-warning"></i>
                <h4 class="fw-bold">{{ number_format($stats['average_order'], 0, ',', ' ') }} FCFA</h4>
                <p class="mb-0">Panier moyen</p>
            </div>
        </div>
        
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
            <div class="stats-card">
                <i class="fas fa-tags fa-2x mb-3 text-info"></i>
                <h4 class="fw-bold">{{ $stats['favorite_category'] }}</h4>
                <p class="mb-0">Catégorie préférée</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Graphique des tendances d'achat -->
        <div class="col-lg-8" data-aos="fade-up">
            <div class="card-modern p-4">
                <h4 class="fw-bold mb-4">
                    <i class="fas fa-chart-line me-2"></i>Évolution des achats (6 derniers mois)
                </h4>
                <canvas id="purchaseTrendsChart" height="100"></canvas>
            </div>
        </div>

        <!-- Statistiques du mois -->
        <div class="col-lg-4" data-aos="fade-left">
            <div class="card-modern p-4">
                <h4 class="fw-bold mb-4">
                    <i class="fas fa-calendar-alt me-2"></i>Ce mois-ci
                </h4>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="text-center p-3 bg-light rounded">
                            <h5 class="fw-bold text-primary">{{ $stats['orders_this_month'] }}</h5>
                            <small class="text-muted">Commandes</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center p-3 bg-light rounded">
                            <h5 class="fw-bold text-success">{{ number_format($stats['spent_this_month'], 0, ',', ' ') }} FCFA</h5>
                            <small class="text-muted">Dépensé</small>
                        </div>
                    </div>
                </div>
                
                @if($stats['last_order_date'])
                <div class="mt-4 p-3 bg-light rounded">
                    <h6 class="fw-bold mb-2">Dernière commande</h6>
                    <p class="mb-0 text-muted">{{ $stats['last_order_date']->format('d/m/Y à H:i') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <!-- Produits les plus achetés -->
        <div class="col-lg-6" data-aos="fade-up">
            <div class="card-modern p-4">
                <h4 class="fw-bold mb-4">
                    <i class="fas fa-star me-2"></i>Mes produits préférés
                </h4>
                @if($topProducts->count() > 0)
                    <div class="row g-3">
                        @foreach($topProducts as $product)
                        <div class="col-6">
                            <div class="d-flex align-items-center p-3 border rounded">
                                <img src="{{ asset('images/products/' . ($product->image ?? 'default.jpg')) }}" 
                                     alt="{{ $product->name }}" 
                                     class="rounded me-3" 
                                     style="width: 50px; height: 50px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">{{ $product->name }}</h6>
                                    <small class="text-muted">{{ $product->total_quantity }} acheté(s)</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucun produit acheté pour le moment</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Statistiques par catégorie -->
        <div class="col-lg-6" data-aos="fade-up">
            <div class="card-modern p-4">
                <h4 class="fw-bold mb-4">
                    <i class="fas fa-chart-pie me-2"></i>Dépenses par catégorie
                </h4>
                @if($categoryStats->count() > 0)
                    <canvas id="categoryChart" height="200"></canvas>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucune donnée disponible</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recommandations personnalisées -->
    <div class="row g-4 mt-4">
        <div class="col-12" data-aos="fade-up">
            <div class="card-modern p-4">
                <h4 class="fw-bold mb-4">
                    <i class="fas fa-lightbulb me-2"></i>Recommandations personnalisées
                </h4>
                @if($recommendations->count() > 0)
                    <div class="row g-4">
                        @foreach($recommendations as $product)
                        <div class="col-md-3">
                            <div class="card-modern h-100 product-card">
                                <img src="{{ asset('images/products/' . ($product->image ?? 'default.jpg')) }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}"
                                     style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="fw-bold">{{ $product->name }}</h6>
                                    <p class="text-success fw-bold">{{ number_format($product->price, 0, ',', ' ') }} FCFA</p>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>Voir détails
                                        </a>
                                        <button class="btn btn-sm btn-primary add-to-cart-recommended" 
                                                data-product-id="{{ $product->id }}">
                                            <i class="fas fa-cart-plus me-1"></i>Ajouter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-lightbulb fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Pas encore assez de données pour des recommandations</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Historique récent des commandes -->
    <div class="row g-4 mt-4">
        <div class="col-12" data-aos="fade-up">
            <div class="card-modern p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">
                        <i class="fas fa-history me-2"></i>Commandes récentes
                    </h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary btn-sm">
                            Voir tout l'historique
                        </a>
                        <a href="{{ route('analytics.export-page') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-download me-1"></i>Exporter mes données
                        </a>
                    </div>
                </div>
                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Commande</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>
                                        <strong>#{{ $order->id }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $order->items->count() }} article(s)</small>
                                    </td>
                                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status === 'en attente' ? 'warning' : ($order->status === 'confirmé' ? 'success' : ($order->status === 'livré' ? 'info' : 'danger')) }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="fw-bold">{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-history fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucune commande récente</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique des tendances d'achat
    const trendsCtx = document.getElementById('purchaseTrendsChart').getContext('2d');
    const trendsData = @json($purchaseTrends);
    
    new Chart(trendsCtx, {
        type: 'line',
        data: {
            labels: trendsData.map(item => item.month),
            datasets: [{
                label: 'Nombre de commandes',
                data: trendsData.map(item => item.orders_count),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4
            }, {
                label: 'Dépenses (k FCFA)',
                data: trendsData.map(item => item.total_spent / 1000),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Nombre de commandes'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Dépenses (k FCFA)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                }
            }
        }
    });

    // Graphique des catégories
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx) {
        const categoryData = @json($categoryStats);
        
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: categoryData.map(item => item.name),
                datasets: [{
                    data: categoryData.map(item => item.total_spent),
                    backgroundColor: [
                        '#007bff',
                        '#28a745',
                        '#ffc107',
                        '#dc3545',
                        '#6f42c1',
                        '#fd7e14'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    // Ajouter depuis les recommandations
    document.querySelectorAll('.add-to-cart-recommended').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const originalText = this.innerHTML;
            
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Ajout...';
            this.disabled = true;
            
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.innerHTML = '<i class="fas fa-check me-1"></i>Ajouté !';
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-success');
                    
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            });
        });
    });
});
</script>
@endpush 