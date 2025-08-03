@extends('layouts.app')

@section('header')
    <div class="text-center" data-aos="fade-up">
        <h1 class="display-5 fw-bold mb-3">
            <i class="fas fa-shopping-cart me-3"></i>Mon Panier
        </h1>
        <p class="lead mb-0">Gérez vos achats et passez commande en toute simplicité</p>
    </div>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" data-aos="fade-up">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" data-aos="fade-up">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="row g-4">
            <!-- Liste des produits -->
            <div class="col-lg-8" data-aos="fade-up">
                <div class="info-card">
                    <h4 class="fw-bold mb-4">
                        <i class="fas fa-box me-2"></i>Produits dans votre panier ({{ count($cart) }})
                    </h4>
                    
                    <div class="cart-items">
                    @php $total = 0; @endphp
                    @foreach($cart as $productId => $item)
                        @php $total += $item['price'] * $item['quantity']; @endphp
                            <div class="cart-item mb-4 p-3 border rounded" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ asset('images/products/' . ($item['image'] ?? 'default.jpg')) }}" 
                                             class="img-fluid rounded" 
                                             alt="{{ $item['name'] }}"
                                             style="height: 80px; object-fit: cover;">
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="fw-bold mb-1">{{ $item['name'] }}</h6>
                                        <small class="text-muted">{{ $item['category'] ?? 'Sans catégorie' }}</small>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="text-success fw-bold">{{ number_format($item['price'], 0, ',', ' ') }} FCFA</span>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-sm">
                                            <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity({{ $productId }}, -1)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" 
                                                   class="form-control text-center quantity-input" 
                                                   value="{{ $item['quantity'] }}" 
                                                   min="1" 
                                                   data-product-id="{{ $productId }}"
                                                   style="width: 60px;">
                                            <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity({{ $productId }}, 1)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <span class="fw-bold text-primary">{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA</span>
                                    </div>
                                    <div class="col-md-1">
                                        <button class="btn btn-outline-danger btn-sm" onclick="removeItem({{ $productId }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                    </div>
                </div>
            </div>

            <!-- Résumé de commande -->
            <div class="col-lg-4" data-aos="fade-left">
                <div class="info-card sticky-top" style="top: 20px;">
                    <h4 class="fw-bold mb-4">
                        <i class="fas fa-receipt me-2"></i>Résumé de commande
                    </h4>
                    
                    <div class="summary-item d-flex justify-content-between mb-2">
                        <span>Sous-total</span>
                        <span>{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                    </div>
                    
                    <div class="summary-item d-flex justify-content-between mb-2">
                        <span>Livraison</span>
                        <span class="text-success">Gratuite</span>
                    </div>
                    
                    @if($total < 10000)
                        <div class="alert alert-warning small mb-3">
                            <i class="fas fa-info-circle me-1"></i>
                            Ajoutez {{ number_format(10000 - $total, 0, ',', ' ') }} FCFA pour la livraison gratuite !
                        </div>
                    @endif
                    
                    <hr>
                    
                    <div class="summary-item d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total</span>
                        <span class="fw-bold fs-5 text-success">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
        </div>
        
                    <div class="d-grid gap-2">
                        @if(auth()->check() && auth()->user()->is_admin)
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Compte Administrateur</strong><br>
                                Les administrateurs ne peuvent pas passer de commandes. Veuillez utiliser un compte client.
                            </div>
                        @else
                            <a href="{{ route('checkout') }}" class="btn btn-primary btn-modern">
                                <i class="fas fa-credit-card me-2"></i>Passer commande
                            </a>
                        @endif
                        
                        <form action="{{ route('cart.clear') }}" method="POST" class="d-grid">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-modern" onclick="return confirm('Êtes-vous sûr de vouloir vider votre panier ?')">
                                <i class="fas fa-trash me-2"></i>Vider le panier
                            </button>
                        </form>
                        
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-modern">
                            <i class="fas fa-shopping-bag me-2"></i>Continuer les achats
                        </a>
                    </div>
                    
                    <!-- Informations de livraison -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6 class="fw-bold mb-2">
                            <i class="fas fa-shipping-fast me-2"></i>Livraison
                        </h6>
                        <ul class="list-unstyled small">
                            <li><i class="fas fa-check text-success me-1"></i>Livraison gratuite dès 10 000 FCFA</li>
                            <li><i class="fas fa-check text-success me-1"></i>Livraison en 24-48h</li>
                            <li><i class="fas fa-check text-success me-1"></i>Suivi en temps réel</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produits recommandés -->
        <div class="mt-5" data-aos="fade-up">
            <h4 class="fw-bold mb-4">
                <i class="fas fa-star me-2"></i>Produits recommandés
            </h4>
            <div class="row g-4">
                @foreach(\App\Models\Product::inRandomOrder()->take(4)->get() as $product)
                    <div class="col-md-3">
                        <div class="card-modern h-100">
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
        </div>

    @else
        <!-- Panier vide -->
        <div class="text-center py-5" data-aos="fade-up">
            <div class="empty-cart-container">
                <div class="empty-cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3 class="empty-cart-title">Votre panier est vide</h3>
                <p class="empty-cart-description">Découvrez nos produits et commencez vos achats !</p>
                <div class="empty-cart-actions">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-modern empty-cart-button">
                        <i class="fas fa-shopping-bag me-2"></i>Voir le catalogue
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary btn-modern empty-cart-button-outline">
                        <i class="fas fa-home me-2"></i>Retour à l'accueil
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mise à jour de la quantité
    window.updateQuantity = function(productId, change) {
        const input = document.querySelector(`input[data-product-id="${productId}"]`);
        const newQuantity = parseInt(input.value) + change;
        
        if (newQuantity >= 1) {
            input.value = newQuantity;
            
            // Envoyer la mise à jour
            fetch('{{ route("cart.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: newQuantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    };

    // Supprimer un article
    window.removeItem = function(productId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
            fetch('{{ route("cart.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    };

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
