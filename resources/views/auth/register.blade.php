<x-guest-layout>

    <div class="mb-10">
        <h3 class="font-bebas text-5xl tracking-[2px] leading-none mb-1">DAFTAR</h3>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-[10px] font-montserrat tracking-[3px] uppercase text-black/40 mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                class="w-full border-0 border-b border-black/15 px-0 py-3 text-sm font-montserrat focus:border-black focus:ring-0 outline-none bg-transparent transition-colors">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-[10px] font-montserrat tracking-[3px] uppercase text-black/40 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                class="w-full border-0 border-b border-black/15 px-0 py-3 text-sm font-montserrat focus:border-black focus:ring-0 outline-none bg-transparent transition-colors">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-[10px] font-montserrat tracking-[3px] uppercase text-black/40 mb-2">Password</label>
            <input type="password" name="password" required
                class="w-full border-0 border-b border-black/15 px-0 py-3 text-sm font-montserrat focus:border-black focus:ring-0 outline-none bg-transparent transition-colors">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label class="block text-[10px] font-montserrat tracking-[3px] uppercase text-black/40 mb-2">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required
                class="w-full border-0 border-b border-black/15 px-0 py-3 text-sm font-montserrat focus:border-black focus:ring-0 outline-none bg-transparent transition-colors">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full bg-black text-white py-4 text-xs font-montserrat font-bold tracking-[4px] uppercase hover:bg-neutral-800 transition-colors duration-300 border-none cursor-pointer mt-4">
            DAFTAR SEKARANG
        </button>
        <p class="text-xs font-montserrat text-black/30 tracking-wider">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-black font-semibold hover:opacity-50 transition-opacity no-underline">Masuk</a>
        </p>

    </form>
</x-guest-layout>