<x-guest-layout>
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="mb-10">
        <h3 class="font-bebas text-5xl tracking-[2px] leading-none mb-1">MASUK</h3>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">

        @if(session('url.intended') || request()->is('login'))
            <div class="mb-4 px-5 py-3 bg-yellow-50 border border-yellow-200 font-montserrat text-sm text-yellow-700 flex items-center gap-2">
                <i class="fas fa-exclamation-triangle"></i>
                Silakan login terlebih dahulu untuk melanjutkan belanja.
            </div>
        @endif
        @csrf

        <div>
            <label class="block text-[10px] font-montserrat tracking-[3px] uppercase text-black/40 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full border-0 border-b border-black/15 px-0 py-3 text-sm font-montserrat focus:border-black focus:ring-0 outline-none bg-transparent transition-colors">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label class="block text-[10px] font-montserrat tracking-[3px] uppercase text-black/40 mb-2">Password</label>
            <input type="password" name="password" required
                class="w-full border-0 border-b border-black/15 px-0 py-3 text-sm font-montserrat focus:border-black focus:ring-0 outline-none bg-transparent transition-colors">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="w-3 h-3 accent-black">
                <span class="text-[10px] font-montserrat text-black/30 tracking-wider uppercase">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                    class="text-[10px] font-montserrat text-black/30 hover:text-black transition-colors tracking-wider uppercase no-underline">
                    Lupa password?
                </a>
            @endif
        </div>

        <button type="submit"
            class="w-full bg-black text-white py-4 text-xs font-montserrat font-bold tracking-[4px] uppercase hover:bg-neutral-800 transition-colors duration-300 border-none cursor-pointer mt-4">
            MASUK
        </button>
        <p class="text-xs font-montserrat text-black/30 tracking-wider">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-black font-semibold hover:opacity-50 transition-opacity no-underline">Daftar</a>
        </p>

    </form>
</x-guest-layout>