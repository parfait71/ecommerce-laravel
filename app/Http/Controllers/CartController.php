<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // Empêcher les admins d'accéder au panier
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', 'Les administrateurs ne peuvent pas accéder au panier. Cette fonctionnalité est réservée aux clients.');
        }

        $cart = session('cart', []);
        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        // Empêcher les admins d'ajouter des produits au panier
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->back()->with('error', 'Les administrateurs ne peuvent pas ajouter de produits au panier. Veuillez utiliser un compte client.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);
        $cart = session('cart', []);

        // Si le produit existe déjà dans le panier, augmenter la quantité
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] += $request->quantity;
        } else {
            // Sinon, ajouter le produit
            $cart[$request->product_id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->back()->with('success', 'Produit ajouté au panier !');
    }

    public function remove(Request $request)
    {
        // Empêcher les admins d'accéder au panier
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', 'Les administrateurs ne peuvent pas accéder au panier. Cette fonctionnalité est réservée aux clients.');
        }

        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $cart = session('cart', []);
        unset($cart[$request->product_id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier !');
    }

    public function update(Request $request)
    {
        // Empêcher les admins d'accéder au panier
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', 'Les administrateurs ne peuvent pas accéder au panier. Cette fonctionnalité est réservée aux clients.');
        }

        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session('cart', []);
        
        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index')->with('success', 'Quantité mise à jour !');
    }

    public function clear()
    {
        // Empêcher les admins d'accéder au panier
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', 'Les administrateurs ne peuvent pas accéder au panier. Cette fonctionnalité est réservée aux clients.');
        }

        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Panier vidé !');
    }
} 