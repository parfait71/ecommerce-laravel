@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-primary text-center fw-bold">Catalogue des produits</h1>
    
    <!-- Formulaire de recherche et filtrage -->
    <form method="GET" action="" class="row g-3 mb-4 align-items-end">
        <div class="col-md-5">
            <label for="keyword" class="form-label">Recherche</label>
            <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Nom ou description..." value="{{ request('keyword') }}">
        </div>
        <div class="col-md-4">
            <label for="category" class="form-label">Catégorie</label>
            <select name="category" id="category" class="form-select">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Rechercher</button>
        </div>
    </form>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle shadow border rounded bg-white">
            <thead class="table-primary">
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Description</th>
                    <th scope="col" class="text-end">Prix</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <th scope="row" class="text-center">{{ $product->id }}</th>
                        <td class="fw-bold">{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td class="text-success fw-bold text-end" style="font-size:1.1em;">
                            {{ number_format($product->price, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="text-center">
                            <form action="{{ route('cart.add') }}" method="POST" style="display:inline-block;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-cart-plus"></i> Ajouter au panier
                                </button>
                            </form>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm ms-2">Voir</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Aucun produit disponible.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($products->hasPages())
        <div class="d-flex justify-content-center my-4">
            {{ $products->links() }}
        </div>
    @endif
    <div class="text-center mt-4">
        <a href="{{ route('cart.index') }}" class="btn btn-primary">
            <i class="fas fa-shopping-cart"></i> Voir mon panier
        </a>
    </div>
</div>
@endsection
