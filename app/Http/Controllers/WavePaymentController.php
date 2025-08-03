<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WavePaymentController extends Controller
{
    private $waveApiUrl;
    private $waveApiKey;

    public function __construct()
    {
        $this->waveApiUrl = config('services.wave.api_url', 'https://api.wave.com');
        $this->waveApiKey = config('services.wave.api_key');
    }

    /**
     * Initialiser un paiement Wave
     */
    public function initiatePayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:100',
            'phone' => 'required|string|regex:/^[0-9]{9}$/',
        ]);

        $order = Order::findOrFail($request->order_id);
        
        if ($order->user_id !== auth()->id()) {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->waveApiKey,
                'Content-Type' => 'application/json',
            ])->post($this->waveApiUrl . '/payments', [
                'amount' => $request->amount,
                'currency' => 'XOF',
                'phone' => $request->phone,
                'description' => 'Paiement commande #' . $order->id,
                'reference' => 'ORDER-' . $order->id,
                'callback_url' => route('wave.callback'),
            ]);

            if ($response->successful()) {
                $paymentData = $response->json();
                
                // Mettre à jour le paiement
                $payment = Payment::where('order_id', $order->id)->first();
                $payment->update([
                    'method' => 'wave',
                    'status' => 'en cours',
                    'transaction_id' => $paymentData['transaction_id'] ?? null,
                ]);

                return response()->json([
                    'success' => true,
                    'payment_url' => $paymentData['payment_url'] ?? null,
                    'transaction_id' => $paymentData['transaction_id'] ?? null,
                ]);
            }

            return response()->json(['error' => 'Erreur lors de l\'initialisation du paiement'], 400);

        } catch (\Exception $e) {
            Log::error('Erreur Wave Payment: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur de connexion au service de paiement'], 500);
        }
    }

    /**
     * Callback Wave après paiement
     */
    public function callback(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|string',
            'status' => 'required|string',
            'reference' => 'required|string',
        ]);

        try {
            // Vérifier le statut avec l'API Wave
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->waveApiKey,
            ])->get($this->waveApiUrl . '/payments/' . $request->transaction_id);

            if ($response->successful()) {
                $paymentData = $response->json();
                
                // Extraire l'ID de commande de la référence
                $orderId = str_replace('ORDER-', '', $request->reference);
                $order = Order::find($orderId);
                
                if ($order) {
                    $payment = Payment::where('order_id', $order->id)->first();
                    
                    if ($paymentData['status'] === 'SUCCESS') {
                        $payment->update([
                            'status' => 'payé',
                            'transaction_id' => $request->transaction_id,
                        ]);
                        
                        $order->update([
                            'status' => 'confirmé',
                            'payment_status' => 'payé',
                        ]);

                        // Envoyer email de confirmation
                        $emailService = new \App\Services\EmailService();
                        $emailService->sendOrderConfirmation($order);

                        return response()->json(['success' => true]);
                    } else {
                        $payment->update([
                            'status' => 'échoué',
                            'transaction_id' => $request->transaction_id,
                        ]);
                        
                        $order->update([
                            'status' => 'annulé',
                            'payment_status' => 'échoué',
                        ]);
                    }
                }
            }

            return response()->json(['error' => 'Statut de paiement invalide'], 400);

        } catch (\Exception $e) {
            Log::error('Erreur Wave Callback: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur de traitement du callback'], 500);
        }
    }

    /**
     * Vérifier le statut d'un paiement
     */
    public function checkStatus(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|string',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->waveApiKey,
            ])->get($this->waveApiUrl . '/payments/' . $request->transaction_id);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Impossible de vérifier le statut'], 400);

        } catch (\Exception $e) {
            Log::error('Erreur vérification statut Wave: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur de connexion'], 500);
        }
    }

    /**
     * Afficher la page de paiement Wave
     */
    public function showPaymentPage($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);
        
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.wave', compact('order'));
    }
} 