<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    // Tampilkan halaman keranjang
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with('items.product')
            ->first();

        return view('cart.index', compact('cart'));
    }

    // Tambah produk ke keranjang
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'size'       => 'nullable|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Cek apakah produk punya ukuran tapi tidak dipilih
        if ($product->sizes && count($product->sizes) > 0 && !$request->size) {
            return back()->with('error', 'Silakan pilih ukuran terlebih dahulu.');
        }

        // Ambil atau buat cart untuk user ini
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Cek apakah produk + ukuran yang sama sudah ada di keranjang
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('size', $request->size)
            ->first();

        if ($cartItem) {
            // Kalau sudah ada, tambah quantity
            $cartItem->increment('quantity', $request->quantity);
        } else {
            // Kalau belum ada, buat baru
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'size'       => $request->size,
                'quantity'   => $request->quantity,
            ]);
        }

        // Cek action: keranjang atau beli sekarang
        if ($request->action === 'beli') {
            return redirect('/cart');
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Update quantity item di keranjang
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        // Pastikan item ini milik user yang login
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    // Hapus item dari keranjang
    public function remove(CartItem $cartItem)
    {
        // Pastikan item ini milik user yang login
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}