@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Liste des commandes</h1>
            <!-- Bouton de création supprimé pour respecter la consigne -->
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Utilisateur</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Mode de paiement</th>
                    <th>Statut de paiement</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ number_format($order->total, 0, ',', ' ') }} FCFA</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->payment ? $order->payment->method : 'N/A' }}</td>
                        <td>
                            @if($order->payment)
                                <span class="badge {{ $order->payment->status == 'payé' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $order->payment->status }}
                                </span>
                            @else
                                <span class="badge bg-secondary">N/A</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">Voir</a>
                            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-warning">Modifier</a>
                            @if($order->payment && $order->payment->method == 'paiement à la livraison' && $order->payment->status == 'non payé')
                                <form action="{{ route('admin.orders.mark-as-paid', $order) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Marquer comme payée</button>
                                </form>
                            @endif
                            <a href="{{ route('invoice.download', $order) }}" class="btn btn-sm btn-primary">Télécharger Facture</a>
                            <a href="{{ route('invoice.view', $order) }}" class="btn btn-sm btn-secondary" target="_blank">Voir Facture</a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette commande ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Aucune commande trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
