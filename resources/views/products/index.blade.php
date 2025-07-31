<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center fw-bold text-primary fs-3 dark:text-yellow-400 transition">
            🛒 Catalogue des Produits
        </h2>
    </x-slot>

    <div class="py-4 bg-light dark:bg-gray-950 transition">
        <div class="container">
            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 bg-white dark:bg-gray-900 text-dark dark:text-white transition">
                            {{-- ✅ Affichage de l'image --}}
                            @if ($product->image && file_exists(public_path('storage/products/' . $product->image)))
                                <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('images/default.png') }}" class="card-img-top" alt="Image non disponible">
                            @endif

                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                                <p class="card-text text-muted dark:text-gray-300">{{ $product->description }}</p>
                                <p class="card-text text-success fw-semibold fs-5">
                                    {{ number_format($product->price, 0, ',', ' ') }} FCFA
                                </p>
                                <a href="#" class="btn btn-primary mt-2">Ajouter au panier</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-secondary dark:text-gray-400">
                        <p>Aucun produit disponible pour le moment. Revenez bientôt !</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
