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

                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        Accéder au catalogue
                    </a>

                </div>
            </div>
        </div>
    </div>
@endsection
