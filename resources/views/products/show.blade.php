@extends('layouts.app')

@section('header')
    <div class="text-center" data-aos="fade-up">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-white">Catalogue</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
<div class="container py-4">
    <div class="row g-5">
        <!-- Galerie d'images -->
        <div class="col-lg-6" data-aos="fade-right">
            <div class="card-modern p-4">
                @if($product->image || $product->images->count() > 0)
                    <div id="productImagesCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner rounded">
                            <!-- Image principale en premier -->
                            @if($product->image)
                                <div class="carousel-item active">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="d-block w-100" 
                                         alt="{{ $product->name }}"
                                         style="height: 400px; object-fit: cover;">
                                </div>
                            @endif
                            
                            <!-- Images multiples -->
                            @foreach($product->images as $key => $image)
                                <div class="carousel-item {{ !$product->image && $key === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         class="d-block w-100" 
                                         alt="{{ $product->name }}"
                                         style="height: 400px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                        
                        @if(($product->image && $product->images->count() > 0) || $product->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productImagesCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productImagesCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                            
                            <!-- Indicateurs -->
                            <div class="carousel-indicators">
                                @if($product->image)
                                    <button type="button" 
                                            data-bs-target="#productImagesCarousel" 
                                            data-bs-slide-to="0" 
                                            class="active"
                                            aria-current="true"
                                            aria-label="Slide 1"></button>
                                @endif
                                @foreach($product->images as $key => $image)
                                    <button type="button" 
                                            data-bs-target="#productImagesCarousel" 
                                            data-bs-slide-to="{{ $product->image ? $key + 1 : $key }}" 
                                            class="{{ !$product->image && $key === 0 ? 'active' : '' }}"
                                            aria-current="{{ !$product->image && $key === 0 ? 'true' : 'false' }}"
                                            aria-label="Slide {{ $product->image ? $key + 2 : $key + 1 }}"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    
                    <!-- Miniatures -->
                    @if(($product->image && $product->images->count() > 0) || $product->images->count() > 1)
                        <div class="row mt-3">
                            @if($product->image)
                                <div class="col-3">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="img-thumbnail cursor-pointer" 
                                         alt="Image principale"
                                         style="height: 80px; object-fit: cover;"
                                         onclick="goToSlide(0)">
                                </div>
                            @endif
                            @foreach($product->images as $key => $image)
                                <div class="col-3">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                         class="img-thumbnail cursor-pointer" 
                                         alt="Miniature {{ $key + 1 }}"
                                         style="height: 80px; object-fit: cover;"
                                         onclick="goToSlide({{ $product->image ? $key + 1 : $key }})">
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-image fa-4x text-muted mb-3"></i>
                        <p class="text-muted">Aucune image disponible</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Informations produit -->
        <div class="col-lg-6" data-aos="fade-left">
            <div class="card-modern p-4 h-100">
                <!-- Badges -->
                <div class="mb-3">
                    @if($product->price < 5000)
                        <span class="badge bg-danger me-2">
                            <i class="fas fa-fire me-1"></i>Promo
                        </span>
                    @endif
                    @if($product->created_at->diffInDays(now()) < 7)
                        <span class="badge bg-success me-2">
                            <i class="fas fa-star me-1"></i>Nouveau
                        </span>
                    @endif
                    <span class="badge bg-primary">{{ $product->category->name ?? 'Sans catégorie' }}</span>
                </div>

                <!-- Titre et description -->
                <h1 class="fw-bold mb-3">{{ $product->name }}</h1>
                <p class="text-muted mb-4">{{ $product->description }}</p>

                <!-- Prix et stock -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <span class="text-success fw-bold fs-3">{{ number_format($product->price, 0, ',', ' ') }} FCFA</span>
                            @if($product->price < 5000)
                                <span class="badge bg-warning ms-2">-20%</span>
                            @endif
                        </div>
                        <small class="text-muted">Prix TTC</small>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-box text-primary me-2"></i>
                            <span class="fw-bold">{{ $product->stock }}</span>
                            <small class="text-muted ms-1">en stock</small>
                        </div>
                        @if($product->stock < 10 && $product->stock > 0)
                            <small class="text-warning">Stock limité !</small>
                        @endif
                    </div>
                </div>

                <!-- Évaluations -->
                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <div class="text-warning me-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <span class="fw-bold">4.2</span>
                        <small class="text-muted ms-1">(128 avis)</small>
                    </div>
                    <small class="text-muted">Livraison gratuite à partir de 10 000 FCFA</small>
                </div>

                <!-- Formulaire d'achat -->
                @auth
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Quantité</label>
                                <input type="number" 
                                       name="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->stock }}" 
                                       class="form-control"
                                       id="quantityInput">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Total</label>
                                <div class="form-control-plaintext fw-bold fs-5 text-success" id="totalPrice">
                                    {{ number_format($product->price, 0, ',', ' ') }} FCFA
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            @if(auth()->user()->is_admin)
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Compte Administrateur</strong><br>
                                    Les administrateurs ne peuvent pas ajouter de produits au panier. Veuillez utiliser un compte client.
                                </div>
                            @else
                                <button type="submit" class="btn btn-primary btn-modern" id="addToCartBtn">
                                    <i class="fas fa-shopping-cart me-2"></i>Ajouter au panier
                                </button>
                            @endif
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-primary btn-modern">
                                <i class="fas fa-eye me-2"></i>Voir mon panier
                            </a>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <a href="{{ route('login') }}" class="alert-link">Connectez-vous</a> pour ajouter ce produit à votre panier.
                    </div>
                @endauth

                <!-- Informations supplémentaires -->
                <div class="row g-3 mt-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shipping-fast text-success me-2"></i>
                            <div>
                                <small class="fw-bold">Livraison rapide</small>
                                <br><small class="text-muted">24-48h</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shield-alt text-primary me-2"></i>
                            <div>
                                <small class="fw-bold">Garantie</small>
                                <br><small class="text-muted">1 an</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produits similaires -->
    <div class="mt-5" data-aos="fade-up">
        <h3 class="fw-bold mb-4">Produits similaires</h3>
        <div class="row g-4">
            @foreach(\App\Models\Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(4)->get() as $similarProduct)
                <div class="col-md-3">
                    <div class="card-modern h-100">
                        @if($similarProduct->image)
                            <img src="{{ asset('storage/' . $similarProduct->image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $similarProduct->name }}"
                                 style="height: 150px; object-fit: cover;">
                        @elseif($similarProduct->images->count() > 0)
                            <img src="{{ asset('storage/' . $similarProduct->images->first()->image_path) }}" 
                                 class="card-img-top" 
                                 alt="{{ $similarProduct->name }}"
                                 style="height: 150px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 150px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h6 class="fw-bold">{{ $similarProduct->name }}</h6>
                            <p class="text-success fw-bold">{{ number_format($similarProduct->price, 0, ',', ' ') }} FCFA</p>
                            <a href="{{ route('products.show', $similarProduct) }}" class="btn btn-sm btn-outline-primary w-100">
                                Voir détails
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantityInput');
    const totalPrice = document.getElementById('totalPrice');
    const addToCartBtn = document.getElementById('addToCartBtn');
    const basePrice = {{ $product->price }};

    // Calculer le total
    function updateTotal() {
        const quantity = parseInt(quantityInput.value);
        const total = basePrice * quantity;
        totalPrice.textContent = new Intl.NumberFormat('fr-FR').format(total) + ' FCFA';
    }

    // Événements
    quantityInput.addEventListener('input', updateTotal);
    quantityInput.addEventListener('change', updateTotal);

    // Animation d'ajout au panier
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function(e) {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Ajout en cours...';
            this.disabled = true;
            
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
    }
});

// Fonction pour aller à une slide spécifique
function goToSlide(index) {
    const carousel = new bootstrap.Carousel(document.getElementById('productImagesCarousel'));
    carousel.to(index);
}
</script>
@endsection
