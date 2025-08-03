<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Services\EmailService;

class OrderController extends Controller
{
    public function index()
    {
        // Empêcher les admins de voir leurs commandes
        if (Auth::user() && Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'Les administrateurs ne peuvent pas consulter leurs commandes. Cette fonctionnalité est réservée aux clients.');
        }

        $orders = Order::where('user_id', Auth::id())
            ->with(['payment', 'products'])
            ->orderByDesc('created_at')
            ->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('products', 'user');
        if (Auth::user() && Auth::user()->is_admin) {
            return view('admin.orders.show', compact('order'));
        } else {
            return view('orders.show', compact('order'));
        }
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);
        $order->status = $request->input('status');
        $order->save();
        return redirect()->route('admin.orders.index')->with('success', 'Statut de la commande mis à jour.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Commande supprimée.');
    }

    public function store(Request $request)
    {
        // Empêcher les admins de passer des commandes
        if (Auth::user() && Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Les administrateurs ne peuvent pas passer de commandes. Veuillez utiliser un compte client.');
        }

        $request->validate([
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:paiement en ligne,paiement à la livraison',
            'cart' => 'required|array',
        ]);

        // Récupérer le panier depuis la session
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        // Calculer le total
        $total = collect($cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'en attente',
            'payment_status' => 'non payé',
        ]);

        // Créer les OrderItems
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Créer le paiement associé
        Payment::create([
            'order_id' => $order->id,
            'method' => $request->payment_method,
            'status' => 'non payé',
        ]);

        // Vider le panier après création de la commande
        session()->forget('cart');

        // Envoyer l'email de confirmation
        $emailService = new EmailService();
        $emailService->sendOrderConfirmation($order);

        return redirect()->route('orders.show', $order)->with('success', 'Commande passée avec succès ! Un email de confirmation vous a été envoyé.');
    }
}
