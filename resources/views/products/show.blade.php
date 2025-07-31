@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            @if($product->images->count())
                <div id="productImagesCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($product->images as $key => $image)
                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100" alt="{{ $product->name }}" style="max-height: 350px; object-fit: contain; background-color: #f8f9fa;" onerror="this.src='{{ asset('images/default-product.png') }}'">
                            </div>
                        @endforeach
                    </div>
                    @if($product->images->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#productImagesCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Précédent</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productImagesCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Suivant</span>
                        </button>
                    @endif
                </div>
                <!-- Miniatures -->
                <div class="d-flex justify-content-center gap-2 mb-3">
                    @foreach($product->images as $key => $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail" style="width: 70px; height: 70px; object-fit: contain; background-color: #f8f9fa; cursor: pointer; border: 2px solid #ddd;" data-bs-target="#productImagesCarousel" data-bs-slide-to="{{ $key }}" @if($key === 0) class="active" @endif alt="Miniature {{ $product->name }}" onerror="this.src='{{ asset('images/default-product.png') }}'">
                    @endforeach
                </div>
            @elseif($product->image)
                @if(Str::startsWith($product->image, 'products/'))
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid mb-3" alt="{{ $product->name }}" style="max-height: 350px; object-fit: contain; background-color: #f8f9fa;" onerror="this.src='{{ asset('images/default-product.png') }}'">
                @else
                    <img src="{{ asset('images/' . $product->image) }}" class="img-fluid mb-3" alt="{{ $product->name }}" style="max-height: 350px; object-fit: contain; background-color: #f8f9fa;" onerror="this.src='{{ asset('images/default-product.png') }}'">
                @endif
            @else
                <img src="{{ asset('images/default-product.png') }}" class="img-fluid mb-3" alt="Aucune image" style="max-height: 350px; object-fit: contain; background-color: #f8f9fa;">
            @endif
        </div>
        <div class="col-md-6">
            <h2 class="fw-bold mb-3">{{ $product->name }}</h2>
            <p class="mb-2">{{ $product->description }}</p>
            <p class="fw-bold fs-4 text-success mb-3">{{ number_format($product->price, 0, ',', ' ') }} FCFA</p>
            
            {{-- Affichage du stock --}}
            <div class="mb-3">
                @if($product->stock > 0)
                    <span class="badge bg-success fs-6">En stock ({{ $product->stock }} disponibles)</span>
                @else
                    <span class="badge bg-danger fs-6">Rupture de stock</span>
                @endif
            </div>
            
            {{-- Formulaire d'ajout au panier --}}
            <div class="d-flex gap-2 mt-3">
                @if($product->stock > 0)
                    @if(auth()->check() && auth()->user()->is_admin)
                        <div class="alert alert-info">
                            <small><i class="fas fa-info-circle"></i> Les administrateurs ne peuvent pas passer de commandes</small>
                        </div>
                    @else
                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-cart-plus"></i> Ajouter au panier
                            </button>
                        </form>
                    @endif
                @else
                    <button class="btn btn-secondary" disabled>
                        <i class="fas fa-times"></i> Indisponible
                    </button>
                @endif
            </div>
            
            <div class="mt-3">
                <a href="{{ route('catalogue') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Retour au catalogue
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
