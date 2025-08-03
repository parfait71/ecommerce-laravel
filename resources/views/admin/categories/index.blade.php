@extends('layouts.admin')

@section('header')
    <div class="page-header" data-aos="fade-up">
        <div class="header-content">
            <div class="header-left">
                <h1 class="page-title">
                    <i class="fas fa-tags me-3"></i>Gestion des Catégories
                </h1>
                <p class="page-subtitle">Organisez vos produits par catégories</p>
            </div>
            <div class="header-right">
                <div class="stats-summary">
                    <div class="stat-item">
                        <span class="stat-number">{{ $categories->count() }}</span>
                        <span class="stat-label">Catégories</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $categories->sum('products_count') }}</span>
                        <span class="stat-label">Produits</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $categories->where('products_count', 0)->count() }}</span>
                        <span class="stat-label">Vides</span>
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

    @if(session('error'))
        <div class="alert alert-danger alert-modern" role="alert" data-aos="fade-up">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Actions et recherche -->
    <div class="actions-section mb-4" data-aos="fade-up">
        <div class="actions-container">
            <div class="search-filters">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="categorySearch" class="search-input" placeholder="Rechercher une catégorie...">
                </div>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="all">
                        <i class="fas fa-th me-2"></i>Toutes
                    </button>
                    <button class="filter-btn" data-filter="with-products">
                        <i class="fas fa-box me-2"></i>Avec produits
                    </button>
                    <button class="filter-btn" data-filter="empty">
                        <i class="fas fa-folder-open me-2"></i>Vides
                    </button>
                </div>
            </div>
            <div class="action-buttons">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-modern">
                    <i class="fas fa-plus me-2"></i>Ajouter une catégorie
                </a>
            </div>
        </div>
    </div>

    <!-- Grille des catégories -->
    <div class="categories-grid" data-aos="fade-up">
        @forelse($categories as $category)
            <div class="category-card" 
                 data-category-name="{{ strtolower($category->name) }}"
                 data-category-status="{{ $category->products_count > 0 ? 'with-products' : 'empty' }}">
                
                <!-- En-tête de la carte -->
                <div class="category-header">
                    <div class="category-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="category-status">
                        <span class="status-dot {{ $category->products_count > 0 ? 'active' : 'empty' }}"></span>
                        <span class="status-text">{{ $category->products_count > 0 ? 'Active' : 'Vide' }}</span>
                    </div>
                </div>
                
                <!-- Informations de la catégorie -->
                <div class="category-info">
                    <h3 class="category-name">{{ $category->name }}</h3>
                    <div class="category-meta">
                        <div class="meta-item">
                            <i class="fas fa-box me-2"></i>
                            <span class="meta-label">Produits:</span>
                            <span class="meta-value">{{ $category->products_count ?? 0 }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar me-2"></i>
                            <span class="meta-label">Créée:</span>
                            <span class="meta-value">{{ $category->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Barre de progression des produits -->
                <div class="category-progress">
                    <div class="progress-info">
                        <span class="progress-label">Utilisation</span>
                        <span class="progress-percentage">{{ min(($category->products_count ?? 0) * 10, 100) }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ min(($category->products_count ?? 0) * 10, 100) }}%"></div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="category-actions">
                    <a href="{{ route('admin.categories.edit', $category->id) }}" class="action-btn edit-btn">
                        <i class="fas fa-edit me-2"></i>Éditer
                    </a>
                    <button class="action-btn delete-btn" onclick="confirmDelete('{{ $category->name }}', '{{ route('admin.categories.destroy', $category->id) }}')">
                        <i class="fas fa-trash me-2"></i>Supprimer
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state" data-aos="fade-up">
                <div class="empty-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <h3 class="empty-title">Aucune catégorie trouvée</h3>
                <p class="empty-description">Commencez par créer votre première catégorie pour organiser vos produits.</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-modern">
                    <i class="fas fa-plus me-2"></i>Créer une catégorie
                </a>
            </div>
        @endforelse
    </div>

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
    const searchInput = document.getElementById('categorySearch');
    const categoryCards = document.querySelectorAll('.category-card');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        categoryCards.forEach(card => {
            const categoryName = card.dataset.categoryName;
            
            if (categoryName.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
    
    // Filtres par statut
    const filterBtns = document.querySelectorAll('.filter-btn');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Retirer la classe active de tous les boutons
            filterBtns.forEach(b => b.classList.remove('active'));
            // Ajouter la classe active au bouton cliqué
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            categoryCards.forEach(card => {
                const categoryStatus = card.dataset.categoryStatus;
                
                if (filter === 'all' || categoryStatus === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});

function confirmDelete(categoryName, deleteUrl) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer la catégorie "${categoryName}" ?`)) {
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

/* Grille des catégories */
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
}

.category-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.category-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.category-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.category-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.category-icon i {
    font-size: 1.25rem;
    color: white;
}

.category-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.status-dot.active {
    background: #28a745;
}

.status-dot.empty {
    background: #6c757d;
}

.status-text {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
}

.category-info {
    margin-bottom: 1.5rem;
}

.category-name {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.category-meta {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.meta-label {
    color: #6c757d;
    font-weight: 500;
}

.meta-value {
    color: #2c3e50;
    font-weight: 600;
}

.category-progress {
    margin-bottom: 1.5rem;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.progress-label {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 500;
}

.progress-percentage {
    font-size: 0.9rem;
    color: #667eea;
    font-weight: 600;
}

.progress-bar {
    width: 100%;
    height: 8px;
    background: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #667eea, #764ba2);
    border-radius: 4px;
    transition: width 0.3s ease;
}

.category-actions {
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
    
    .categories-grid {
        grid-template-columns: 1fr;
    }
    
    .category-actions {
        flex-direction: column;
    }
}
</style> 