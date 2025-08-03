@extends('layouts.app')

@section('header')
    <div class="text-center" data-aos="fade-up">
        <h1 class="display-5 fw-bold mb-3">
            <i class="fas fa-shopping-bag me-3"></i>Mes Commandes
        </h1>
        <p class="lead mb-0">Suivez l'état de vos commandes et consultez votre historique</p>
    </div>
@endsection

@section('content')
    <style>
    /* Forcer le fond clair sur la barre de filtres */
    .card-modern {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%) !important;
        color: #2c3e50 !important;
        border: 1px solid #e9ecef !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
        border-radius: 16px !important;
    }

    .card-modern * {
        color: inherit !important;
    }

    /* Styles pour les labels */
    .form-label {
        color: #2c3e50 !important;
        font-weight: 600 !important;
        margin-bottom: 0.5rem !important;
    }

    /* Styles pour les inputs et selects */
    .form-control,
    .form-select {
        background: white !important;
        border: 2px solid #e9ecef !important;
        border-radius: 12px !important;
        color: #2c3e50 !important;
        transition: all 0.3s ease !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea !important;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
        outline: none !important;
    }

    .form-control::placeholder {
        color: #6c757d !important;
    }

    /* Styles pour les options des selects */
    .form-select option {
        color: #2c3e50 !important;
        background: white !important;
    }

    /* Styles pour les cartes de commandes */
    .order-item {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%) !important;
        color: #2c3e50 !important;
        border: 1px solid #e9ecef !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
        border-radius: 16px !important;
        transition: all 0.3s ease !important;
    }

    .order-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12) !important;
    }

    .order-item * {
        color: inherit !important;
    }

    /* Styles pour les badges de statut */
    .badge {
        border-radius: 20px !important;
        padding: 0.5rem 1rem !important;
        font-weight: 600 !important;
    }

    .badge.bg-warning {
        background: #ffc107 !important;
        color: #212529 !important;
    }

    .badge.bg-success {
        background: #28a745 !important;
        color: white !important;
    }

    .badge.bg-info {
        background: #17a2b8 !important;
        color: white !important;
    }

    .badge.bg-danger {
        background: #dc3545 !important;
        color: white !important;
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

    /* Styles pour les textes */
    .text-muted {
        color: #6c757d !important;
    }

    .fw-bold {
        color: #2c3e50 !important;
    }

    /* Styles pour les titres */
    h6 {
        color: #2c3e50 !important;
        font-weight: 600 !important;
    }

    /* Styles pour les paragraphes */
    p {
        color: #495057 !important;
    }

    /* Styles pour le header - texte blanc sur fond coloré */
    .display-5 {
        color: white !important;
    }

    .display-5 i {
        color: white !important;
    }

    .lead {
        color: rgba(255, 255, 255, 0.9) !important;
    }
    </style>
    <!-- Statistiques des commandes -->
    <div class="row g-3 mb-4">
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
            <div class="stats-card">
                <i class="fas fa-shopping-bag fa-2x mb-2"></i>
                <h5 class="fw-bold mb-1">{{ $orders->count() }}</h5>
                <p class="mb-0 small">Total commandes</p>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
            <div class="stats-card">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h5 class="fw-bold mb-1">{{ $orders->where('status', 'en attente')->count() }}</h5>
                <p class="mb-0 small">En attente</p>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
            <div class="stats-card">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <h5 class="fw-bold mb-1">{{ $orders->where('status', 'confirmé')->count() }}</h5>
                <p class="mb-0 small">Confirmées</p>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
            <div class="stats-card">
                <i class="fas fa-truck fa-2x mb-2"></i>
                <h5 class="fw-bold mb-1">{{ $orders->where('status', 'livré')->count() }}</h5>
                <p class="mb-0 small">Livrées</p>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="card-modern p-4 mb-4" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-md-4">
                <label class="form-label fw-bold">Filtrer par statut</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Tous les statuts</option>
                    <option value="en attente">En attente</option>
                    <option value="confirmé">Confirmé</option>
                    <option value="en cours">En cours</option>
                    <option value="livré">Livré</option>
                    <option value="annulé">Annulé</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Trier par</label>
                <select class="form-select" id="sortFilter">
                    <option value="newest">Plus récentes</option>
                    <option value="oldest">Plus anciennes</option>
                    <option value="total_high">Prix élevé</option>
                    <option value="total_low">Prix bas</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Rechercher</label>
                <input type="text" class="form-control" id="searchInput" placeholder="Rechercher une commande...">
            </div>
        </div>
    </div>

    <!-- Liste des commandes -->
    <div class="row g-4" id="ordersGrid">
        @forelse($orders as $order)
            <div class="col-12 col-lg-6 order-item" 
                 data-aos="fade-up" 
                 data-aos-delay="{{ $loop->index * 100 }}"
                 data-status="{{ $order->status }}"
                 data-total="{{ $order->total }}"
                 data-date="{{ $order->created_at->timestamp }}">
                <div class="card-modern h-100">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1">Commande #{{ $order->id }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $order->created_at->format('d/m/Y à H:i') }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $order->status === 'en attente' ? 'warning' : ($order->status === 'confirmé' ? 'success' : ($order->status === 'livré' ? 'info' : 'danger')) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Produits de la commande -->
                        <div class="mb-3">
                            <h6 class="fw-bold mb-2">
                                <i class="fas fa-box me-2"></i>Produits ({{ $order->products->count() }})
                            </h6>
                            <div class="row g-2">
                                @foreach($order->products->take(3) as $product)
                                    <div class="col-4">
                                        <div class="d-flex align-items-center p-2 bg-light rounded">
                                            <img src="{{ asset('storage/' . ($product->image ?? 'default.jpg')) }}" 
                                                 class="rounded me-2" 
                                                 alt="{{ $product->name }}"
                                                 style="width: 30px; height: 30px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <small class="fw-bold d-block">{{ $product->name }}</small>
                                                <small class="text-muted">x{{ $product->pivot->quantity }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                @if($order->products->count() > 3)
                                    <div class="col-4">
                                        <div class="d-flex align-items-center justify-content-center p-2 bg-light rounded">
                                            <small class="text-muted">+{{ $order->products->count() - 3 }} autres</small>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Informations de paiement -->
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-credit-card text-primary me-2"></i>
                                    <div>
                                        <small class="fw-bold">Paiement</small>
                                        <br><small class="text-muted">{{ $order->payment ? ucfirst($order->payment->method) : 'Non défini' }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-money-bill text-success me-2"></i>
                                    <div>
                                        <small class="fw-bold">Statut paiement</small>
                                        <br>
                                        <span class="badge bg-{{ $order->payment_status === 'payé' ? 'success' : 'warning' }} small">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold fs-5 text-success">{{ number_format($order->total, 0, ',', ' ') }} FCFA</span>
                        </div>

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-modern">
                                <i class="fas fa-eye me-2"></i>Voir détails
                            </a>
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="{{ route('invoice.download', $order) }}" class="btn btn-outline-primary btn-sm w-100">
                                        <i class="fas fa-download me-1"></i>Facture
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('invoice.view', $order) }}" class="btn btn-outline-info btn-sm w-100" target="_blank">
                                        <i class="fas fa-eye me-1"></i>Voir
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12" data-aos="fade-up">
                <div class="empty-state-container">
                    <div class="empty-state-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h3 class="empty-state-title">Aucune commande trouvée</h3>
                    <p class="empty-state-description">Vous n'avez pas encore passé de commande. Découvrez nos produits !</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-modern empty-state-button">
                        <i class="fas fa-shopping-bag me-2"></i>Voir le catalogue
                    </a>
                </div>
            </div>
        @endforelse
    </div>

            <!-- Pagination -->
        @if($orders->hasPages())
            <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
                <x-pagination :paginator="$orders" />
            </div>
        @endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('statusFilter');
    const sortFilter = document.getElementById('sortFilter');
    const searchInput = document.getElementById('searchInput');
    const ordersGrid = document.getElementById('ordersGrid');
    const orderItems = document.querySelectorAll('.order-item');

    // Fonction de filtrage et tri
    function filterAndSortOrders() {
        const selectedStatus = statusFilter.value;
        const sortBy = sortFilter.value;
        const searchTerm = searchInput.value.toLowerCase();

        let visibleOrders = Array.from(orderItems).filter(item => {
            const status = item.dataset.status;
            const orderId = item.querySelector('h6').textContent.toLowerCase();
            
            const matchesStatus = !selectedStatus || status === selectedStatus;
            const matchesSearch = orderId.includes(searchTerm);
            
            return matchesStatus && matchesSearch;
        });

        // Tri
        visibleOrders.sort((a, b) => {
            switch(sortBy) {
                case 'newest':
                    return parseInt(b.dataset.date) - parseInt(a.dataset.date);
                case 'oldest':
                    return parseInt(a.dataset.date) - parseInt(b.dataset.date);
                case 'total_high':
                    return parseFloat(b.dataset.total) - parseFloat(a.dataset.total);
                case 'total_low':
                    return parseFloat(a.dataset.total) - parseFloat(b.dataset.total);
                default:
                    return 0;
            }
        });

        // Masquer tous les éléments
        orderItems.forEach(item => item.style.display = 'none');

        // Afficher les éléments filtrés
        visibleOrders.forEach(item => item.style.display = 'block');
    }

    // Événements
    statusFilter.addEventListener('change', filterAndSortOrders);
    sortFilter.addEventListener('change', filterAndSortOrders);
    searchInput.addEventListener('input', filterAndSortOrders);
});
</script>
@endpush
