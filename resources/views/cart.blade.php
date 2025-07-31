@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Mon Panier</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(count($cart) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix unitaire</th>
                        <th>Stock disponible</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $productId => $item)
                        @php 
                            $total += $item['price'] * $item['quantity'];
                            $product = \App\Models\Product::find($productId);
                        @endphp
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ number_format($item['price'], 0, ',', ' ') }} FCFA</td>
                            <td>
                                @if($product && $product->stock > 0)
                                    <span class="badge bg-success">{{ $product->stock }} disponibles</span>
                                @else
                                    <span class="badge bg-danger">Rupture</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('cart.update') }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $productId }}">
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $product ? $product->stock : 1 }}" style="width: 60px;">
                                    <button type="submit" class="btn btn-sm btn-warning">Mettre à jour</button>
                                </form>
                            </td>
                            <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} FCFA</td>
                            <td>
                                <form action="{{ route('cart.remove') }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $productId }}">
                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total :</strong></td>
                        <td><strong>{{ number_format($total, 0, ',', ' ') }} FCFA</strong></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end"><span>Frais de Livraison :</span></td>
                        <td><span class="text-primary fw-bold">{{ $total >= 50000 ? 'Offerts' : '2 000 FCFA' }}</span></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="d-flex flex-wrap justify-content-center gap-3 mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary flex-fill" style="min-width:180px;">Continuer mes achats</a>
            <form action="{{ route('cart.clear') }}" method="POST" class="mb-0 flex-fill" style="min-width:180px;">
                @csrf
                <button type="submit" class="btn btn-secondary w-100">Vider le panier</button>
            </form>
            <a href="{{ route('checkout') }}" class="btn btn-primary flex-fill" style="min-width:180px;">Passer commande</a>
        </div>
        <div class="mt-5 p-4 rounded shadow-sm text-center mx-auto" style="background:#f8fafc; max-width:600px;">
            <div class="d-flex flex-wrap justify-content-center gap-4 fs-5">
                <div><span style="font-size:2rem;">🚚</span><br><strong>Livraison rapide</strong></div>
                <div><span style="font-size:2rem;">🔄</span><br><strong>Retours faciles</strong></div>
                <div><span style="font-size:2rem;">🔒</span><br><strong>Paiement sécurisé</strong></div>
            </div>
        </div>
    @else
        <div class="text-center mt-5">
            <h3>Votre panier est vide</h3>
            <p>Ajoutez des produits depuis le catalogue pour commencer vos achats.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Voir le catalogue</a>
        </div>
    @endif
</div>
@endsection
