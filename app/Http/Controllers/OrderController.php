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
        $orders = Order::where('user_id', Auth::id())->with('payment')->orderByDesc('created_at')->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('orderItems.product', 'user');
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
        $request->validate([
            'address' => 'required|string|max:500|min:10',
            'payment_method' => 'required|in:paiement en ligne,paiement à la livraison',
            'cart' => 'required|array',
        ], [
            'address.required' => 'L\'adresse de livraison est obligatoire.',
            'address.min' => 'L\'adresse de livraison doit contenir au moins 10 caractères.',
            'address.max' => 'L\'adresse de livraison ne peut pas dépasser 500 caractères.',
            'payment_method.required' => 'Veuillez sélectionner un mode de paiement.',
            'payment_method.in' => 'Le mode de paiement sélectionné n\'est pas valide.',
            'cart.required' => 'Votre panier ne peut pas être vide.',
        ]);

        // Récupérer le panier depuis la session
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        // Vérifier le stock pour tous les produits
        foreach ($cart as $productId => $item) {
            $product = \App\Models\Product::find($productId);
            if (!$product) {
                return redirect()->back()->with('error', 'Produit non trouvé.');
            }
            
            if ($product->stock < $item['quantity']) {
                return redirect()->back()->with('error', "Stock insuffisant pour {$product->name}. Stock disponible : {$product->stock}");
            }
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
            // 'order_number' sera généré automatiquement
        ]);

        // Créer les OrderItems et décrémenter le stock
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
            
            // Décrémenter le stock
            $product = \App\Models\Product::find($productId);
            $product->decrement('stock', $item['quantity']);
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
