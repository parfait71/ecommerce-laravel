@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Détail de la commande #{{ $order->order_number }}</h1>
    {{-- Suppression de la liste des informations de la commande --}}
    <div class="mt-4">
        <a href="{{ route('invoice.download', $order) }}" class="btn btn-primary">Télécharger la facture PDF</a>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary ms-2">Retour à mes commandes</a>
    </div>
</div>
@endsection 