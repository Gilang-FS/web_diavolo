<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Address;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Setup Midtrans config
        Config::$serverKey    = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized  = config('services.midtrans.is_sanitized');
        Config::$is3ds        = config('services.midtrans.is_3ds');
    }

    // Tampilkan halaman checkout
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang kamu kosong!');
        }

        $addresses = auth()->user()->addresses()->get();
        $defaultAddress = auth()->user()->addresses()->where('is_default', true)->first();

        return view('checkout.index', compact('cart', 'addresses', 'defaultAddress'));
    }

    // Proses checkout & buat order
    public function process(Request $request)
    {
        $request->validate([
            'address_id'      => 'required|exists:addresses,id',
            'payment_method'  => 'required|string',
            'notes'           => 'nullable|string',
        ]);

        $address = Address::findOrFail($request->address_id);
        if ($address->user_id !== auth()->id()) abort(403);

        $cart = Cart::where('user_id', auth()->id())
            ->with('items.product')
            ->first();

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang kamu kosong!');
        }

        $order = Order::create([
            'user_id'        => auth()->id(),
            'order_number'   => Order::generateOrderNumber(),
            'subtotal'       => $cart->total,
            'shipping_cost'  => 0,
            'total'          => $cart->total,
            'status'         => 'pending',
            'recipient_name' => $address->recipient_name,
            'phone'          => $address->phone,
            'address'        => $address->address,
            'city'           => $address->city,
            'province'       => $address->province,
            'postal_code'    => $address->postal_code,
            'notes'          => $request->notes,
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item->product_id,
                'product_name' => $item->product->name,
                'quantity'     => $item->quantity,
                'price'        => $item->product->active_price,
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email'      => auth()->user()->email,
                'phone'      => $address->phone,
            ],
            'item_details' => $cart->items->map(function ($item) {
                return [
                    'id'       => $item->product_id,
                    'price'    => (int) $item->product->active_price,
                    'quantity' => $item->quantity,
                    'name'     => substr($item->product->name, 0, 50),
                ];
            })->toArray(),
        ];

        $snapToken = Snap::getSnapToken($params);

        Payment::create([
            'order_id'        => $order->id,
            'payment_method'  => $request->payment_method,
            'payment_channel' => 'snap',
            'amount'          => $order->total,
            'status'          => 'pending',
            'transaction_id'  => $snapToken,
        ]);

        $cart->items()->delete();

        return view('checkout.payment', compact('order', 'snapToken'));
    }

    // Callback dari Midtrans (notifikasi otomatis)
    public function callback(Request $request)
    {
        $serverKey    = config('services.midtrans.server_key');
        $hashedKey    = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($hashedKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $payment = Payment::where('order_id', function ($query) use ($request) {
            $query->select('id')->from('orders')
                ->where('order_number', $request->order_id);
        })->first();

        if ($payment) {
            if (in_array($request->transaction_status, ['capture', 'settlement'])) {
                $payment->update(['status' => 'paid']);
                $payment->order->update(['status' => 'processing']);
            } elseif (in_array($request->transaction_status, ['cancel', 'deny', 'expire'])) {
                $payment->update(['status' => 'failed']);
                $payment->order->update(['status' => 'cancelled']);
            }
        }

        return response()->json(['message' => 'OK']);
    }
}