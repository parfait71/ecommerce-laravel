{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('header')
    <h2 class="text-center text-primary fw-bold fs-3">
        Dashboard
    </h2>
@endsection

@section('content')
    <div class="py-4 bg-light">
        <div class="container">
            <div class="card shadow border-0">
                <div class="card-body">

                    @if(Auth::check())
                        <div class="mb-4">
                            <h5 class="fw-bold">Informations Utilisateur</h5>
                            <p><strong>Email :</strong> {{ Auth::user()->email }}</p>
                            <p><strong>Rôle :</strong> {{ Auth::user()->is_admin ? 'ADMIN' : 'CLIENT' }}</p>
                        </div>
                    @endif

                    <a href="{{ route('products.index') }}" class="btn btn-primary mb-3">
                        Accéder au catalogue
                    </a>

                    <div class="d-flex flex-wrap gap-3 mt-4">
                        <a href="{{ route('about') }}" class="btn btn-outline-info">À propos</a>
                        <a href="{{ route('mentions-legales') }}" class="btn btn-outline-secondary">Mentions légales</a>
                        <a href="{{ route('politique-confidentialite') }}" class="btn btn-outline-primary">Politique de confidentialité</a>
                        <a href="{{ route('cgv') }}" class="btn btn-outline-success">CGV</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
