@extends('layouts.admin')

@section('header')
    <div class="page-header" data-aos="fade-up">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">
                    <i class="fas fa-user me-3"></i>Détails de l'utilisateur
                </h1>
                <p class="page-subtitle">Informations complètes de {{ $user->name }}</p>
            </div>
            <div class="header-right">
                <div class="action-buttons">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Modifier
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="user-details-container" data-aos="fade-up">
        <!-- Informations principales -->
        <div class="main-info-card">
            <div class="user-header">
                <div class="user-avatar-section">
                    <div class="user-avatar-large">
                        <img src="{{ asset('images/avatar.png') }}" alt="{{ $user->name }}" class="avatar-img-large">
                        @if($user->is_admin)
                            <div class="admin-badge-large">
                                <i class="fas fa-crown"></i>
                            </div>
                        @endif
                    </div>
                    <div class="user-status-badge">
                        <span class="status-dot {{ $user->is_admin ? 'admin' : 'user' }}"></span>
                        <span class="status-text">{{ $user->is_admin ? 'Administrateur' : 'Utilisateur' }}</span>
                    </div>
                </div>
                
                <div class="user-info-main">
                    <h2 class="user-name-main">{{ $user->name }}</h2>
                    <p class="user-email-main">{{ $user->email }}</p>
                    <div class="user-meta-main">
                        <span class="meta-item">
                            <i class="fas fa-calendar me-1"></i>
                            Inscrit le {{ $user->created_at->format('d/m/Y à H:i') }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-clock me-1"></i>
                            {{ $user->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grille d'informations détaillées -->
        <div class="details-grid">
            <!-- Informations du compte -->
            <div class="detail-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-circle me-2"></i>Informations du compte
                    </h3>
                </div>
                <div class="card-content">
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Nom complet</span>
                            <span class="info-value">{{ $user->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Adresse email</span>
                            <span class="info-value">{{ $user->email }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Rôle</span>
                            <span class="info-value role-badge {{ $user->is_admin ? 'admin' : 'user' }}">
                                {{ $user->is_admin ? 'Administrateur' : 'Utilisateur' }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email vérifié</span>
                            <span class="info-value {{ $user->email_verified_at ? 'verified' : 'not-verified' }}">
                                {{ $user->email_verified_at ? 'Oui' : 'Non' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques de l'utilisateur -->
            <div class="detail-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar me-2"></i>Statistiques
                    </h3>
                </div>
                <div class="card-content">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-number">{{ $user->orders->count() }}</span>
                                <span class="stat-label">Commandes</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="stat-info">
                                <span class="stat-number">{{ number_format($user->orders->sum('total'), 0, ',', ' ') }} FCFA</span>
                                <span class="stat-label">Total dépensé</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historique des commandes -->
            <div class="detail-card full-width">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history me-2"></i>Historique des commandes
                    </h3>
                </div>
                <div class="card-content">
                    @if($user->orders->count() > 0)
                        <div class="orders-list">
                            @foreach($user->orders->take(5) as $order)
                                <div class="order-item">
                                    <div class="order-info">
                                        <div class="order-header">
                                            <h4 class="order-number">Commande #{{ $order->id }}</h4>
                                            <span class="order-date">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                        <div class="order-details">
                                            <span class="order-status status-{{ $order->status === 'en attente' ? 'pending' : ($order->status === 'confirmé' ? 'confirmed' : 'processing') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                            <span class="order-total">{{ number_format($order->total, 0, ',', ' ') }} FCFA</span>
                                        </div>
                                    </div>
                                    <div class="order-actions">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>Voir
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($user->orders->count() > 5)
                            <div class="view-more">
                                <a href="{{ route('admin.orders.index') }}?user={{ $user->id }}" class="btn btn-outline-primary">
                                    Voir toutes les commandes ({{ $user->orders->count() }})
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <h5 class="empty-title">Aucune commande</h5>
                            <p class="empty-description">Cet utilisateur n'a pas encore passé de commande.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informations techniques -->
            <div class="detail-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cog me-2"></i>Informations techniques
                    </h3>
                </div>
                <div class="card-content">
                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">ID utilisateur</span>
                            <span class="info-value">{{ $user->id }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Date de création</span>
                            <span class="info-value">{{ $user->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Dernière modification</span>
                            <span class="info-value">{{ $user->updated_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Statut du compte</span>
                            <span class="info-value active">Actif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
/* Header de la page */
.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.action-buttons {
    display: flex;
    gap: 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    color: white;
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.btn-secondary:hover {
    background: rgba(255, 255, 255, 0.3);
    color: white;
    transform: translateY(-2px);
}

/* Container principal */
.user-details-container {
    max-width: 1200px;
    margin: 0 auto;
}

/* Carte d'informations principales */
.main-info-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    margin-bottom: 2rem;
}

.user-header {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.user-avatar-section {
    position: relative;
}

.user-avatar-large {
    position: relative;
}

.avatar-img-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.admin-badge-large {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #ffc107, #ff8c00);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.admin-badge-large i {
    font-size: 1.2rem;
    color: white;
}

.user-status-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 1rem;
    justify-content: center;
}

.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.status-dot.admin {
    background: #ffc107;
}

.status-dot.user {
    background: #28a745;
}

.status-text {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 500;
}

.user-info-main {
    flex: 1;
}

.user-name-main {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.user-email-main {
    font-size: 1.2rem;
    color: #6c757d;
    margin-bottom: 1rem;
}

.user-meta-main {
    display: flex;
    gap: 2rem;
}

.meta-item {
    font-size: 1rem;
    color: #6c757d;
    display: flex;
    align-items: center;
}

/* Grille de détails */
.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 1.5rem;
}

.detail-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    overflow: hidden;
}

.detail-card.full-width {
    grid-column: 1 / -1;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.card-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    display: flex;
    align-items: center;
}

.card-content {
    padding: 1.5rem;
}

/* Liste d'informations */
.info-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 500;
    color: #6c757d;
}

.info-value {
    font-weight: 600;
    color: #2c3e50;
}

.info-value.verified {
    color: #28a745;
}

.info-value.not-verified {
    color: #dc3545;
}

.info-value.active {
    color: #28a745;
}

.role-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.role-badge.admin {
    background: linear-gradient(135deg, #fff3cd, #ffeaa7);
    color: #856404;
}

.role-badge.user {
    background: linear-gradient(135deg, #d4edda, #c3e6cb);
    color: #155724;
}

/* Grille de statistiques */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
}

.stat-info {
    flex: 1;
}

.stat-number {
    display: block;
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.9rem;
    color: #6c757d;
}

/* Liste des commandes */
.orders-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.order-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    border: 1px solid #e9ecef;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.order-number {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.order-date {
    font-size: 0.9rem;
    color: #6c757d;
}

.order-details {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.order-status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-confirmed {
    background: #d4edda;
    color: #155724;
}

.status-processing {
    background: #cce5ff;
    color: #004085;
}

.order-total {
    font-weight: 600;
    color: #28a745;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
}

.btn-outline-primary {
    background: transparent;
    color: #667eea;
    border: 2px solid #667eea;
}

.btn-outline-primary:hover {
    background: #667eea;
    color: white;
}

.view-more {
    text-align: center;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

/* État vide */
.empty-state {
    text-align: center;
    padding: 2rem;
    color: #6c757d;
}

.empty-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
}

.empty-icon i {
    font-size: 1.5rem;
    color: #adb5bd;
}

.empty-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.empty-description {
    color: #adb5bd;
    font-size: 0.95rem;
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .user-header {
        flex-direction: column;
        text-align: center;
    }
    
    .user-name-main {
        font-size: 2rem;
    }
    
    .user-meta-main {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .details-grid {
        grid-template-columns: 1fr;
    }
    
    .order-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .order-details {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>
