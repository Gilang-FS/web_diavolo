@extends('layouts.app')

@section('content')
<div class="pt-[88px]"></div>

{{-- HEADER --}}
<section class="bg-black text-white px-20 py-10">
    <p class="font-montserrat text-xs tracking-[4px] text-gray-400 uppercase mb-2">Akun Saya</p>
    <h1 class="font-bebas text-5xl tracking-[4px]">Pesanan Saya</h1>
</section>

<section class="px-20 py-10 bg-gray-50 min-h-screen">

    @if($orders->count() > 0)
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="bg-white border border-gray-200 p-6">

            {{-- Header order --}}
            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
                <div>
                    <p class="font-montserrat text-xs text-gray-400 tracking-wider mb-1">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </p>
                    <p class="font-montserrat text-sm font-bold text-black tracking-wider">
                        {{ $order->order_number }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    {{-- Badge status --}}
                    @php
                        $statusColor = match($order->status) {
                            'pending'    => 'bg-yellow-100 text-yellow-700',
                            'processing' => 'bg-blue-100 text-blue-700',
                            'shipped'    => 'bg-purple-100 text-purple-700',
                            'delivered'  => 'bg-green-100 text-green-700',
                            'cancelled'  => 'bg-red-100 text-red-700',
                            default      => 'bg-gray-100 text-gray-600',
                        };
                        $statusLabel = match($order->status) {
                            'pending'    => 'Menunggu Pembayaran',
                            'processing' => 'Diproses',
                            'shipped'    => 'Dikirim',
                            'delivered'  => 'Selesai',
                            'cancelled'  => 'Dibatalkan',
                            default      => $order->status,
                        };
                    @endphp
                    <span class="font-montserrat text-xs font-semibold px-3 py-1 {{ $statusColor }}">
                        {{ $statusLabel }}
                    </span>
                    <a href="{{ route('orders.show', $order->id) }}"
                        class="font-montserrat text-xs tracking-wider border border-gray-300 px-4 py-2 hover:border-black hover:text-black transition-all">
                        Detail
                    </a>
                </div>
            </div>

            {{-- List produk --}}
            <div class="space-y-3">
                @foreach($order->items as $item)
                <div class="flex gap-4">
                    <div class="w-14 h-14 flex-shrink-0 bg-gray-50 overflow-hidden">
                        <img src="{{ asset('images/' . ($item->product->image ?? '')) }}"
                             alt="{{ $item->product_name }}"
                             class="w-full h-full object-cover"
                             onerror="this.src='https://placehold.co/56x56/f5f5f5/999?text=No'">
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
            <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100">
                <p class="font-montserrat text-xs text-gray-500">
                    {{ $order->items->count() }} produk
                </p>
                <div class="text-right">
                    <p class="font-montserrat text-xs text-gray-400 mb-1">Total Pesanan</p>
                    <p class="font-bebas text-2xl tracking-wider text-black">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </p>
                </div>
            </div>

        </div>
        @endforeach
    </div>

    @else
    <div class="flex flex-col items-center justify-center py-24 text-center">
        <div class="text-8xl font-bebas text-gray-100 tracking-widest mb-4">KOSONG</div>
        <i class="fas fa-box-open text-4xl text-gray-200 mb-4"></i>
        <p class="font-montserrat text-sm text-gray-400 mb-8">Belum ada pesanan.</p>
        <a href="{{ route('products.index') }}"
           class="px-8 py-3 bg-black text-white font-montserrat text-sm font-semibold tracking-wider hover:bg-neutral-800 transition-all">
            Mulai Belanja
        </a>
    </div>
    @endif

</section>
@endsection