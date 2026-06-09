<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Daftar semua order user
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with(['items.product', 'payment'])
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // Detail satu order
    public function show(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) abort(403);

        $order->load(['items.product', 'payment']);

        return view('orders.show', compact('order'));
    }
}