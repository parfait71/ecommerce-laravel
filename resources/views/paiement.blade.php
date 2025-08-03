@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Moyens de paiement</h2>
@endsection

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded shadow text-center">
        <h3 class="text-lg font-bold mb-4">Moyens de paiement acceptés sur EazyStore</h3>
        <div class="d-flex flex-wrap justify-content-center gap-4 mb-3 align-items-center">
            <img src="{{ asset('images/orange_money.png') }}" alt="Orange Money" style="height: 3rem; width: 3rem; object-fit: contain;" class="mx-2 rounded shadow" title="Orange Money">
            <img src="{{ asset('images/wave.png') }}" alt="Wave" style="height: 3rem; width: 3rem; object-fit: contain;" class="mx-2 rounded shadow" title="Wave">
            <img src="{{ asset('images/virement_bancaire.png') }}" alt="Virement bancaire" style="height: 3rem; width: 3rem; object-fit: contain;" class="mx-2 rounded shadow" title="Virement bancaire">
        </div>
        <ul class="list-unstyled mb-4">
            <li><strong>Orange Money</strong></li>
            <li><strong>Wave</strong></li>
            <li><strong>Virement bancaire</strong></li>
        </ul>
        <div class="text-muted">Choisissez le mode de paiement qui vous convient lors de la validation de votre commande.</div>
    </div>
@endsection 