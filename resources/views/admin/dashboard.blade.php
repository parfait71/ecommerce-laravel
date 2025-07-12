{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="text-center mt-5">
        <h1>Bienvenue dans le tableau de bord</h1>
        <p>Connecté en tant que <strong>{{ Auth::user()->name }}</strong></p>
    </div>
@endsection
