@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1>Modifier la commande #{{ $order->id }}</h1>
    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select name="status" id="status" class="form-select">
                <option value="en cours" {{ $order->status == 'en cours' ? 'selected' : '' }}>En cours</option>
                <option value="livrée" {{ $order->status == 'livrée' ? 'selected' : '' }}>Livrée</option>
                <option value="annulée" {{ $order->status == 'annulée' ? 'selected' : '' }}>Annulée</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
