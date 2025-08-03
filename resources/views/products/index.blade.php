@extends('layouts.app')

@section('header')
    <div class="text-center" data-aos="fade-up">
        <h1 class="display-5 fw-bold mb-3">
            <i class="fas fa-shopping-bag me-3"></i>Catalogue des Produits
        </h1>
        <p class="lead mb-0">Découvrez notre sélection de produits de qualité</p>
    </div>
@endsection

@section('content')
    <!-- Filtres et recherche -->
    <div class="card-modern p-4 mb-4" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-primary text-white">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un produit...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="categoryFilter">
                    <option value="">Toutes les catégories</option>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="sortFilter">
                    <option value="name">Trier par nom</option>
                    <option value="price_asc">Prix croissant</option>
                    <option value="price_desc">Prix décroissant</option>
                    <option value="newest">Plus récents</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row g-3 mb-4">
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
            <div class="stats-card">
                <i class="fas fa-box fa-2x mb-2"></i>
                <h5 class="fw-bold mb-1">{{ $products->count() }}</h5>
                <p class="mb-0 small">Produits disponibles</p>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
            <div class="stats-card">
                <i class="fas fa-tags fa-2x mb-2"></i>
                <h5 class="fw-bold mb-1">{{ \App\Models\Category::count() }}</h5>
                <p class="mb-0 small">Catégories</p>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
            <div class="stats-card">
                <i class="fas fa-star fa-2x mb-2"></i>
                <h5 class="fw-bold mb-1">4.8</h5>
                <p class="mb-0 small">Note moyenne</p>
            </div>
        </div>
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
            <div class="stats-card">
                <i class="fas fa-shipping-fast fa-2x mb-2"></i>
                <h5 class="fw-bold mb-1">24h</h5>
                <p class="mb-0 small">Livraison rapide</p>
            </div>
        </div>
    </div>

    <!-- Grille des produits -->
    <div class="row g-4" id="productsGrid">
        @forelse($products as $product)
            <div class="col-12 col-md-6 col-lg-4 product-item" 
                 data-aos="zoom-in" 
                 data-aos-delay="{{ $loop->index * 100 }}"
                 data-category="{{ $product->category_id ?? '' }}"
                 data-name="{{ strtolower($product->name) }}"
                 data-price="{{ $product->price }}">
                <div class="card-modern h-100 product-card">
                    <div class="position-relative">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $product->name }}"
                                 style="height: 200px; object-fit: cover;">
                        @elseif($product->images->count() > 0)
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                 class="card-img-top" 
                                 alt="{{ $product->name }}"
                                 style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                        
                        <!-- Badge promotion -->
                        @if($product->price < 5000)
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-danger">
                                    <i class="fas fa-fire me-1"></i>Promo
                                </span>
                            </div>
                        @endif
                        
                        <!-- Badge nouveau -->
                        @if($product->created_at->diffInDays(now()) < 7)
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-success">
                                    <i class="fas fa-star me-1"></i>Nouveau
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <div class="mb-2">
                            <span class="badge bg-primary mb-2">{{ $product->category->name ?? 'Sans catégorie' }}</span>
                        </div>
                        
                        <h5 class="card-title fw-bold mb-2">{{ $product->name }}</h5>
                        <p class="card-text text-muted small mb-3">{{ Str::limit($product->description, 100) }}</p>
                        
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-success fw-bold fs-5">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <small class="text-muted ms-1">(4.2)</small>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-modern">
                                    <i class="fas fa-eye me-2"></i>Voir détails
                                </a>
                                
                                @auth
                                    @if(auth()->user()->is_admin)
                                        <div class="alert alert-warning mb-0 small">
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            <strong>Admin</strong><br>
                                            <small>Compte administrateur - pas d'achat</small>
                                        </div>
                                    @else
                                        <button class="btn btn-primary btn-modern add-to-cart" 
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->name }}"
                                                data-product-price="{{ $product->price }}">
                                            <i class="fas fa-shopping-cart me-2"></i>Ajouter au panier
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-modern">
                                        <i class="fas fa-sign-in-alt me-2"></i>Se connecter pour acheter
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12" data-aos="fade-up">
                <div class="card-modern p-5 text-center">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h4 class="fw-bold mb-3">Aucun produit disponible</h4>
                    <p class="text-muted mb-4">Nous travaillons actuellement pour ajouter de nouveaux produits. Revenez bientôt !</p>
                    <a href="{{ route('home') }}" class="btn btn-primary btn-modern">
                        <i class="fas fa-home me-2"></i>Retour à l'accueil
                    </a>
                </div>
            </div>
        @endforelse
    </div>

            <!-- Pagination -->
        @if($products->hasPages())
            <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
                <x-pagination :paginator="$products" />
            </div>
        @endif

    <!-- Newsletter -->
    <div class="card-modern p-5 mt-5" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="fw-bold mb-2">Restez informé des nouveautés !</h4>
                <p class="text-muted mb-0">Recevez en avant-première nos nouveaux produits et offres exclusives.</p>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Votre email">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const sortFilter = document.getElementById('sortFilter');
    const productsGrid = document.getElementById('productsGrid');
    const productItems = document.querySelectorAll('.product-item');

    // Fonction de filtrage et tri
    function filterAndSortProducts() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;
        const sortBy = sortFilter.value;

        let visibleProducts = Array.from(productItems).filter(item => {
            const name = item.dataset.name;
            const category = item.dataset.category;
            
            const matchesSearch = name.includes(searchTerm);
            const matchesCategory = !selectedCategory || category === selectedCategory;
            
            return matchesSearch && matchesCategory;
        });

        // Tri
        visibleProducts.sort((a, b) => {
            switch(sortBy) {
                case 'price_asc':
                    return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
                case 'price_desc':
                    return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
                case 'name':
                    return a.dataset.name.localeCompare(b.dataset.name);
                default:
                    return 0;
            }
        });

        // Masquer tous les produits
        productItems.forEach(item => item.style.display = 'none');

        // Afficher les produits filtrés
        visibleProducts.forEach(item => item.style.display = 'block');
    }

    // Événements
    searchInput.addEventListener('input', filterAndSortProducts);
    categoryFilter.addEventListener('change', filterAndSortProducts);
    sortFilter.addEventListener('change', filterAndSortProducts);

    // Ajouter au panier
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const productPrice = this.dataset.productPrice;

            // Animation de chargement
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Ajout en cours...';
            this.disabled = true;

            // Simuler l'ajout au panier
            setTimeout(() => {
                this.innerHTML = '<i class="fas fa-check me-2"></i>Ajouté !';
                this.classList.remove('btn-primary');
                this.classList.add('btn-success');
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-primary');
                    this.disabled = false;
                }, 2000);
            }, 1000);
        });
    });
});
</script>
@endpush
