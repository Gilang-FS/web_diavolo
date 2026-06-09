@extends('layouts.app')

@section('content')
<div class="pt-[88px]"></div>

{{-- BREADCRUMB --}}
<section class="px-20 py-4 border-b border-gray-100 bg-white">
    <nav class="flex items-center gap-2 font-montserrat text-xs text-gray-400 tracking-wider">
        <a href="{{ url('/') }}" class="hover:text-black transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('orders.index') }}" class="hover:text-black transition-colors">Pesanan Saya</a>
        <span>/</span>
        <span class="text-black">{{ $order->order_number }}</span>
    </nav>
</section>

{{-- HEADER --}}
<section class="bg-black text-white px-20 py-10">
    <p class="font-montserrat text-xs tracking-[4px] text-gray-400 uppercase mb-2">Detail Pesanan</p>
    <h1 class="font-bebas text-4xl tracking-[4px]">{{ $order->order_number }}</h1>
</section>

<section class="px-20 py-10 bg-gray-50 min-h-screen">
    <div class="flex gap-6">

        {{-- KOLOM KIRI --}}
        <div class="flex-1 space-y-4">

            {{-- Status Order --}}
            @php
                $steps = ['pending', 'processing', 'shipped', 'delivered'];
                $currentStep = array_search($order->status, $steps);
                $statusLabel = match($order->status) {
                    'pending'    => 'Menunggu Pembayaran',
                    'processing' => 'Pesanan Diproses',
                    'shipped'    => 'Dalam Pengiriman',
                    'delivered'  => 'Pesanan Selesai',
                    'cancelled'  => 'Pesanan Dibatalkan',
                    default      => $order->status,
                };
            @endphp

            <div class="bg-white border border-gray-200 p-6">
                <h2 class="font-bebas text-xl tracking-wider mb-6">Status Pesanan</h2>

                @if($order->status !== 'cancelled')
                <div class="flex items-center justify-between mb-2">
                    @foreach(['pending' => 'Pembayaran', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'delivered' => 'Selesai'] as $step => $label)
                    @php $stepIndex = array_search($step, $steps); @endphp
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-montserrat text-xs font-bold
                            {{ $currentStep >= $stepIndex ? 'bg-black text-white' : 'bg-gray-200 text-gray-400' }}">
                            @if($currentStep > $stepIndex)
                                <i class="fas fa-check text-xs"></i>
                            @else
                                {{ $stepIndex + 1 }}
                            @endif
                        </div>
                        <p class="font-montserrat text-[10px] tracking-wider mt-2 text-center
                            {{ $currentStep >= $stepIndex ? 'text-black font-semibold' : 'text-gray-400' }}">
                            {{ $label }}
                        </p>
                    </div>
                    @if(!$loop->last)
                    <div class="h-[2px] flex-1 mb-5 {{ $currentStep > $stepIndex ? 'bg-black' : 'bg-gray-200' }}"></div>
                    @endif
                    @endforeach
                </div>
                @else
                <div class="flex items-center gap-2 text-red-500">
                    <i class="fas fa-times-circle"></i>
                    <span class="font-montserrat text-sm font-semibold">Pesanan Dibatalkan</span>
                </div>
                @endif
            </div>

            {{-- Produk Dipesan --}}
            <div class="bg-white border border-gray-200 p-6">
                <h2 class="font-bebas text-xl tracking-wider mb-4">Produk Dipesan</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex gap-4 py-3 border-b border-gray-50 last:border-0">
                        <div class="w-16 h-16 flex-shrink-0 bg-gray-50 overflow-hidden">
                            <img src="{{ asset('images/' . ($item->product->image ?? '')) }}"
                                 alt="{{ $item->product_name }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='https://placehold.co/64x64/f5f5f5/999?text=No'">
                        </div>
                        <div class="flex-1">
                            <p class="font-montserrat text-sm font-semibold text-black">{{ $item->product_name }}</p>
                            <p class="font-montserrat text-xs text-gray-500 mt-1">
                                {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <p class="font-montserrat text-sm font-bold text-black">
                            Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                        </p>
                    </div>
                    @endforeach
                </div>

                {{-- Total --}}
                <div class="space-y-2 mt-4 pt-4 border-t border-gray-100">
                    <div class="flex justify-between">
                        <span class="font-montserrat text-xs text-gray-500">Subtotal</span>
                        <span class="font-montserrat text-xs font-semibold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-montserrat text-xs text-gray-500">Ongkos Kirim</span>
                        <span class="font-montserrat text-xs font-semibold text-green-600">Gratis</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-100">
                        <span class="font-montserrat text-sm font-bold">TOTAL</span>
                        <span class="font-bebas text-2xl tracking-wider">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Info Pengiriman --}}
            <div class="bg-white border border-gray-200 p-6">
                <h2 class="font-bebas text-xl tracking-wider mb-4">Alamat Pengiriman</h2>
                <p class="font-montserrat text-sm font-bold text-black">{{ $order->recipient_name }}</p>
                <p class="font-montserrat text-xs text-gray-500 mt-1">{{ $order->phone }}</p>
                <p class="font-montserrat text-xs text-gray-500 mt-1">
                    {{ $order->address }}, {{ $order->city }}, {{ $order->province }} {{ $order->postal_code }}
                </p>
                @if($order->notes)
                <p class="font-montserrat text-xs text-gray-400 mt-2 italic">Catatan: {{ $order->notes }}</p>
                @endif
            </div>

        </div>

        {{-- KOLOM KANAN --}}
        <div class="w-72 flex-shrink-0 self-start space-y-4">

            {{-- Info Pembayaran --}}
            <div class="bg-white border border-gray-200 p-6">
                <h2 class="font-bebas text-xl tracking-wider mb-4">Info Pembayaran</h2>
                @if($order->payment)
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="font-montserrat text-xs text-gray-500">Metode</span>
                        <span class="font-montserrat text-xs font-semibold uppercase">{{ $order->payment->payment_method }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-montserrat text-xs text-gray-500">Status</span>
                        @php
                            $payColor = match($order->payment->status) {
                                'paid'    => 'text-green-600',
                                'pending' => 'text-yellow-600',
                                'failed'  => 'text-red-600',
                                default   => 'text-gray-600',
                            };
                        @endphp
                        <span class="font-montserrat text-xs font-semibold {{ $payColor }} uppercase">
                            {{ $order->payment->status }}
                        </span>
                    </div>
                </div>
                @else
                <p class="font-montserrat text-xs text-gray-400">Belum ada info pembayaran.</p>
                @endif
            </div>

            {{-- Tombol aksi --}}
            <div class="bg-white border border-gray-200 p-6 space-y-3">
                <a href="{{ route('orders.index') }}"
                    class="block w-full py-3 border border-gray-300 text-gray-600 font-montserrat text-xs font-semibold tracking-wider text-center hover:border-black hover:text-black transition-all">
                    Kembali ke Pesanan
                </a>
                <a href="{{ route('products.index') }}"
                    class="block w-full py-3 bg-black text-white font-montserrat text-xs font-semibold tracking-wider text-center hover:bg-neutral-800 transition-all">
                    Belanja Lagi
                </a>
            </div>

        </div>
    </div>
</section>
@endsection