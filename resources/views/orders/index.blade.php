@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Mes commandes</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Mode de paiement</th>
                <th>Statut paiement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->payment ? $order->payment->method : 'N/A' }}</td>
                    <td>{{ $order->payment ? $order->payment->status : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">Voir</a>
                        <a href="{{ route('invoice.download', $order) }}" class="btn btn-sm btn-primary">Télécharger Facture</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Aucune commande trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
