@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1>Détail de la commande #{{ $order->id }}</h1>
    <ul class="list-group mb-4">
        <li class="list-group-item"><strong>Client :</strong> {{ $order->user->name ?? 'N/A' }} ({{ $order->user->email ?? 'N/A' }})</li>
        <li class="list-group-item"><strong>Date :</strong> {{ $order->created_at }}</li>
        <li class="list-group-item"><strong>Statut :</strong> {{ $order->status ?? 'N/A' }}</li>
        <li class="list-group-item"><strong>Total :</strong> {{ number_format($order->total, 0, ',', ' ') }} FCFA</li>
        @if($order->payment)
            <li class="list-group-item">
                <strong>Mode de paiement :</strong> {{ $order->payment->method }}<br>
                <strong>Statut du paiement :</strong> 
                <span class="badge {{ $order->payment->status == 'payé' ? 'bg-success' : 'bg-warning' }}">
                    {{ $order->payment->status }}
                </span>
                @if($order->payment->method == 'paiement à la livraison' && $order->payment->status == 'non payé')
                    <form action="{{ route('admin.orders.mark-as-paid', $order) }}" method="POST" class="d-inline ms-3">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success">Marquer comme payée</button>
                    </form>
                @endif
            </li>
        @endif
    </ul>
    <h4>Produits commandés</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-3">Retour à la liste</a>
</div>
@endsection
