@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Paiement Wave</h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Paiement de votre commande #{{ $order->id }}</h3>
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/wave.png') }}" alt="Wave" class="h-8 w-8">
                    <span class="text-sm text-gray-600">Wave</span>
                </div>
            </div>

            <!-- Résumé de la commande -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h4 class="font-medium text-gray-900 mb-3">Résumé de votre commande</h4>
                <div class="space-y-2">
                    @foreach($order->items as $item)
                    <div class="flex justify-between text-sm">
                        <span>{{ $item->product->name }} x{{ $item->quantity }}</span>
                        <span>{{ number_format($item->price * $item->quantity, 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endforeach
                    <hr class="my-2">
                    <div class="flex justify-between font-medium">
                        <span>Total</span>
                        <span>{{ number_format($order->total, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            <!-- Formulaire de paiement -->
            <form id="wavePaymentForm" class="space-y-4">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="amount" value="{{ $order->total }}">

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Numéro de téléphone Wave
                    </label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ex: 770000000"
                           pattern="[0-9]{9}"
                           required>
                    <p class="text-xs text-gray-500 mt-1">Entrez votre numéro de téléphone Wave (9 chiffres)</p>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Informations importantes</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Assurez-vous d'avoir suffisamment de crédit sur votre compte Wave</li>
                                    <li>Vous recevrez un SMS de confirmation de Wave</li>
                                    <li>Le paiement sera traité instantanément</li>
                                    <li>Vous recevrez un email de confirmation après le paiement</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('orders.show', $order) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Retour à la commande
                    </a>
                    <button type="submit" 
                            id="payButton"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Payer {{ number_format($order->total, 0, ',', ' ') }} FCFA
                    </button>
                </div>
            </form>

            <!-- Zone de statut -->
            <div id="paymentStatus" class="mt-6 hidden">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div id="statusIcon" class="h-6 w-6"></div>
                        </div>
                        <div class="ml-3">
                            <h3 id="statusTitle" class="text-sm font-medium text-gray-900"></h3>
                            <p id="statusMessage" class="text-sm text-gray-500"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('wavePaymentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const payButton = document.getElementById('payButton');
    const statusDiv = document.getElementById('paymentStatus');
    const statusIcon = document.getElementById('statusIcon');
    const statusTitle = document.getElementById('statusTitle');
    const statusMessage = document.getElementById('statusMessage');
    
    // Désactiver le bouton
    payButton.disabled = true;
    payButton.innerHTML = `
        <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Traitement en cours...
    `;
    
    // Afficher le statut
    statusDiv.classList.remove('hidden');
    statusIcon.innerHTML = `
        <svg class="animate-spin h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `;
    statusTitle.textContent = 'Initialisation du paiement...';
    statusMessage.textContent = 'Veuillez patienter pendant que nous initialisons votre paiement.';
    
    // Envoyer la requête
    fetch('/wave/payment/initiate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: JSON.stringify({
            order_id: form.querySelector('input[name="order_id"]').value,
            amount: form.querySelector('input[name="amount"]').value,
            phone: form.querySelector('input[name="phone"]').value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            statusIcon.innerHTML = `
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            `;
            statusTitle.textContent = 'Paiement initialisé avec succès !';
            statusMessage.textContent = 'Vous allez recevoir un SMS de Wave pour confirmer le paiement.';
            
            // Rediriger après 3 secondes
            setTimeout(() => {
                window.location.href = '/orders/' + form.querySelector('input[name="order_id"]').value;
            }, 3000);
        } else {
            throw new Error(data.error || 'Erreur lors du paiement');
        }
    })
    .catch(error => {
        statusIcon.innerHTML = `
            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        `;
        statusTitle.textContent = 'Erreur lors du paiement';
        statusMessage.textContent = error.message || 'Une erreur est survenue. Veuillez réessayer.';
        
        // Réactiver le bouton
        payButton.disabled = false;
        payButton.innerHTML = `
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            Payer ${form.querySelector('input[name="amount"]').value} FCFA
        `;
    });
});
</script>
@endsection 