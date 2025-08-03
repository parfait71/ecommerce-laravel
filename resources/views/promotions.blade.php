@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Promotions</h2>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
        <h3 class="text-lg font-bold mb-4">Nos offres du moment</h3>
        <p class="mb-4">Profitez de nos promotions exceptionnelles sur une sélection de produits !</p>
        <ul class="list-disc pl-6">
            <li class="mb-2">Livraison gratuite pour tout achat supérieur à <strong>100 000 FCFA</strong></li>
            <li class="mb-2"><strong>-10%</strong> sur la première commande avec le code Promo <strong>WELCOME10</strong></li>
            <li class="mb-2">Des offres spéciales chaque semaine sur le catalogue</li>
        </ul>
    </div>
@endsection
