@extends('layouts.admin')

@section('title', 'Créer une commande')

@section('content')
<div class="container mt-4">
    <h2>{{ isset($order) ? 'Modifier la commande' : 'Créer une commande' }}</h2>
    <form action="{{ isset($order) ? route('admin.orders.update', $order->id) : route('admin.orders.store') }}" method="POST">
        @csrf
        @if(isset($order))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="user_id" class="form-label">Client</label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Choisir un client --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ (old('user_id', $order->user_id ?? '') == $user->id) ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="total" class="form-label">Total (€)</label>
            <input type="number" name="total" class="form-control" step="0.01" value="{{ old('total', $order->total ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Statut de la commande</label>
            <select name="status" class="form-control" required>
                @php
                    $statuses = ['en attente', 'expédiée', 'livrée', 'annulée'];
                @endphp
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ (old('status', $order->status ?? '') == $status) ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="is_paid" class="form-label">Paiement</label>
            <select name="is_paid" class="form-control" required>
                <option value="0" {{ old('is_paid', $order->is_paid ?? 0) == 0 ? 'selected' : '' }}>Non payée</option>
                <option value="1" {{ old('is_paid', $order->is_paid ?? 0) == 1 ? 'selected' : '' }}>Payée</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">
            {{ isset($order) ? 'Mettre à jour' : 'Créer' }}
        </button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
