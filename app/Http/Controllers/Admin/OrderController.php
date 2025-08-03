<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'payment'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.orders.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric|min:0',
        ]);

        Order::create([
            'user_id' => $request->user_id,
            'total' => $request->total,
            'status' => 'en attente',
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Commande créée avec succès.');
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'total' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $order->update($request->all());

        return redirect()->route('admin.orders.index')
            ->with('success', 'Commande mise à jour avec succès !');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Commande supprimée avec succès !');
    }

    public function markAsPaid(Order $order)
    {
        if ($order->payment && $order->payment->method == 'paiement à la livraison') {
            $order->payment->update(['status' => 'payé']);
            $order->update(['payment_status' => 'payé']);
            return redirect()->route('admin.orders.index')->with('success', 'Commande marquée comme payée.');
        }
        
        return redirect()->route('admin.orders.index')->with('error', 'Cette commande ne peut pas être marquée comme payée.');
    }
}
