<header id="header" class="fixed top-0 left-0 w-full z-[999] transition-transform duration-300">

    {{-- Top black bar --}}
    <div class="bg-black w-full py-2 text-center text-white text-xs tracking-widest font-montserrat">
        FREE SHIPPING FOR ORDERS ABOVE Rp 500.000
    </div>

    {{-- Main navbar --}}
    <nav class="bg-white flex justify-between items-center px-20 py-[18px] w-full relative">

        {{-- Logo --}}
        <div>
            <a href="{{ url('/') }}" class="font-bebas text-2xl tracking-[3px] text-black no-underline hover:opacity-70 transition-opacity">
                Diavolo Apparel
            </a>
        </div>

        {{-- Nav Links --}}
        <ul class="flex list-none gap-16 m-0 p-0">
            <li><a href="{{ url('/')}}" class="nav-link text-black font-montserrat text-sm tracking-wider opacity-85 no-underline relative hover:opacity-100">Beranda</a></li>
            <li><a href="{{ route('products.index')}}" class="nav-link text-black font-montserrat text-sm tracking-wider opacity-85 no-underline relative hover:opacity-100">Produk</a></li>
            <li><a href="#" class="nav-link text-black font-montserrat text-sm tracking-wider opacity-85 no-underline relative hover:opacity-100">Kontak</a></li>
            <li><a href="#" class="nav-link text-black font-montserrat text-sm tracking-wider opacity-85 no-underline relative hover:opacity-100">Tentang Kami</a></li>
        </ul>

        {{-- Auth Buttons --}}
    <div class="flex items-center gap-4">
        @auth
        {{-- User sudah login --}}

        {{-- Ikon Keranjang --}}
        <a href="/cart" class="relative flex items-center text-black hover:opacity-70 transition-opacity">
            <i class="fas fa-shopping-bag text-lg"></i>
            @php
                $cartCount = auth()->user()->cart?->cartItems()->sum('quantity') ?? 0;
            @endphp
            @if($cartCount > 0)
            <span class="absolute -top-2 -right-2 bg-black text-white text-[10px] font-montserrat font-bold w-4 h-4 rounded-full flex items-center justify-center">
                {{ $cartCount > 9 ? '9+' : $cartCount }}
            </span>
            @endif
        </a>

        {{-- Dropdown Profil --}}
        <div class="relative" id="profile-dropdown">
            <button onclick="toggleDropdown()"
                class="flex items-center gap-2 font-montserrat text-sm font-semibold tracking-wider hover:opacity-70 transition-opacity">
                <i class="fas fa-user-circle text-lg"></i>
                <span class="max-w-[100px] truncate">{{ auth()->user()->name }}</span>
                <i class="fas fa-chevron-down text-xs"></i>
            </button>

            {{-- Menu dropdown --}}
            <div id="dropdown-menu"
                class="hidden absolute right-0 top-full mt-2 w-48 bg-white border border-gray-200 shadow-lg z-50">
                <a href="/profile" class="block px-4 py-3 font-montserrat text-xs tracking-wider text-gray-700 hover:bg-gray-50 hover:text-black transition-colors">
                    <i class="fas fa-user mr-2"></i> Profil Saya
                </a>
                <a href="/orders" class="block px-4 py-3 font-montserrat text-xs tracking-wider text-gray-700 hover:bg-gray-50 hover:text-black transition-colors">
                    <i class="fas fa-box mr-2"></i> Pesanan Saya
                </a>
                <div class="border-t border-gray-100"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-3 font-montserrat text-xs tracking-wider text-red-500 hover:bg-red-50 transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        @else
        {{-- User belum login --}}
        <a href="{{ route('login') }}" class="px-5 py-2 border border-black text-black text-sm font-semibold font-montserrat tracking-wider hover:bg-black hover:text-white transition-all duration-300">
            Masuk
        </a>
        <a href="{{ route('register') }}" class="px-5 py-2 bg-black text-white text-sm font-semibold font-montserrat tracking-wider hover:bg-neutral-800 transition-all duration-300">
            Daftar
        </a>
        @endauth
    </div>

    </nav>

    <script>
    function toggleDropdown() {
        const menu = document.getElementById('dropdown-menu');
        menu.classList.toggle('hidden');
    }

    // Tutup dropdown kalau klik di luar
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profile-dropdown');
        if (dropdown && !dropdown.contains(e.target)) {
            document.getElementById('dropdown-menu').classList.add('hidden');
        }
    });
</script>

</header>
