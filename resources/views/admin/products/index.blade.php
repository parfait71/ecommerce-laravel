@extends('layouts.admin')

@section('header')
    <div class="page-header" data-aos="fade-up">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">
                    <i class="fas fa-box me-3"></i>Gestion des Produits
                </h1>
                <p class="page-subtitle">Gérez votre catalogue de produits</p>
            </div>
            <div class="header-right">
                <div class="stats-summary">
                    <div class="stat-item">
                        <span class="stat-number">{{ $products->count() }}</span>
                        <span class="stat-label">Produits</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $products->sum('stock') }}</span>
                        <span class="stat-label">En stock</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($products->sum('price'), 0, ',', ' ') }}</span>
                        <span class="stat-label">Valeur totale</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-modern" role="alert" data-aos="fade-up">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-modern" role="alert" data-aos="fade-up">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Actions et filtres -->
    <div class="actions-section mb-4" data-aos="fade-up">
        <div class="actions-container">
            <div class="search-filters">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="productSearch" class="search-input" placeholder="Rechercher un produit...">
                </div>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">
                        <i class="fas fa-th me-2"></i>Tous
                    </button>
                    <button class="filter-btn" data-filter="in-stock">
                        <i class="fas fa-check-circle me-2"></i>En stock
                    </button>
                    <button class="filter-btn" data-filter="low-stock">
                        <i class="fas fa-exclamation-triangle me-2"></i>Stock faible
                    </button>
                    <button class="filter-btn" data-filter="out-of-stock">
                        <i class="fas fa-times-circle me-2"></i>Rupture
                    </button>
                </div>
            </div>
            <div class="action-buttons">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-modern">
                    <i class="fas fa-plus me-2"></i>Ajouter un produit
                </a>
            </div>
        </div>
    </div>

    <!-- Grille des produits -->
    <div class="products-grid" data-aos="fade-up">
        @forelse($products as $product)
            <div class="product-card" 
                 data-product-name="{{ strtolower($product->name) }}" 
                 data-product-category="{{ strtolower($product->category->name ?? '') }}"
                 data-stock-status="{{ $product->stock > 10 ? 'in-stock' : ($product->stock > 0 ? 'low-stock' : 'out-of-stock') }}">
                
                <!-- Image du produit -->
                <div class="product-image">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}?v={{ time() }}" alt="{{ $product->name }}" class="product-img">
                    @elseif($product->images->count() > 0)
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}?v={{ time() }}" alt="{{ $product->name }}" class="product-img">
                    @else
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                        </div>
                    @endif
                    
                    <!-- Indicateur d'images multiples -->
                    @if($product->images->count() > 1)
                        <div class="image-counter">
                            <i class="fas fa-images"></i>
                            <span>{{ $product->images->count() }}</span>
                        </div>
                    @endif
                    
                    <div class="product-overlay">
                        <div class="overlay-actions">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="overlay-btn edit-btn">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="overlay-btn delete-btn" onclick="confirmDelete('{{ $product->name }}', '{{ route('admin.products.destroy', $product->id) }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                            @if($product->images->count() > 1)
                                <button class="overlay-btn gallery-btn" onclick="showImageGallery({{ $product->id }})">
                                    <i class="fas fa-images"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Informations du produit -->
                <div class="product-info">
                    <div class="product-header">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <div class="product-category">
                            <span class="category-badge">{{ $product->category->name ?? 'Sans catégorie' }}</span>
                        </div>
                    </div>
                    
                    <div class="product-details">
                        <div class="price-section">
                            <span class="price-amount">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                        </div>
                        
                        <div class="stock-section">
                            <div class="stock-info">
                                <span class="stock-label">Stock:</span>
                                <span class="stock-count {{ $product->stock > 10 ? 'high' : ($product->stock > 0 ? 'medium' : 'low') }}">
                                    {{ $product->stock }} unités
                                </span>
                            </div>
                            <div class="stock-bar">
                                <div class="stock-fill" style="width: {{ min(($product->stock / 50) * 100, 100) }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions rapides -->
                    <div class="product-actions">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="action-btn edit-btn">
                            <i class="fas fa-edit me-2"></i>Éditer
                        </a>
                        <button class="action-btn delete-btn" onclick="confirmDelete('{{ $product->name }}', '{{ route('admin.products.destroy', $product->id) }}')">
                            <i class="fas fa-trash me-2"></i>Supprimer
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state" data-aos="fade-up">
                <div class="empty-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h3 class="empty-title">Aucun produit trouvé</h3>
                <p class="empty-description">Commencez par ajouter votre premier produit.</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-modern">
                    <i class="fas fa-plus me-2"></i>Ajouter un produit
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination moderne -->
    @if($products->hasPages())
        <div class="pagination-section" data-aos="fade-up">
            <div class="pagination-container">
                <!-- Informations de pagination -->
                <div class="pagination-info">
                    <div class="pagination-stats">
                        <span class="current-range">
                            {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}
                        </span>
                        <span class="separator">sur</span>
                        <span class="total-items">{{ $products->total() }}</span>
                        <span class="items-label">produits</span>
                    </div>
                    <div class="pagination-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ ($products->currentPage() / $products->lastPage()) * 100 }}%"></div>
                        </div>
                        <span class="progress-text">Page {{ $products->currentPage() }} sur {{ $products->lastPage() }}</span>
                    </div>
                </div>

                <!-- Navigation de pagination -->
                <div class="pagination-navigation">
                    {{-- Bouton Précédent --}}
                    @if ($products->onFirstPage())
                        <button class="pagination-btn pagination-btn-prev disabled" disabled>
                            <i class="fas fa-chevron-left"></i>
                            <span class="btn-text">Précédent</span>
                        </button>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="pagination-btn pagination-btn-prev" rel="prev">
                            <i class="fas fa-chevron-left"></i>
                            <span class="btn-text">Précédent</span>
                        </a>
                    @endif

                    <!-- Pages -->
                    <div class="pagination-pages">
                        {{-- Première page --}}
                        @if ($products->currentPage() > 3)
                            <a href="{{ $products->url(1) }}" class="page-number">
                                <span>1</span>
                            </a>
                            @if ($products->currentPage() > 4)
                                <span class="page-ellipsis">...</span>
                            @endif
                        @endif

                        {{-- Pages autour de la page courante --}}
                        @foreach ($products->getUrlRange(max(1, $products->currentPage() - 1), min($products->lastPage(), $products->currentPage() + 1)) as $page => $url)
                            @if ($page == $products->currentPage())
                                <span class="page-number active">
                                    <span>{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $url }}" class="page-number">
                                    <span>{{ $page }}</span>
                                </a>
                            @endif
            @endforeach

                        {{-- Dernière page --}}
                        @if ($products->currentPage() < $products->lastPage() - 2)
                            @if ($products->currentPage() < $products->lastPage() - 3)
                                <span class="page-ellipsis">...</span>
                            @endif
                            <a href="{{ $products->url($products->lastPage()) }}" class="page-number">
                                <span>{{ $products->lastPage() }}</span>
                            </a>
                        @endif
                    </div>

                    {{-- Bouton Suivant --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="pagination-btn pagination-btn-next" rel="next">
                            <span class="btn-text">Suivant</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <button class="pagination-btn pagination-btn-next disabled" disabled>
                            <span class="btn-text">Suivant</span>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    @endif
                </div>

                <!-- Actions rapides -->
                <div class="pagination-actions">
                    <div class="page-jump">
                        <label for="page-jump-input">Aller à la page :</label>
                        <div class="jump-input-group">
                            <input type="number" 
                                   id="page-jump-input" 
                                   class="jump-input" 
                                   min="1" 
                                   max="{{ $products->lastPage() }}" 
                                   value="{{ $products->currentPage() }}"
                                   placeholder="{{ $products->currentPage() }}">
                            <button type="button" class="jump-btn" onclick="jumpToPage()">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
</div>

        <script>
        function jumpToPage() {
            const input = document.getElementById('page-jump-input');
            const page = parseInt(input.value);
            const maxPage = {{ $products->lastPage() }};
            
            if (page >= 1 && page <= maxPage && page !== {{ $products->currentPage() }}) {
                const url = new URL(window.location);
                url.searchParams.set('page', page);
                window.location.href = url.toString();
            }
        }

        // Validation de l'input
        document.getElementById('page-jump-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                jumpToPage();
            }
        });
        </script>
    @endif

    <!-- Formulaire de suppression caché -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Recherche en temps réel
    const searchInput = document.getElementById('productSearch');
    const productCards = document.querySelectorAll('.product-card');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        productCards.forEach(card => {
            const productName = card.dataset.productName;
            const productCategory = card.dataset.productCategory;
            
            if (productName.includes(searchTerm) || productCategory.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Filtres par statut de stock
    const filterBtns = document.querySelectorAll('.filter-btn');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            productCards.forEach(card => {
                const stockStatus = card.dataset.stockStatus;
                
                if (filter === 'all' || stockStatus === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});

function confirmDelete(productName, deleteUrl) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer le produit "${productName}" ?`)) {
        const form = document.getElementById('deleteForm');
        form.action = deleteUrl;
        form.submit();
    }
}
</script>
@endpush

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

.stats-summary {
    display: flex;
    gap: 2rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.85rem;
    opacity: 0.8;
}

/* Alertes modernes */
.alert-modern {
    border-radius: 12px;
    border: none;
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    font-weight: 500;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
    border-left: 4px solid #28a745;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
    border-left: 4px solid #dc3545;
}

/* Section des actions */
.actions-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.actions-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.search-filters {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.search-box {
    position: relative;
    min-width: 300px;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 2;
}

.search-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.search-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.filter-buttons {
    display: flex;
    gap: 0.5rem;
}

.filter-btn {
    padding: 0.75rem 1.5rem;
    border: 2px solid #e9ecef;
    background: white;
    border-radius: 12px;
    font-size: 0.9rem;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
}

.filter-btn.active,
.filter-btn:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.btn-modern {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    color: white;
}

/* Grille des produits */
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem;
}

.product-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    position: relative;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.product-image {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #f8f9fa;
}

.product-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-img {
    transform: scale(1.05);
}

.no-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    color: #6c757d;
}

.no-image i {
    font-size: 3rem;
    opacity: 0.5;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.overlay-actions {
    display: flex;
    gap: 1rem;
}

.overlay-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.overlay-btn.edit-btn {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
}

.overlay-btn.delete-btn {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.overlay-btn:hover {
    transform: scale(1.1);
}

.product-info {
    padding: 1.5rem;
}

.product-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.product-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0;
    line-height: 1.3;
}

.category-badge {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.product-details {
    margin-bottom: 1.5rem;
}

.price-section {
    margin-bottom: 1rem;
}

.price-amount {
    font-size: 1.3rem;
    font-weight: 700;
    color: #28a745;
}

.stock-section {
    margin-bottom: 1rem;
}

.stock-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.stock-label {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 500;
}

.stock-count {
    font-weight: 600;
    font-size: 0.9rem;
}

.stock-count.high {
    color: #28a745;
}

.stock-count.medium {
    color: #ffc107;
}

.stock-count.low {
    color: #dc3545;
}

.stock-bar {
    width: 100%;
    height: 6px;
    background: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
}

.stock-fill {
    height: 100%;
    background: linear-gradient(90deg, #28a745, #20c997);
    border-radius: 3px;
    transition: width 0.3s ease;
}

.product-actions {
    display: flex;
    gap: 0.75rem;
}

.action-btn {
    flex: 1;
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.action-btn.edit-btn {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
}

.action-btn.edit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    color: white;
}

.action-btn.delete-btn {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.action-btn.delete-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}

/* État vide */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
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
}

.empty-icon i {
    font-size: 2rem;
    color: #6c757d;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.empty-description {
    font-size: 1rem;
    color: #6c757d;
    margin-bottom: 1.5rem;
}

/* Pagination moderne */
.pagination-section {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    margin-top: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.pagination-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.pagination-stats {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
    color: #6c757d;
    font-size: 0.9rem;
}

.current-range {
    font-weight: 600;
    color: #343a40;
}

.separator {
    opacity: 0.7;
}

.total-items {
    font-weight: 600;
    color: #343a40;
}

.items-label {
    opacity: 0.8;
}

.pagination-progress {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    width: 100%;
    max-width: 300px;
}

.progress-bar {
    width: 100%;
    height: 6px;
    background: #e9ecef;
    border-radius: 3px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 3px;
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 0.85rem;
    color: #6c757d;
}

.pagination-navigation {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.pagination-btn {
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 0.9rem;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.pagination-btn:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.pagination-btn.disabled {
    opacity: 0.6;
    cursor: not-allowed;
    background: #e9ecef;
    color: #adb5bd;
    border-color: #e9ecef;
}

.pagination-pages {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    flex-wrap: wrap;
}

.page-number {
    padding: 0.5rem 0.75rem;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 0.9rem;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.page-number:hover {
    background: #667eea;
    color: white;
    border-color: #667eea;
}

.page-number.active {
    background: #667eea;
    color: white;
    border-color: #667eea;
    font-weight: 600;
}

.page-ellipsis {
    font-size: 1rem;
    color: #adb5bd;
    padding: 0.5rem 0.75rem;
}

.pagination-actions {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.page-jump {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.jump-input-group {
    display: flex;
    align-items: center;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
}

.jump-input {
    width: 60px;
    padding: 0.75rem 0.5rem;
    border: none;
    text-align: center;
    font-size: 0.9rem;
    color: #343a40;
}

.jump-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.jump-btn {
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 12px;
    background: #667eea;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.jump-btn:hover {
    background: #5a67d8;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
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
    
    .actions-container {
        flex-direction: column;
        gap: 1rem;
    }
    
    .search-filters {
        flex-direction: column;
        width: 100%;
    }
    
    .search-box {
        min-width: 100%;
    }
    
    .filter-buttons {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .products-grid {
        grid-template-columns: 1fr;
    }
    
    .product-actions {
        flex-direction: column;
    }

    .pagination-section {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .pagination-container {
        flex-direction: column;
        align-items: stretch;
    }

    .pagination-info {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .pagination-stats {
        flex-direction: column;
        align-items: center;
    }

    .pagination-progress {
        max-width: 100%;
    }

    .pagination-navigation {
        justify-content: center;
    }

    .pagination-pages {
        justify-content: center;
    }

    .page-number {
        padding: 0.5rem 0.75rem;
    }

    .page-ellipsis {
        padding: 0.5rem 0.75rem;
    }

    .pagination-actions {
        flex-direction: column;
        align-items: center;
    }

    .page-jump {
        flex-direction: column;
        align-items: center;
    }

    .jump-input-group {
        width: 100%;
    }

    .jump-input {
        width: 100%;
    }
}

/* Styles pour l'indicateur d'images multiples */
.image-counter {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    border-radius: 20px;
    padding: 4px 8px;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 4px;
    z-index: 2;
}

.image-counter i {
    font-size: 0.7rem;
}

/* Styles pour le bouton galerie */
.gallery-btn {
    background: rgba(102, 126, 234, 0.9) !important;
}

.gallery-btn:hover {
    background: rgba(102, 126, 234, 1) !important;
}

/* Modal pour la galerie d'images */
.image-gallery-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(5px);
}

.gallery-modal-content {
    position: relative;
    background-color: white;
    margin: 5% auto;
    padding: 0;
    border-radius: 15px;
    width: 90%;
    max-width: 800px;
    max-height: 80vh;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

.gallery-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.gallery-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0;
}

.gallery-close {
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.gallery-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

.gallery-body {
    padding: 1.5rem;
    max-height: 60vh;
    overflow-y: auto;
}

.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
}

.gallery-item {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.gallery-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.gallery-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    display: block;
}

.gallery-item-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-item:hover .gallery-item-overlay {
    opacity: 1;
}

.gallery-item-btn {
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.gallery-item-btn:hover {
    background: #dc3545;
    transform: scale(1.1);
}

/* Animation pour le modal */
@keyframes modalFadeIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.image-gallery-modal.show {
    display: block;
}

.gallery-modal-content {
    animation: modalFadeIn 0.3s ease;
}

/* Responsive pour la galerie */
@media (max-width: 768px) {
    .gallery-modal-content {
        width: 95%;
        margin: 10% auto;
    }
    
    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 0.5rem;
    }
    
    .gallery-item img {
        height: 120px;
    }
}
</style>

<!-- Modal pour la galerie d'images -->
<div id="imageGalleryModal" class="image-gallery-modal">
    <div class="gallery-modal-content">
        <div class="gallery-header">
            <h3 class="gallery-title">
                <i class="fas fa-images me-2"></i>Galerie d'images
            </h3>
            <button class="gallery-close" onclick="closeImageGallery()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="gallery-body">
            <div id="galleryGrid" class="gallery-grid">
                <!-- Les images seront chargées ici -->
            </div>
        </div>
    </div>
</div>

<script>
// Fonction pour afficher la galerie d'images
function showImageGallery(productId) {
    // Charger les images du produit via AJAX
    fetch(`/admin/products/${productId}/images`)
        .then(response => response.json())
        .then(data => {
            const galleryGrid = document.getElementById('galleryGrid');
            galleryGrid.innerHTML = '';
            
            data.images.forEach(image => {
                const galleryItem = document.createElement('div');
                galleryItem.className = 'gallery-item';
                galleryItem.innerHTML = `
                    <img src="/storage/${image.image_path}" alt="Image du produit">
                    <div class="gallery-item-overlay">
                        <button class="gallery-item-btn" onclick="deleteImage(${productId}, ${image.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                galleryGrid.appendChild(galleryItem);
            });
            
            document.getElementById('imageGalleryModal').classList.add('show');
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors du chargement des images');
        });
}

// Fonction pour fermer la galerie
function closeImageGallery() {
    document.getElementById('imageGalleryModal').classList.remove('show');
}

// Fermer la galerie en cliquant à l'extérieur
document.getElementById('imageGalleryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageGallery();
    }
});

// Fonction pour supprimer une image
function deleteImage(productId, imageId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
        fetch(`/admin/products/${productId}/images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeImageGallery();
                location.reload();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la suppression de l\'image');
        });
    }
}

// Fonction de confirmation de suppression
function confirmDelete(productName, deleteUrl) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer le produit "${productName}" ?`)) {
        // Créer un formulaire temporaire pour la suppression
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Recherche et filtrage des produits
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('productSearch');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');
    
    // Fonction de recherche
    function filterProducts() {
        const searchTerm = searchInput.value.toLowerCase();
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
        
        productCards.forEach(card => {
            const productName = card.dataset.productName;
            const productCategory = card.dataset.productCategory;
            const stockStatus = card.dataset.stockStatus;
            
            const matchesSearch = productName.includes(searchTerm) || productCategory.includes(searchTerm);
            const matchesFilter = activeFilter === 'all' || stockStatus === activeFilter;
            
            if (matchesSearch && matchesFilter) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
    
    // Événements de recherche
    searchInput.addEventListener('input', filterProducts);
    
    // Événements de filtrage
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            filterProducts();
        });
    });
});
</script>
