@extends('layouts.admin')

@section('header')
    <div class="dashboard-header" data-aos="fade-up">
        <div class="header-content">
            <div class="header-left">
                <h1 class="dashboard-title">
                    <i class="fas fa-tachometer-alt me-3"></i>Tableau de Bord Admin
                </h1>
                <p class="dashboard-subtitle">Bienvenue, {{ auth()->user()->name }} ! Gérez votre boutique en ligne</p>
            </div>
            <div class="header-right">
                <div class="quick-stats">
                    <div class="stat-item">
                        <span class="stat-label">Aujourd'hui</span>
                        <span class="stat-value">{{ number_format($stats['revenue'], 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Utilisateur connecté</span>
                        <span class="stat-value">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- Statistiques principales avec design moderne -->
    <div class="stats-grid mb-5">
        <div class="stat-card" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $stats['products'] }}</h3>
                <p class="stat-label">Produits</p>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+5% ce mois</span>
                </div>
            </div>
        </div>
        
        <div class="stat-card" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $stats['categories'] }}</h3>
                <p class="stat-label">Catégories</p>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+2 ce mois</span>
                </div>
            </div>
        </div>
        
        <div class="stat-card" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $stats['total_orders'] }}</h3>
                <p class="stat-label">Commandes</p>
                <div class="stat-trend {{ $stats['total_orders'] > 0 ? 'positive' : 'neutral' }}">
                    <i class="fas fa-{{ $stats['total_orders'] > 0 ? 'arrow-up' : 'minus' }}"></i>
                    <span>{{ $stats['total_orders'] > 0 ? '+12% ce mois' : 'Aucune commande' }}</span>
                </div>
            </div>
        </div>
        
        <div class="stat-card" data-aos="fade-up" data-aos-delay="400">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <h3 class="stat-number">{{ $stats['total_users'] }}</h3>
                <p class="stat-label">Utilisateurs</p>
                <div class="stat-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+8% ce mois</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Cartes de performance avec design moderne -->
    <div class="performance-grid mb-5">
        <div class="performance-card revenue-card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-header">
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="card-info">
                    <h4 class="card-title">Chiffre d'affaires</h4>
                    <p class="card-subtitle">Total des commandes payées</p>
                </div>
            </div>
            <div class="card-content">
                <h2 class="revenue-amount">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} FCFA</h2>
                <div class="progress-container">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: 75%"></div>
                    </div>
                    <span class="progress-text">+12% ce mois</span>
                </div>
            </div>
        </div>
        
        <div class="performance-card payments-card" data-aos="fade-up" data-aos-delay="200">
            <div class="card-header">
                <div class="card-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="card-info">
                    <h4 class="card-title">Paiements</h4>
                    <p class="card-subtitle">Statut des commandes</p>
                </div>
            </div>
            <div class="card-content">
                <div class="payment-stats">
                    <div class="payment-item paid">
                        <span class="payment-count">{{ $stats['paid_orders'] }}</span>
                        <span class="payment-label">Payées</span>
                    </div>
                    <div class="payment-item pending">
                        <span class="payment-count">{{ $stats['unpaid_orders'] }}</span>
                        <span class="payment-label">En attente</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="performance-card delivery-card" data-aos="fade-up" data-aos-delay="300">
            <div class="card-header">
                <div class="card-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="card-info">
                    <h4 class="card-title">Livraisons</h4>
                    <p class="card-subtitle">Commandes en cours</p>
                </div>
            </div>
            <div class="card-content">
                <h2 class="delivery-count">{{ $stats['total_orders'] - $stats['paid_orders'] }}</h2>
                <div class="delivery-status">
                    <div class="status-item">
                        <span class="status-dot preparing"></span>
                        <span class="status-label">En préparation</span>
                    </div>
                    <div class="status-item">
                        <span class="status-dot in-transit"></span>
                        <span class="status-label">En route</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides avec design moderne -->
    <div class="quick-actions-section mb-5">
        <div class="section-header" data-aos="fade-up">
            <h3 class="section-title">
                <i class="fas fa-bolt me-2"></i>Actions rapides
            </h3>
            <p class="section-subtitle">Accédez rapidement aux fonctionnalités principales</p>
        </div>
        
        <div class="actions-grid">
            <div class="action-card" data-aos="zoom-in" data-aos-delay="100">
                <div class="action-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="action-content">
                    <h5 class="action-title">Gérer les produits</h5>
                    <p class="action-description">Ajouter, modifier ou supprimer des produits</p>
                    <a href="{{ route('admin.products.index') }}" class="action-btn">
                        <i class="fas fa-arrow-right me-2"></i>Accéder
                    </a>
                </div>
            </div>
            
            <div class="action-card" data-aos="zoom-in" data-aos-delay="200">
                <div class="action-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="action-content">
                    <h5 class="action-title">Gérer les catégories</h5>
                    <p class="action-description">Organiser vos produits par catégories</p>
                    <a href="{{ route('admin.categories.index') }}" class="action-btn">
                        <i class="fas fa-arrow-right me-2"></i>Accéder
                    </a>
                </div>
            </div>
            
            <div class="action-card" data-aos="zoom-in" data-aos-delay="300">
                <div class="action-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="action-content">
                    <h5 class="action-title">Gérer les commandes</h5>
                    <p class="action-description">Suivre et traiter les commandes</p>
                    <a href="{{ route('admin.orders.index') }}" class="action-btn">
                        <i class="fas fa-arrow-right me-2"></i>Accéder
                    </a>
                </div>
            </div>
            
            <div class="action-card" data-aos="zoom-in" data-aos-delay="400">
                <div class="action-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="action-content">
                    <h5 class="action-title">Gérer les utilisateurs</h5>
                    <p class="action-description">Administrer les comptes clients</p>
                    <a href="{{ route('admin.users.index') }}" class="action-btn">
                        <i class="fas fa-arrow-right me-2"></i>Accéder
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Activités récentes avec design moderne -->
    <div class="recent-activities">
        <div class="activities-grid">
            <div class="activity-card" data-aos="fade-up">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-clock me-2"></i>Dernières commandes
                    </h4>
                    <a href="{{ route('admin.orders.index') }}" class="view-all">Voir tout</a>
                </div>
                <div class="activity-list">
                    @forelse(\App\Models\Order::latest()->take(5)->get() as $order)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="activity-content">
                                <h6 class="activity-title">Commande #{{ $order->id }}</h6>
                                <p class="activity-time">{{ $order->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="activity-status">
                                <span class="status-badge status-{{ $order->status === 'en attente' ? 'pending' : ($order->status === 'confirmé' ? 'confirmed' : 'processing') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <span class="activity-amount">{{ number_format($order->total, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <h5 class="empty-title">Aucune commande récente</h5>
                            <p class="empty-description">Les nouvelles commandes apparaîtront ici</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <div class="activity-card" data-aos="fade-up">
                <div class="card-header">
                    <h4 class="card-title">
                        <i class="fas fa-user-plus me-2"></i>Nouveaux utilisateurs
                    </h4>
                    <a href="{{ route('admin.users.index') }}" class="view-all">Voir tout</a>
                </div>
                <div class="activity-list">
                    @forelse(\App\Models\User::latest()->take(5)->get() as $user)
                        <div class="activity-item">
                            <div class="activity-avatar">
                                <img src="{{ asset('images/avatar.png') }}" 
                                     alt="{{ $user->name }}"
                                     class="user-avatar">
                            </div>
                            <div class="activity-content">
                                <h6 class="activity-title">{{ $user->name }}</h6>
                                <p class="activity-email">{{ $user->email }}</p>
                            </div>
                            <div class="activity-time">
                                <span class="time-ago">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h5 class="empty-title">Aucun nouvel utilisateur</h5>
                            <p class="empty-description">Les nouveaux inscrits apparaîtront ici</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique des ventes avec design moderne
    const ctx = document.getElementById('salesChart');
    if (ctx) {
        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(102, 126, 234, 0.3)');
        gradient.addColorStop(1, 'rgba(102, 126, 234, 0.0)');
        
        const salesChart = new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                datasets: [{
                    label: 'Ventes (FCFA)',
                    data: [1200000, 1900000, 1500000, 2100000, 1800000, 2500000, 2200000],
                    borderColor: '#667eea',
                    backgroundColor: gradient,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6c757d',
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(108, 117, 125, 0.1)'
                        },
                        ticks: {
                            color: '#6c757d',
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return new Intl.NumberFormat('fr-FR').format(value) + ' FCFA';
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }
    
    // Gestion des boutons de période pour le graphique
    const chartBtns = document.querySelectorAll('.chart-btn');
    chartBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            chartBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Ici vous pouvez mettre à jour les données du graphique selon la période
            const period = this.dataset.period;
            console.log('Période sélectionnée:', period);
        });
    });
});
</script>
@endpush

<style>
/* Header du dashboard avec design moderne */
.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    color: white;
    box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 2;
}

.dashboard-title {
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    color: white;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.dashboard-subtitle {
    font-size: 1.2rem;
    opacity: 0.95;
    margin-bottom: 0;
    color: rgba(255, 255, 255, 0.95);
    font-weight: 400;
}

.quick-stats {
    text-align: right;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    margin-bottom: 0.75rem;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
    margin-bottom: 0.25rem;
    color: rgba(255, 255, 255, 0.8);
    font-weight: 500;
}

.stat-value {
    font-size: 1.6rem;
    font-weight: 700;
    color: #fff;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

/* Grille de statistiques avec design moderne */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 20px 20px 0 0;
}

.stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    font-size: 2.5rem;
    color: #667eea;
    margin-bottom: 1.5rem;
    background: linear-gradient(135deg, #f3f0fa, #e8f2ff);
    width: 80px;
    height: 80px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
}

.stat-content {
    z-index: 2;
    position: relative;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    line-height: 1;
}

.stat-label {
    font-size: 1.1rem;
    color: #495057;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.stat-trend {
    font-size: 0.95rem;
    margin-top: 0.75rem;
    color: #28a745;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-weight: 600;
}

.stat-trend.positive {
    color: #28a745;
}
.stat-trend.neutral {
    color: #6c757d;
}

/* Cartes de performance avec design moderne */
.performance-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.performance-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.performance-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

.card-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.card-icon {
    font-size: 2.2rem;
    color: #764ba2;
    background: linear-gradient(135deg, #f3f0fa, #e8f2ff);
    border-radius: 16px;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(118, 75, 162, 0.2);
}

.card-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.3rem;
}

.card-subtitle {
    font-size: 1rem;
    color: #495057;
    opacity: 0.85;
    font-weight: 400;
}

.revenue-amount, .delivery-count, .payment-count {
    font-size: 2.2rem;
    font-weight: 800;
    color: #28a745;
    margin-bottom: 1rem;
    line-height: 1;
}

.progress-container {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 1rem;
}

.progress-bar {
    flex: 1;
    height: 10px;
    background: #e9ecef;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #667eea, #28a745);
    border-radius: 5px;
    transition: width 0.6s ease;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.progress-text {
    font-size: 0.9rem;
    color: #495057;
    font-weight: 600;
}

.payment-stats {
    display: flex;
    gap: 2.5rem;
    margin-top: 1.5rem;
}

.payment-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.payment-count {
    font-size: 1.8rem;
    font-weight: 800;
    color: #28a745;
}

.payment-label {
    font-size: 1rem;
    color: #495057;
    font-weight: 600;
}

.delivery-status {
    display: flex;
    gap: 2rem;
    margin-top: 1.5rem;
}

.status-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.status-dot {
    width: 14px;
    height: 14px;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.status-dot.preparing {
    background: linear-gradient(135deg, #ffc107, #ff8c00);
}
.status-dot.in-transit {
    background: linear-gradient(135deg, #28a745, #20c997);
}
.status-label {
    font-size: 1rem;
    color: #495057;
    font-weight: 600;
}

/* Actions rapides avec design moderne */
.quick-actions-section {
    background: none;
    box-shadow: none;
    border: none;
}

.section-header {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    padding: 2rem;
    margin-bottom: 2rem;
    color: #2c3e50;
}

.section-title {
    color: #2c3e50;
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.section-subtitle {
    color: #495057;
    font-size: 1.1rem;
    opacity: 0.85;
    font-weight: 400;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.action-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    padding: 2rem;
    color: #2c3e50;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 1.5rem;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 20px 20px 0 0;
}

.action-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.action-icon {
    font-size: 2.2rem;
    color: #667eea;
    background: linear-gradient(135deg, #f3f0fa, #e8f2ff);
    border-radius: 16px;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
}

.action-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2c3e50;
}

.action-description {
    color: #495057;
    font-size: 1rem;
    line-height: 1.5;
}

.action-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    border: none;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}
.action-btn:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

/* Activités récentes avec design moderne */
.recent-activities {
    background: none;
}

.activities-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
    gap: 1.5rem;
}

.activity-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    padding: 2rem;
    color: #2c3e50;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.activity-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

.activity-list {
    color: #495057;
}

.activity-item {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.activity-item:hover {
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    transform: translateX(8px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.activity-icon, .activity-avatar {
    color: #764ba2;
    font-size: 1.5rem;
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.activity-title {
    color: #2c3e50;
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.activity-email, .activity-time, .time-ago {
    color: #495057;
    font-size: 0.95rem;
    font-weight: 500;
}

.activity-status {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.3rem;
}

.status-badge {
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-pending {
    background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    color: #856404;
}

.status-confirmed {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
}

.status-processing {
    background: linear-gradient(135deg, #cce5ff, #b3d9ff);
    color: #004085;
}

.activity-amount {
    color: #28a745;
    font-weight: 700;
    font-size: 1rem;
}

.empty-state {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 16px;
    padding: 3rem 2rem;
    text-align: center;
    color: #adb5bd;
    margin-top: 1rem;
    border: 2px dashed #dee2e6;
}

.empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.empty-icon i {
    font-size: 2rem;
    color: #6c757d;
}

.empty-title {
    color: #6c757d;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 1.2rem;
}

.empty-description {
    color: #adb5bd;
    font-size: 1rem;
    font-weight: 500;
}

.view-all {
    color: #667eea;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.95rem;
}
.view-all:hover {
    color: #764ba2;
    transform: translateX(3px);
}

/* Responsive design amélioré */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 2rem;
    }
    
    .dashboard-title {
        font-size: 2.2rem;
    }
    
    .stats-grid, .performance-grid, .actions-grid, .activities-grid {
        grid-template-columns: 1fr;
    }
    
    .payment-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .delivery-status {
        flex-direction: column;
        gap: 1rem;
    }
    
    .activity-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .activity-status {
        align-items: flex-start;
    }
}

/* Animations et effets supplémentaires */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stat-card, .performance-card, .action-card, .activity-card {
    animation: fadeInUp 0.6s ease-out;
}

/* Effets de glassmorphism pour un look moderne */
.stat-card, .performance-card, .action-card, .activity-card, .section-header {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}
</style>
