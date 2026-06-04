@extends('layouts.app')

@section('content')

{{-- Padding atas karena navbar fixed --}}
<div class="pt-[88px]"></div>

{{-- BREADCRUMB --}}
<section class="px-20 py-4 border-b border-gray-100 bg-white">
    <nav class="flex items-center gap-2 font-montserrat text-xs text-gray-400 tracking-wider">
        <a href="{{ url('/') }}" class="hover:text-black transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('products.index') }}" class="hover:text-black transition-colors">Produk</a>
        <span>/</span>
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-black transition-colors">
            {{ $product->category->name }}
        </a>
        <span>/</span>
        <span class="text-black truncate max-w-[200px]">{{ $product->name }}</span>
    </nav>
</section>

{{-- MAIN DETAIL --}}
<section class="px-20 py-12 bg-white">
    <div class="flex gap-16">

        {{-- KOLOM KIRI: Gambar --}}
        <div class="w-1/2">
            <div class="relative overflow-hidden bg-gray-50 border border-gray-100">
                <img
                    src="{{ asset('images/' . $product->image) }}"
                    alt="{{ $product->name }}"
                    class="w-full object-cover aspect-square"
                    onerror="this.src='https://placehold.co/600x600/f5f5f5/999?text=No+Image'"
                >

                {{-- Badge kategori --}}
                <span class="absolute top-4 left-4 bg-black text-white text-[10px] font-montserrat font-semibold tracking-widest px-3 py-1">
                    {{ strtoupper($product->category->name) }}
                </span>

                {{-- Badge stok habis --}}
                @if($product->stock === 0)
                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                    <span class="bg-red-600 text-white font-bebas text-4xl tracking-widest px-8 py-3">
                        STOK HABIS
                    </span>
                </div>
                @endif
            </div>
        </div>

        {{-- KOLOM KANAN: Info Produk --}}
        <div class="w-1/2 flex flex-col justify-start">

            {{-- Kategori --}}
            <p class="font-montserrat text-xs tracking-[3px] text-gray-400 uppercase mb-3">
                {{ $product->category->name }}
            </p>

            {{-- Nama Produk --}}
            <h1 class="font-bebas text-5xl tracking-wider text-black leading-tight mb-6">
                {{ $product->name }}
            </h1>

            {{-- Harga --}}
            <div class="mb-6 pb-6 border-b border-gray-100">
                @if($product->discount_price)
                    <p class="font-montserrat text-sm text-gray-400 line-through mb-1">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                    <p class="font-bebas text-4xl text-black tracking-wider">
                        Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                    </p>
                    @php
                        $diskon = round((($product->price - $product->discount_price) / $product->price) * 100);
                    @endphp
                    <span class="inline-block mt-2 bg-black text-white text-xs font-montserrat font-semibold px-2 py-1">
                        HEMAT {{ $diskon }}%
                    </span>
                @else
                    <p class="font-bebas text-4xl text-black tracking-wider">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>
                @endif
            </div>

            {{-- Info stok & terjual --}}
            <div class="flex items-center gap-6 mb-6">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full {{ $product->stock > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                    <span class="font-montserrat text-xs text-gray-600 tracking-wider">
                        @if($product->stock > 10)
                            Stok tersedia ({{ $product->stock }})
                        @elseif($product->stock > 0)
                            Stok terbatas ({{ $product->stock }} tersisa)
                        @else
                            Stok habis
                        @endif
                    </span>
                </div>
                @if($product->sold >= 0)
                <div class="flex items-center gap-2">
                    <i class="fas fa-shopping-bag text-gray-400 text-xs"></i>
                    <span class="font-montserrat text-xs text-gray-500 tracking-wider">
                        {{ $product->sold }} terjual
                    </span>
                </div>
                @endif
            </div>

            {{-- Deskripsi --}}
            @if($product->description)
            <div class="mb-8">
                <p class="font-montserrat text-xs font-semibold tracking-[2px] text-gray-400 uppercase mb-3">Deskripsi</p>
                <p class="font-montserrat text-sm text-gray-600 leading-relaxed">
                    {{ $product->description }}
                </p>
            </div>
            @endif

            {{-- Quantity & Tambah ke Keranjang --}}
           {{-- Pilihan Ukuran --}}
    @if($product->sizes && count($product->sizes) > 0)
    <div class="mb-6">
        <p class="font-montserrat text-xs font-semibold tracking-[2px] text-gray-400 uppercase mb-3">Ukuran</p>
        <div class="flex flex-wrap gap-2" id="size-options">
            @foreach($product->sizes as $size)
            <button type="button"
                onclick="selectSize('{{ $size }}')"
                id="size-{{ $size }}"
                class="size-btn px-4 py-2 border border-gray-300 font-montserrat text-sm font-semibold
                    hover:border-black hover:text-white hover:bg-black transition-all duration-200">
                {{ $size }}
            </button>
            @endforeach
        </div>
        {{-- Peringatan belum pilih ukuran --}}
        <p id="size-warning" class="hidden mt-2 font-montserrat text-xs text-red-500">
            Silakan pilih ukuran terlebih dahulu
        </p>
    </div>
    @endif

    {{-- Quantity & Tombol --}}
    @if($product->stock > 0)
    <form method="POST" action="{{ route('cart.add') }}" id="cart-form">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="size" id="selected-size" value="">

        {{-- Quantity selector --}}
        <div class="flex items-center gap-4 mb-6">
            <p class="font-montserrat text-xs font-semibold tracking-[2px] text-gray-400 uppercase">Jumlah</p>
            <div class="flex items-center border border-gray-300">
                <button type="button" onclick="decreaseQty()"
                    class="px-4 py-2 text-black hover:bg-gray-100 transition-colors font-montserrat text-sm font-semibold">
                    −
                </button>
                <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                    class="w-14 text-center py-2 font-montserrat text-sm font-semibold outline-none border-x border-gray-300">
                <button type="button" onclick="increaseQty({{ $product->stock }})"
                    class="px-4 py-2 text-black hover:bg-gray-100 transition-colors font-montserrat text-sm font-semibold">
                    +
                </button>
            </div>
            <span class="font-montserrat text-xs text-gray-400">Tersedia {{ $product->stock }}</span>
        </div>

        {{-- Tombol aksi --}}
        <div class="flex gap-3">
            <button type="button" onclick="submitCart('keranjang')"
                class="flex-1 py-3 border border-black text-black font-montserrat text-sm font-semibold tracking-wider
                    hover:bg-black hover:text-white transition-all duration-200 flex items-center justify-center gap-2">
                <i class="fas fa-shopping-bag"></i>
                Masukkan Keranjang
            </button>
            <button type="button" onclick="submitCart('beli')"
                class="flex-1 py-3 bg-black text-white font-montserrat text-sm font-semibold tracking-wider
                    hover:bg-neutral-800 transition-all duration-200 flex items-center justify-center gap-2">
                Beli Sekarang
            </button>
        </div>
        <input type="hidden" name="action" id="form-action" value="">
    </form>
    @else
    <button disabled
        class="w-full py-3 bg-gray-200 text-gray-400 font-montserrat text-sm font-semibold tracking-wider cursor-not-allowed">
        Stok Habis
    </button>
    @endif

        </div>
    </div>
</section>

{{-- PRODUK LAINNYA (same category) --}}
@php
    $related = \App\Models\Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->where('status', 'active')
        ->take(4)
        ->get();
@endphp

@if($related->count() > 0)
<section class="px-20 py-12 bg-gray-50 border-t border-gray-100">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="font-montserrat text-xs tracking-[3px] text-gray-400 uppercase mb-1">Kategori {{ $product->category->name }}</p>
            <h2 class="font-bebas text-4xl tracking-wider text-black">Produk Lainnya</h2>
        </div>
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
           class="font-montserrat text-xs tracking-wider text-gray-500 border border-gray-300 px-5 py-2 hover:border-black hover:text-black transition-all">
            Lihat Semua
        </a>
    </div>

    <div class="grid grid-cols-4 gap-6">
        @foreach($related as $rel)
        <div class="group bg-white border border-gray-100 hover:border-black transition-all duration-300 hover:shadow-lg">
            <a href="{{ route('products.show', $rel->slug) }}" class="block overflow-hidden">
                <div class="aspect-square overflow-hidden bg-gray-50">
                    <img
                        src="{{ asset('images/' . $rel->image) }}"
                        alt="{{ $rel->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        onerror="this.src='https://placehold.co/400x400/f5f5f5/999?text=No+Image'"
                    >
                </div>
            </a>
            <div class="p-4">
                <a href="{{ route('products.show', $rel->slug) }}" class="no-underline">
                    <h3 class="font-montserrat text-sm font-semibold text-black leading-snug mb-2 line-clamp-2 hover:opacity-70 transition-opacity">
                        {{ $rel->name }}
                    </h3>
                </a>
                <p class="font-montserrat text-sm font-bold text-black">
                    Rp {{ number_format($rel->discount_price ?? $rel->price, 0, ',', '.') }}
                </p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
    const hasSizes = {{ ($product->sizes && count($product->sizes) > 0) ? 'true' : 'false' }};
    let selectedSize = '';

    function selectSize(size) {
        // Reset semua tombol
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.classList.remove('bg-black', 'text-white', 'border-black');
            btn.classList.add('border-gray-300');
        });

        // Aktifkan tombol yang dipilih
        const btn = document.getElementById('size-' + size);
        btn.classList.add('bg-black', 'text-white', 'border-black');
        btn.classList.remove('border-gray-300');

        // Simpan ukuran yang dipilih
        selectedSize = size;
        document.getElementById('selected-size').value = size;

        // Sembunyikan peringatan
        document.getElementById('size-warning').classList.add('hidden');
    }

    function submitCart(action) {
        // Cek apakah produk punya ukuran tapi belum dipilih
        if (hasSizes && !selectedSize) {
            document.getElementById('size-warning').classList.remove('hidden');
            return; // Stop, jangan submit
        }

        // Set action (keranjang atau beli sekarang)
        document.getElementById('form-action').value = action;

        // Submit form
        document.getElementById('cart-form').submit();
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }

    function increaseQty(maxStock) {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) < maxStock) {
            input.value = parseInt(input.value) + 1;
        }
    }
</script>
@endpush