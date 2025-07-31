@extends('layouts.admin')

@section('title', 'Gestion des produits')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des produits</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            Ajouter un produit
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            @php
                // Forcer le chargement des images
                $product->load('images');
                $mainImage = $product->images->first();
            @endphp
            <tr>
                <td>
                    @if($mainImage)
                        @php
                            // Vérifier si l'image existe dans public/products
                            $imagePath = public_path('products/' . basename($mainImage->image_path));
                            $hasRealImage = file_exists($imagePath);
                        @endphp
                        
                        @if($hasRealImage)
                            <img src="{{ asset('products/' . basename($mainImage->image_path)) }}" 
                                 alt="Image" 
                                 width="60" 
                                 height="60" 
                                 style="object-fit: contain; background-color: #f8f9fa; border-radius: 4px; border: 1px solid #dee2e6;">
                        @else
                            @php
                                // Déterminer l'icône selon la catégorie
                                $icon = 'laptop';
                                if ($product->category) {
                                    switch (strtolower($product->category->name)) {
                                        case 'informatique':
                                            $icon = 'laptop';
                                            break;
                                        case 'impression':
                                            $icon = 'print';
                                            break;
                                        case 'accessoires':
                                            $icon = 'mouse';
                                            break;
                                        case 'écrans':
                                            $icon = 'tv';
                                            break;
                                        case 'stockage':
                                            $icon = 'hdd';
                                            break;
                                        case 'audio':
                                            $icon = 'headphones';
                                            break;
                                        case 'téléphonie':
                                            $icon = 'mobile';
                                            break;
                                        default:
                                            $icon = 'box';
                                    }
                                }
                            @endphp
                            <img src="https://via.placeholder.com/60x60/4f46e5/ffffff?text={{ urlencode(substr($product->name, 0, 8)) }}" 
                                 alt="Image" 
                                 width="60" 
                                 height="60" 
                                 style="object-fit: contain; background-color: #f8f9fa; border-radius: 4px; border: 1px solid #dee2e6;">
                        @endif
                        <!-- Debug: {{ $mainImage->image_path }} -->
                    @else
                        <img src="https://via.placeholder.com/60x60/6c757d/ffffff?text=No+Img" alt="Aucune image" width="60" height="60" style="object-fit: contain; background-color: #f8f9fa; border-radius: 4px; border: 1px solid #dee2e6;">
                        <!-- Debug: Pas d'image pour {{ $product->name }} ({{ $product->images->count() }} images) -->
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                        Éditer
                    </a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce produit ?')">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
