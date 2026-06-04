@extends('layouts.app')

@section('content')

<div class="pt-[88px]"></div>

{{-- HEADER --}}
<section class="bg-black text-white px-20 py-10">
    <p class="font-montserrat text-xs tracking-[4px] text-gray-400 uppercase mb-2">Selesaikan Pembayaran</p>
    <h1 class="font-bebas text-5xl tracking-[4px]">Pembayaran</h1>
</section>

<section class="px-20 py-10 bg-white">
    <div class="max-w-lg mx-auto text-center">

        {{-- Info Order --}}
        <div class="border border-gray-200 p-8 mb-8">
            <p class="font-montserrat text-xs tracking-[3px] text-gray-400 uppercase mb-2">Nomor Order</p>
            <p class="font-bebas text-3xl tracking-wider text-black mb-6">{{ $order->order_number }}</p>

            <div class="flex justify-between py-3 border-t border-gray-100">
                <span class="font-montserrat text-xs text-gray-500">Total Pembayaran</span>
                <span class="font-montserrat text-sm font-bold text-black">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </span>
            </div>
            <div class="flex justify-between py-3 border-t border-gray-100">
                <span class="font-montserrat text-xs text-gray-500">Status</span>
                <span class="font-montserrat text-xs font-semibold text-yellow-600 uppercase tracking-wider">Menunggu Pembayaran</span>
            </div>
        </div>

        {{-- Tombol Bayar --}}
        <button id="pay-button"
            class="w-full py-4 bg-black text-white font-montserrat text-sm font-semibold tracking-wider hover:bg-neutral-800 transition-all duration-200 flex items-center justify-center gap-2 mb-4">
            <i class="fas fa-credit-card"></i>
            Bayar Sekarang
        </button>

        <a href="{{ route('cart.index') }}"
            class="block w-full py-3 border border-gray-300 text-gray-500 font-montserrat text-sm font-semibold tracking-wider hover:border-black hover:text-black transition-all duration-200 text-center">
            Kembali ke Keranjang
        </a>

        <p class="font-montserrat text-[10px] text-gray-400 mt-4">
            <i class="fas fa-shield-alt mr-1"></i>
            Pembayaran diproses secara aman oleh Midtrans
        </p>
    </div>
</section>

@endsection

@push('scripts')
{{-- Midtrans Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script>
    const snapToken = "{{ $snapToken }}";

    // Otomatis buka popup Midtrans saat halaman load
    window.onload = function() {
        snap.pay(snapToken, {
            onSuccess: function(result) {
                window.location.href = "/orders";
            },
            onPending: function(result) {
                window.location.href = "/orders";
            },
            onError: function(result) {
                alert('Pembayaran gagal! Silakan coba lagi.');
            },
            onClose: function() {
                // User tutup popup tanpa bayar
            }
        });
    };

    // Tombol bayar manual (kalau popup tidak muncul otomatis)
    document.getElementById('pay-button').addEventListener('click', function() {
        snap.pay(snapToken);
    });
</script>
@endpush