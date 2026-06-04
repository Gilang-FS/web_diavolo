@extends('layouts.app')

@section('content')

{{-- Padding atas karena navbar fixed --}}
<div class="pt-[120px]"></div>

{{-- HERO SECTION --}}
<section class="bg-black text-white px-20 py-16 relative overflow-hidden">
    {{-- Background decorative text --}}
    <div class="absolute right-10 top-1/2 -translate-y-1/2 text-[160px] font-bebas text-white opacity-5 select-none leading-none">
        FIGHT
    </div>
    <div class="relative z-10">
        <p class="font-montserrat text-xs tracking-[4px] text-gray-400 uppercase mb-3">Koleksi Lengkap</p>
        <h1 class="font-bebas text-6xl tracking-[4px] mb-4">Semua Produk</h1>
        <p class="font-montserrat text-sm text-gray-400 tracking-wider">
            Temukan perlengkapan beladiri terbaik untuk latihan dan pertandingan
        </p>
    </div>
</section>

{{-- FILTER & SEARCH BAR --}}
<section class="border-b border-gray-200 bg-white sticky top-0 z-[99] shadow-sm">
    <div class="px-20 py-4">
        <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-4 flex-wrap">

            {{-- Search Input --}}
            <div class="flex items-center border border-gray-300 hover:border-black transition-colors duration-200 flex-1 min-w-[200px]">
                <span class="px-3 text-gray-400">
                    <i class="fas fa-search text-sm"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari produk..."
                    class="py-2 pr-4 text-sm font-montserrat w-full outline-none text-black placeholder-gray-400"
                >
            </div>

            {{-- Filter Kategori --}}
            <div class="flex items-center gap-2 flex-wrap">
                {{-- Tombol "Semua" --}}
                <a href="{{ route('products.index', request()->except(['category', 'page'])) }}"
                   class="px-5 py-2 text-xs font-montserrat font-semibold tracking-wider transition-all duration-200
                   {{ !request('category') ? 'bg-black text-white' : 'border border-gray-300 text-gray-600 hover:border-black hover:text-black' }}">
                    Semua
                </a>

                {{-- Tombol per Kategori --}}
                @foreach($categories as $cat)
                <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                   class="px-5 py-2 text-xs font-montserrat font-semibold tracking-wider transition-all duration-200
                   {{ request('category') === $cat->slug ? 'bg-black text-white' : 'border border-gray-300 text-gray-600 hover:border-black hover:text-black' }}">
                    {{ $cat->name }}
                </a>
                @endforeach
            </div>

            {{-- Tombol Search (submit form) --}}
            <button type="submit"
                class="px-6 py-2 bg-black text-white text-xs font-montserrat font-semibold tracking-wider hover:bg-neutral-800 transition-all duration-200">
                Cari
            </button>

            {{-- Reset filter jika ada filter aktif --}}
            @if(request('search') || request('category'))
            <a href="{{ route('products.index') }}"
               class="px-4 py-2 border border-gray-300 text-gray-500 text-xs font-montserrat tracking-wider hover:border-black hover:text-black transition-all duration-200">
                <i class="fas fa-times mr-1"></i> Reset
            </a>
            @endif

        </form>
    </div>
</section>

{{-- INFO HASIL --}}
<section class="px-20 py-5 bg-white border-b border-gray-100">
    <p class="font-montserrat text-xs text-gray-500 tracking-wider">
        Menampilkan <span class="font-semibold text-black">{{ $products->count() }}</span>
        dari <span class="font-semibold text-black">{{ $products->total() }}</span> produk
        @if(request('search'))
            untuk "<span class="font-semibold text-black">{{ request('search') }}</span>"
        @endif
        @if(request('category'))
            @php $activeCat = $categories->firstWhere('slug', request('category')); @endphp
            @if($activeCat)
                dalam kategori <span class="font-semibold text-black">{{ $activeCat->name }}</span>
            @endif
        @endif
    </p>
</section>

{{-- PRODUCT GRID --}}
<section class="px-20 py-12 bg-white min-h-[400px]">

    @if($products->count() > 0)

    <div class="grid grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="group relative bg-white border border-gray-100 hover:border-black transition-all duration-300 hover:shadow-lg flex flex-col">

            {{-- Gambar Produk --}}
            <a href="{{ auth()->check() ? route('products.show', $product->slug) : route('login') }}"class="block overflow-hidden relative">
                <div class="aspect-square overflow-hidden bg-gray-50">
                    <img
                        src="{{ asset('images/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        onerror="this.src='https://placehold.co/400x400/f5f5f5/999?text=No+Image'"
                    >
                </div>

                {{-- Badge kategori --}}
                <span class="absolute top-3 left-3 bg-black text-white text-[10px] font-montserrat font-semibold tracking-widest px-2 py-1">
                    {{ strtoupper($product->category->name ?? '') }}
                </span>

                {{-- Badge stok habis --}}
                @if($product->stock === 0)
                <span class="absolute top-3 right-3 bg-red-600 text-white text-[10px] font-montserrat font-semibold tracking-widest px-2 py-1">
                    HABIS
                </span>
                @endif
            </a>

            {{-- Info Produk --}}
            <div class="p-4 flex flex-col flex-1">
                <a href="{{ route('products.show', $product->slug) }}" class="no-underline">
                    <h3 class="font-montserrat text-sm font-semibold text-black leading-snug mb-2 line-clamp-2 group-hover:opacity-70 transition-opacity">
                        {{ $product->name }}
                    </h3>
                </a>

                <div class="flex items-center justify-between mt-auto pt-3">
                    <div>
                        {{-- Harga --}}
                        @if($product->discount_price)
                            <p class="font-montserrat text-xs text-gray-400 line-through">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <p class="font-montserrat text-sm font-bold text-black">
                                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                            </p>
                        @else
                            <p class="font-montserrat text-sm font-bold text-black">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        @endif

                        {{-- Terjual --}}
                        @if($product->sold > 0)
                        <p class="font-montserrat text-[10px] text-gray-400 mt-1">
                            {{ $product->sold }} terjual
                        </p>
                        @endif
                    </div>
                </div>

                {{-- Tombol Tambah ke Keranjang --}}
                @if($product->stock > 0)
                @auth
                <form method="POST" action="{{ route('cart.add') }}" class="mt-3">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                        class="w-full py-2 bg-black text-white text-xs font-montserrat font-semibold tracking-wider
                            hover:bg-neutral-800 transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-shopping-bag text-xs"></i>
                        Tambah ke Keranjang
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}"
                class="mt-3 w-full py-2 bg-black text-white text-xs font-montserrat font-semibold tracking-wider
                        hover:bg-neutral-800 transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-shopping-bag text-xs"></i>
                    Tambah ke Keranjang
                </a>
                @endauth
                @else
                <button disabled
                    class="mt-3 w-full py-2 bg-gray-200 text-gray-400 text-xs font-montserrat font-semibold tracking-wider cursor-not-allowed">
                    Stok Habis
                </button>
                @endif

            </div>
        </div>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    @if($products->hasPages())
    <div class="mt-12 flex justify-center items-center gap-2">
        {{-- Prev --}}
        @if($products->onFirstPage())
            <span class="px-4 py-2 border border-gray-200 text-gray-300 text-xs font-montserrat cursor-not-allowed">
                &larr; Prev
            </span>
        @else
            <a href="{{ $products->previousPageUrl() }}"
               class="px-4 py-2 border border-gray-300 text-gray-600 text-xs font-montserrat hover:border-black hover:text-black transition-all">
                &larr; Prev
            </a>
        @endif

        {{-- Nomor halaman --}}
        @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
            @if($page == $products->currentPage())
                <span class="px-4 py-2 bg-black text-white text-xs font-montserrat font-semibold">
                    {{ $page }}
                </span>
            @else
                <a href="{{ $url }}"
                   class="px-4 py-2 border border-gray-300 text-gray-600 text-xs font-montserrat hover:border-black hover:text-black transition-all">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        {{-- Next --}}
        @if($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}"
               class="px-4 py-2 border border-gray-300 text-gray-600 text-xs font-montserrat hover:border-black hover:text-black transition-all">
                Next &rarr;
            </a>
        @else
            <span class="px-4 py-2 border border-gray-200 text-gray-300 text-xs font-montserrat cursor-not-allowed">
                Next &rarr;
            </span>
        @endif
    </div>
    @endif

    @else
    {{-- Kosong / tidak ada hasil --}}
    <div class="flex flex-col items-center justify-center py-24 text-center">
        <div class="text-8xl font-bebas text-gray-100 tracking-widest mb-4">KOSONG</div>
        <p class="font-montserrat text-sm text-gray-400 mb-6">
            @if(request('search') || request('category'))
                Tidak ada produk yang cocok dengan pencarianmu.
            @else
                Belum ada produk tersedia.
            @endif
        </p>
        @if(request('search') || request('category'))
        <a href="{{ route('products.index') }}"
           class="px-6 py-2 border border-black text-black text-xs font-montserrat font-semibold tracking-wider hover:bg-black hover:text-white transition-all duration-200">
            Lihat Semua Produk
        </a>
        @endif
    </div>
    @endif

</section>

@endsection
