<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);
        
        // Vérifier le stock disponible
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', "Stock insuffisant pour {$product->name}. Stock disponible : {$product->stock}");
        }

        $cart = session('cart', []);

        // Si le produit existe déjà dans le panier, vérifier le stock total
        if (isset($cart[$request->product_id])) {
            $totalQuantity = $cart[$request->product_id]['quantity'] + $request->quantity;
            if ($product->stock < $totalQuantity) {
                return redirect()->back()->with('error', "Stock insuffisant pour {$product->name}. Vous avez déjà {$cart[$request->product_id]['quantity']} dans votre panier, stock disponible : {$product->stock}");
            }
            $cart[$request->product_id]['quantity'] = $totalQuantity;
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
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Panier vidé !');
    }
} 