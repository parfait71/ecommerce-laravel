@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Passer commande</h1>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="address" class="form-label">Adresse de livraison</label>
            <input type="text" name="address" id="address" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mode de paiement</label><br>
            <select name="payment_method" class="form-select" required>
                <option value="paiement en ligne">Paiement avant livraison (en ligne)</option>
                <option value="paiement à la livraison">Paiement à la livraison</option>
            </select>
        </div>
        <h4>Votre panier</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ number_format($item['price'], 0, ',', ' ') }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @foreach($cart as $item)
            <input type="hidden" name="cart[] [product_id]" value="{{ $item['product_id'] }}">
            <input type="hidden" name="cart[] [quantity]" value="{{ $item['quantity'] }}">
            <input type="hidden" name="cart[] [price]" value="{{ $item['price'] }}">
        @endforeach
        <button type="submit" class="btn btn-primary mt-3">Valider la commande</button>
    </form>

    {{-- Paiement Wave --}}
    <form method="POST" action="{{ route('paiement.wave') }}" class="mt-3">
        @csrf
        <input type="hidden" name="amount" value="{{ array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)) }}">
        <button type="submit" class="btn btn-info w-full flex items-center justify-center gap-2">
            <span>🌊</span> Payer en ligne avec Wave
        </button>
    </form>
</div>
@endsection
