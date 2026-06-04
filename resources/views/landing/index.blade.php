@extends('layouts.app')

@section('content')

    {{-- HERO --}}
    <section class="hero relative min-h-screen overflow-hidden flex items-end" id="hero" style="margin-top:70px;">
        <video id="heroVideo" muted playsinline loop class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
        </video>
        <div class="absolute inset-0 z-[1]" style="background:linear-gradient(to top,rgba(0,0,0,0.85) 0%,rgba(0,0,0,0.2) 60%,transparent 100%)"></div>
        <div class="relative z-[2] w-full px-20 pb-24">
            <div class="max-w-2xl">
                <p class="text-white/60 text-xs tracking-[4px] uppercase font-montserrat mb-4">Perlengkapan Bela Diri</p>
                <h1 class="font-bebas text-[65px] leading-[0.9] tracking-[2px] text-white mb-6">
                    KUALITAS<br>
                    <span style="color:#f6e1c2e8">PROFESIONAL</span><br>
                    TANPA KOMPROMI
                </h1>
                <p class="text-white/65 text-base font-montserrat mb-7 max-w-sm leading-relaxed">
                    Nyaman, aman, dan tahan lama — dirancang untuk mereka yang serius berlatih.
                </p>
                <div class="flex items-center gap-6">
                    <button class="cta-btn relative px-6 py-4 bg-white text-black font-bold font-montserrat text-sm tracking-widest uppercase hover:bg-neutral-200 transition-colors duration-300 cursor-pointer border-none">
                        BELANJA SEKARANG →
                    </button>
                </div>
            </div>
            <div class="absolute bottom-8 right-20 flex flex-col items-center gap-2 opacity-40">
                <div class="w-px h-12 bg-white animate-pulse"></div>
                <span class="text-white text-[10px] tracking-[3px] uppercase font-montserrat">Scroll</span>
            </div>
        </div>
    </section>

    {{-- STATS BAR --}}
    <section class="reveal bg-black text-white py-12 px-20 border-t border-white/10">
        <div class="max-w-[1200px] mx-auto grid grid-cols-4 gap-8 divide-x divide-white/10">
            <div class="text-center px-8">
                <p class="font-bebas text-5xl" style="color : #f6e1c2e8 ">4+</p>
                <p class="text-xs tracking-[3px] text-white/50 font-montserrat uppercase mt-1">Cabang Olahraga</p>
            </div>
            <div class="text-center px-8">
                <p class="font-bebas text-5xl text-white">100%</p>
                <p class="text-xs tracking-[3px] text-white/50 font-montserrat uppercase mt-1">Kualitas Profesional</p>
            </div>
            <div class="text-center px-8">
                <p class="font-bebas text-5xl text-white">500+</p>
                <p class="text-xs tracking-[3px] text-white/50 font-montserrat uppercase mt-1">Produk Tersedia</p>
            </div>
            <div class="text-center px-8">
                <p class="font-bebas text-5xl text-white">2026</p>
                <p class="text-xs tracking-[3px] text-white/50 font-montserrat uppercase mt-1">Est. Indonesia</p>
            </div>
        </div>
    </section>

    {{-- DISCIPLINE BANNER --}}
    <section class="relative w-full h-[480px] overflow-hidden bg-black">
        <div class="absolute top-8 left-20 z-[3]">
            <p class="text-white/40 text-[10px] tracking-[5px] uppercase font-montserrat">Our Discipline</p>
        </div>

        <div class="banner-item active absolute inset-0 transition-all duration-700" data-banner="taekwondo" style="opacity:1;transform:scale(1);z-index:1;">
            <div class="absolute inset-0 bg-black/50 z-[1]"></div>
            <img src="/images/taekwondo/banner2.jpg" alt="Taekwondo"  class="w-full h-full object-cover" style="object-position: 90% 25%; scale:1.05;">
            <div class="absolute bottom-12 left-20 z-[2] text-white">
                <p class="text-[10px] tracking-[5px] text-white/50 font-montserrat uppercase mb-2">01 / Taekwondo</p>
                <h2 class="font-bebas text-[72px] leading-none tracking-[4px]">TAEKWONDO</h2>
                <p class="text-sm tracking-[3px] opacity-60 font-montserrat mt-2">Precision. Discipline. Control.</p>
            </div>
        </div>

        <div class="banner-item absolute inset-0 transition-all duration-700" data-banner="karate" style="opacity:0;transform:scale(1.05);z-index:0;">
            <div class="absolute inset-0 bg-black/50 z-[1]"></div>
            <img src="/images/karate/banner.jpg" alt="Karate" class="w-full h-full object-cover" style="object-position: 10% 25%;">
            <div class="absolute bottom-12 left-20 z-[2] text-white">
                <p class="text-[10px] tracking-[5px] text-white/50 font-montserrat uppercase mb-2">02 / Karate</p>
                <h2 class="font-bebas text-[72px] leading-none tracking-[4px]">KARATE</h2>
                <p class="text-sm tracking-[3px] opacity-60 font-montserrat mt-2">Focus. Power. Respect.</p>
            </div>
        </div>

        <div class="banner-item absolute inset-0 transition-all duration-700" data-banner="silat" style="opacity:0;transform:scale(1.05);z-index:0;">
            <div class="absolute inset-0 bg-black/50 z-[1]"></div>
            <img src="/images/silat/banner.jpg" alt="Silat" class="w-full h-full object-cover" style="object-position: 30% 60%;">
            <div class="absolute bottom-12 left-20 z-[2] text-white">
                <p class="text-[10px] tracking-[5px] text-white/50 font-montserrat uppercase mb-2">03 / Silat</p>
                <h2 class="font-bebas text-[72px] leading-none tracking-[4px]">SILAT</h2>
                <p class="text-sm tracking-[3px] opacity-60 font-montserrat mt-2">Tradition. Flow. Instinct.</p>
            </div>
        </div>

        <div class="banner-item absolute inset-0 transition-all duration-700" data-banner="boxing" style="opacity:0;transform:scale(1.05);z-index:0;">
            <div class="absolute inset-0 bg-black/50 z-[1]"></div>
            <img src="/images/boxing/banner.jpg" alt="Boxing" class="w-full h-full object-cover" style="object-position: 0% 20%; scale:1.05;">
            <div class="absolute bottom-12 left-20 z-[2] text-white">
                <p class="text-[10px] tracking-[5px] text-white/50 font-montserrat uppercase mb-2">04 / Boxing</p>
                <h2 class="font-bebas text-[72px] leading-none tracking-[4px]">BOXING</h2>
                <p class="text-sm tracking-[3px] opacity-60 font-montserrat mt-2">Strength. Endurance. Grit.</p>
            </div>
        </div>

        {{-- Dot navigation --}}
        <div class="absolute bottom-12 right-20 z-[3] flex gap-3 items-center">
            <button class="banner-dot h-[2px] bg-white transition-all duration-300" style="width:32px;" data-banner="taekwondo"></button>
            <button class="banner-dot h-[2px] bg-white/30 transition-all duration-300" style="width:16px;" data-banner="karate"></button>
            <button class="banner-dot h-[2px] bg-white/30 transition-all duration-300" style="width:16px;" data-banner="silat"></button>
            <button class="banner-dot h-[2px] bg-white/30 transition-all duration-300" style="width:16px;" data-banner="boxing"></button>
        </div>
    </section>

    {{-- PRODUCTS --}}
    <section class="reveal px-20 pb-16 pt-16 bg-white">
        <div class="flex justify-between items-end mb-10 border-b border-black/10 pb-6">
            <div>
                <p class="text-[10px] tracking-[5px] text-black/40 font-montserrat uppercase mb-2">Koleksi Kami</p>
                <h2 id="section-title" class="font-bebas text-5xl tracking-[3px] m-0">PRODUK {{ strtoupper($categories->first()->name ?? 'KAMI') }}</h2>
            </div>
            <a href="{{ route('products.index')}}" class="text-xs font-montserrat tracking-widest uppercase text-black border-b border-black pb-1 hover:opacity-50 transition-opacity no-underline">Lihat Semua</a>
        </div>

        {{-- Category Tabs --}}
        <div class="relative flex gap-10 mb-10">
            <div class="category-indicator absolute bottom-0 h-[2px] bg-black transition-all duration-500 ease-out"></div>
            @foreach($categories as $cat)
                <button class="category-tab bg-transparent border-none text-sm tracking-[2px] font-montserrat cursor-pointer py-2 text-neutral-400 uppercase"
                        data-category="{{ $cat->slug }}">{{ $cat->name }}</button>
            @endforeach
        </div>

        {{-- Product Groups --}}
        @foreach($categories as $cat)
        <div class="product-group {{ $loop->first ? 'active' : '' }}" id="{{ $cat->slug }}" @if(!$loop->first) style="display:none;" @endif>
            <div class="products-wrapper relative overflow-hidden">
                <button class="scroll-btn left absolute left-[-20px] top-[40%] -translate-y-1/2 bg-white text-black border border-black/10 w-11 h-11 rounded-full cursor-pointer text-base shadow-md hover:bg-black hover:text-white transition-all z-10">&#10094;</button>
                <div class="product-scroll flex gap-6 overflow-x-auto pb-3" style="scrollbar-width:thin;scrollbar-color:#e5e5e5 transparent;">
                    @foreach($productsByCategory[$cat->slug] ?? [] as $product)
                    <div class="flex-none w-[240px] cursor-pointer group">
                        <div class="w-full h-[280px] bg-neutral-50 overflow-hidden relative">
                            <img src="/images/{{ $product->image }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute bottom-0 left-0 right-0 bg-black text-white text-xs tracking-widest text-center py-3 font-montserrat uppercase translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                <a href="{{ route('login') }}" class="text-white no-underline">Tambah ke Keranjang</a>
                            </div>
                        </div>
                        <div class="mt-3 px-1">
                            <h3 class="text-xs font-montserrat font-semibold leading-snug overflow-hidden mb-1"
                                style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">
                                {{ $product->name }}
                            </h3>
                            <p class="text-sm font-bold tracking-wider">{{ $product->formatted_price }}</p>
                            <p class="text-[10px] text-neutral-400 font-montserrat mt-1 tracking-wider">Terjual {{ $product->sold }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="scroll-btn right absolute right-[-20px] top-[40%] -translate-y-1/2 bg-white text-black border border-black/10 w-11 h-11 rounded-full cursor-pointer text-base shadow-md hover:bg-black hover:text-white transition-all z-10">&#10095;</button>
            </div>
        </div>
        @endforeach
    </section>

    {{-- BRAND STATEMENT (pengganti manifesto) --}}
    <section class="reveal bg-black text-white py-32 px-20 overflow-hidden relative">
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none overflow-hidden">
            <p class="font-bebas leading-none tracking-widest whitespace-nowrap opacity-[0.03]" style="font-size:200px;">DIAVOLO</p>
        </div>
        <div class="relative z-10 max-w-[1200px] mx-auto grid grid-cols-2 gap-24 items-center">
            <div>
                <p class="text-[10px] tracking-[5px] text-white/40 font-montserrat uppercase mb-6">Brand Philosophy</p>
                <h2 class="font-bebas leading-[0.9] tracking-[2px] mb-8" style="font-size:72px;">
                    BUILT FOR<br>
                    <span style="color: #f6e1c2e8">THOSE WHO</span><br>
                    NEVER STOP.
                </h2>
                <div class="w-12 h-[2px] bg-white/20 mb-8"></div>
                <a href="#" class="inline-block text-xs font-montserrat tracking-widest uppercase text-white border border-white/30 px-6 py-3 hover:bg-white hover:text-black transition-all duration-300 no-underline">
                    Tentang Kami
                </a>
            </div>
            <div class="space-y-8">
                <div class="border-l-2 pl-6" style="border-color : #f6e1c2e8">
                    <h4 class="font-montserrat font-bold text-sm tracking-widest uppercase mb-2">Kualitas Tanpa Kompromi</h4>
                    <p class="text-sm text-white/50 font-montserrat leading-relaxed">Setiap produk dirancang dengan standar profesional untuk mendukung performa terbaik kamu.</p>
                </div>
                <div class="border-l-2 border-white/20 pl-6">
                    <h4 class="font-montserrat font-bold text-sm tracking-widest uppercase mb-2">Untuk Semua Level</h4>
                    <p class="text-sm text-white/50 font-montserrat leading-relaxed">Dari pemula hingga atlet nasional — kami punya perlengkapan yang tepat untukmu.</p>
                </div>
                <div class="border-l-2 border-white/20 pl-6">
                    <h4 class="font-montserrat font-bold text-sm tracking-widest uppercase mb-2">4 Cabang Olahraga</h4>
                    <p class="text-sm text-white/50 font-montserrat leading-relaxed">Taekwondo, Karate, Silat, dan Boxing — semua kebutuhan bela dirimu di satu tempat.</p>
                </div>
            </div>
        </div>

        @if(session('status'))
        <div class="fixed top-24 left-1/2 -translate-x-1/2 z-[9999] bg-black text-white font-montserrat text-sm px-6 py-3 shadow-lg flex items-center gap-3"
            id="status-alert">
            <i class="fas fa-check-circle text-green-400"></i>
            {{ session('status') }}
            <button onclick="document.getElementById('status-alert').remove()" class="ml-4 text-gray-400 hover:text-white">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>
        @endif
    </section>

@endsection
