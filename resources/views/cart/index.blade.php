@extends('layouts.app')

@section('content')

{{-- Padding atas karena navbar fixed --}}
<div class="pt-[88px]"></div>

{{-- BREADCRUMB --}}
<section class="px-20 py-4 border-b border-gray-100 bg-white">
    <nav class="flex items-center gap-2 font-montserrat text-xs text-gray-400 tracking-wider">
        <a href="{{ url('/') }}" class="hover:text-black transition-colors">Beranda</a>
        <span>/</span>
        <span class="text-black">Keranjang</span>
    </nav>
</section>

{{-- HEADER --}}
<section class="bg-black text-white px-20 py-10">
    <p class="font-montserrat text-xs tracking-[4px] text-gray-400 uppercase mb-2">Belanja</p>
    <h1 class="font-bebas text-5xl tracking-[4px]">Keranjang Saya</h1>
</section>

{{-- NOTIFIKASI --}}
@if(session('success'))
<div class="mx-20 mt-6 px-5 py-3 bg-green-50 border border-green-200 font-montserrat text-sm text-green-700 flex items-center gap-2">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mx-20 mt-6 px-5 py-3 bg-red-50 border border-red-200 font-montserrat text-sm text-red-600 flex items-center gap-2">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
</div>
@endif

{{-- KONTEN KERANJANG --}}
<section class="px-20 py-10 bg-white min-h-[400px]">

    @if($cart && $cart->items->count() > 0)

    <div class="flex gap-10">

        {{-- KOLOM KIRI: Daftar produk --}}
        <div class="flex-1">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                <p class="font-montserrat text-xs tracking-[2px] text-gray-400 uppercase">
                    {{ $cart->items->count() }} produk di keranjang
                </p>
                <a href="{{ route('products.index') }}"
                   class="font-montserrat text-xs tracking-wider text-gray-500 hover:text-black transition-colors">
                    <i class="fas fa-arrow-left mr-1"></i> Lanjut Belanja
                </a>
            </div>

            {{-- List item keranjang --}}
            @foreach($cart->items as $item)
            <div class="flex gap-5 py-6 border-b border-gray-100">

                {{-- Gambar --}}
                <a href="{{ route('products.show', $item->product->slug) }}" class="flex-shrink-0">
                    <div class="w-24 h-24 bg-gray-50 overflow-hidden border border-gray-100">
                        <img
                            src="{{ asset('images/' . $item->product->image) }}"
                            alt="{{ $item->product->name }}"
                            class="w-full h-full object-cover"
                            onerror="this.src='https://placehold.co/100x100/f5f5f5/999?text=No+Image'"
                        >
                    </div>
                </a>

                {{-- Info produk --}}
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            {{-- Kategori --}}
                            <p class="font-montserrat text-[10px] tracking-[2px] text-gray-400 uppercase mb-1">
                                {{ $item->product->category->name }}
                            </p>
                            {{-- Nama --}}
                            <a href="{{ route('products.show', $item->product->slug) }}"
                               class="font-montserrat text-sm font-semibold text-black hover:opacity-70 transition-opacity no-underline">
                                {{ $item->product->name }}
                            </a>
                            {{-- Ukuran --}}
                            @if($item->size)
                            <p class="font-montserrat text-xs text-gray-500 mt-1">
                                Ukuran: <span class="font-semibold text-black">{{ $item->size }}</span>
                            </p>
                            @endif
                        </div>

                        {{-- Tombol hapus --}}
                        <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-gray-300 hover:text-red-500 transition-colors ml-4"
                                onclick="return confirm('Hapus produk ini dari keranjang?')">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Harga & Quantity --}}
                    <div class="flex items-center justify-between mt-4">
                        {{-- Harga satuan --}}
                        <p class="font-montserrat text-sm font-bold text-black">
                            Rp {{ number_format($item->product->discount_price ?? $item->product->price, 0, ',', '.') }}
                        </p>

                        {{-- Quantity update --}}
                        <form method="POST" action="{{ route('cart.update', $item->id) }}"
                              class="flex items-center border border-gray-300">
                            @csrf
                            @method('PATCH')
                            <button type="button"
                                onclick="decreaseQty(this, {{ $item->id }})"
                                class="px-3 py-1 text-black hover:bg-gray-100 transition-colors font-montserrat text-sm font-semibold">
                                −
                            </button>
                            <input type="number" name="quantity"
                                id="qty-{{ $item->id }}"
                                value="{{ $item->quantity }}"
                                min="1"
                                max="{{ $item->product->stock }}"
                                class="w-12 text-center py-1 font-montserrat text-sm font-semibold outline-none border-x border-gray-300"
                                onchange="this.form.submit()">
                            <button type="button"
                                onclick="increaseQty(this, {{ $item->id }}, {{ $item->product->stock }})"
                                class="px-3 py-1 text-black hover:bg-gray-100 transition-colors font-montserrat text-sm font-semibold">
                                +
                            </button>
                        </form>

                        {{-- Subtotal --}}
                        <p class="font-montserrat text-sm font-bold text-black min-w-[100px] text-right">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- KOLOM KANAN: Ringkasan order --}}
        <div class="w-80 flex-shrink-0">
            <div class="border border-gray-200 p-6 sticky top-24">
                <h2 class="font-bebas text-2xl tracking-wider text-black mb-6 pb-4 border-b border-gray-100">
                    Ringkasan Order
                </h2>

                {{-- Detail harga --}}
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="font-montserrat text-xs text-gray-500 tracking-wider">
                            Subtotal ({{ $cart->items->sum('quantity') }} item)
                        </span>
                        <span class="font-montserrat text-xs font-semibold text-black">
                            Rp {{ number_format($cart->total, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-montserrat text-xs text-gray-500 tracking-wider">Ongkos Kirim</span>
                        <span class="font-montserrat text-xs font-semibold text-green-600">Gratis</span>
                    </div>
                </div>

                {{-- Total --}}
                <div class="flex justify-between py-4 border-t border-gray-200 mb-6">
                    <span class="font-montserrat text-sm font-bold text-black tracking-wider">TOTAL</span>
                    <span class="font-bebas text-2xl text-black tracking-wider">
                        Rp {{ number_format($cart->total, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Tombol Checkout --}}
                <a href="/checkout"
                   class="block w-full py-3 bg-black text-white font-montserrat text-sm font-semibold tracking-wider
                          hover:bg-neutral-800 transition-all duration-200 text-center">
                    Lanjut ke Checkout
                </a>

                {{-- Lanjut belanja --}}
                <a href="{{ route('products.index') }}"
                   class="block w-full py-3 mt-3 border border-gray-300 text-gray-600 font-montserrat text-sm font-semibold tracking-wider
                          hover:border-black hover:text-black transition-all duration-200 text-center">
                    Lanjut Belanja
                </a>
            </div>
        </div>

    </div>

    @else
    {{-- Keranjang kosong --}}
    <div class="flex flex-col items-center justify-center py-24 text-center">
        <div class="text-8xl font-bebas text-gray-100 tracking-widest mb-4">KOSONG</div>
        <i class="fas fa-shopping-bag text-4xl text-gray-200 mb-4"></i>
        <p class="font-montserrat text-sm text-gray-400 mb-8">
            Keranjang kamu masih kosong.<br>Yuk mulai belanja!
        </p>
        <a href="{{ route('products.index') }}"
           class="px-8 py-3 bg-black text-white font-montserrat text-sm font-semibold tracking-wider
                  hover:bg-neutral-800 transition-all duration-200">
            Lihat Produk
        </a>
    </div>
    @endif

</section>

@endsection

@push('scripts')
<script>
    function decreaseQty(btn, itemId) {
        const input = document.getElementById('qty-' + itemId);
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
            btn.closest('form').submit();
        }
    }

    function increaseQty(btn, itemId, maxStock) {
        const input = document.getElementById('qty-' + itemId);
        if (parseInt(input.value) < maxStock) {
            input.value = parseInt(input.value) + 1;
            btn.closest('form').submit();
        }
    }
</script>
@endpush