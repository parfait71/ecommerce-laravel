@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Détail de la commande #{{ $order->id }}</h1>
    <ul class="list-group mb-4">
        <li class="list-group-item"><strong>Date :</strong> {{ $order->created_at }}</li>
        <li class="list-group-item"><strong>Statut :</strong> {{ $order->status ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Total :</strong> {{ number_format($order->total, 0, ',', ' ') }} FCFA</li>
        @if($order->payment)
            <li class="list-group-item"><strong>Mode de paiement :</strong> {{ $order->payment->method }}</li>
            <li class="list-group-item"><strong>Statut du paiement :</strong> {{ $order->payment->status }}</li>
        @endif
    </ul>
    <h4>Produits commandés</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        <a href="{{ route('invoice.download', $order) }}" class="btn btn-primary">Télécharger la facture PDF</a>
        <a href="{{ route('invoice.view', $order) }}" class="btn btn-secondary" target="_blank">Voir la facture</a>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary ms-2">Retour à mes commandes</a>
    </div>
</div>
@endsection 