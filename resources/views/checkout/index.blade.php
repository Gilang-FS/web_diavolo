@extends('layouts.app')

@section('content')
<div class="pt-[88px]"></div>

{{-- HEADER --}}
<section class="bg-black text-white px-20 py-8">
    <h1 class="font-bebas text-4xl tracking-[4px]">Checkout</h1>
</section>

<section class="px-20 py-8 bg-gray-50 min-h-screen relative">
    <form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
        @csrf
        <div class="flex gap-6">

            {{-- KOLOM KIRI --}}
            <div class="flex-1 space-y-4">

                {{-- ALAMAT PENGIRIMAN --}}
                <div class="bg-white border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-bebas text-xl tracking-wider">Alamat Pengiriman</h2>
                        <button type="button" onclick="openAddModal()"
                            class="font-montserrat text-xs font-semibold tracking-wider text-white bg-black px-4 py-2 hover:bg-neutral-800 transition-all">
                            + Tambah Alamat
                        </button>
                    </div>

                    @if($addresses->count() > 0)
                    <div class="space-y-3" id="address-list">
                        @foreach($addresses as $addr)
                        <label class="flex items-start gap-3 p-4 border cursor-pointer transition-all
                            {{ $addr->is_default ? 'border-black bg-gray-50' : 'border-gray-200 hover:border-gray-400' }}"
                            id="addr-label-{{ $addr->id }}">
                            <input type="radio" name="address_id" value="{{ $addr->id }}"
                                {{ $addr->is_default ? 'checked' : '' }}
                                onchange="selectAddress({{ $addr->id }})"
                                class="mt-1 accent-black">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-montserrat text-xs font-bold text-black uppercase tracking-wider">
                                        {{ $addr->label }}
                                    </span>
                                    @if($addr->is_default)
                                    <span class="font-montserrat text-[10px] bg-black text-white px-2 py-0.5 tracking-wider">
                                        DEFAULT
                                    </span>
                                    @endif
                                </div>
                                <p class="font-montserrat text-sm font-semibold text-black">{{ $addr->recipient_name }} | {{ $addr->phone }}</p>
                                <p class="font-montserrat text-xs text-gray-500 mt-1">
                                    {{ $addr->address }}, {{ $addr->city }}, {{ $addr->province }} {{ $addr->postal_code }}
                                </p>
                            </div>
                            <div class="flex gap-2 flex-shrink-0">
                                <button type="button" onclick="openEditModal({{ $addr->id }}, '{{ $addr->label }}', '{{ $addr->recipient_name }}', '{{ $addr->phone }}', '{{ addslashes($addr->address) }}', '{{ $addr->city }}', '{{ $addr->province }}', '{{ $addr->postal_code }}', {{ $addr->is_default ? 'true' : 'false' }})"
                                    class="font-montserrat text-[10px] tracking-wider text-gray-500 border border-gray-300 px-3 py-1 hover:border-black hover:text-black transition-all">
                                    Edit
                                </button>
                                @if(!$addr->is_default)
                                <form method="POST" action="{{ route('addresses.destroy', $addr->id) }}" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus alamat ini?')"
                                        class="font-montserrat text-[10px] tracking-wider text-red-400 border border-red-200 px-3 py-1 hover:border-red-500 hover:text-red-600 transition-all">
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-8 border border-dashed border-gray-300">
                        <i class="fas fa-map-marker-alt text-3xl text-gray-300 mb-3"></i>
                        <p class="font-montserrat text-sm text-gray-400 mb-4">Belum ada alamat tersimpan</p>
                        <button type="button" onclick="openAddModal()"
                            class="font-montserrat text-xs font-semibold tracking-wider border border-black text-black px-6 py-2 hover:bg-black hover:text-white transition-all">
                            + Tambah Alamat Pertama
                        </button>
                    </div>
                    @endif
                </div>

                {{-- PRODUK DIPESAN --}}
                <div class="bg-white border border-gray-200 p-6">
                    <h2 class="font-bebas text-xl tracking-wider mb-4">Produk Dipesan</h2>
                    <div class="space-y-4">
                        @foreach($cart->items as $item)
                        <div class="flex gap-4 py-3 border-b border-gray-50 last:border-0">
                            <div class="w-16 h-16 flex-shrink-0 bg-gray-50 overflow-hidden">
                                <img src="{{ asset('images/' . $item->product->image) }}"
                                     alt="{{ $item->product->name }}"
                                     class="w-full h-full object-cover"
                                     onerror="this.src='https://placehold.co/64x64/f5f5f5/999?text=No'">
                            </div>
                            <div class="flex-1">
                                <p class="font-montserrat text-sm font-semibold text-black leading-snug">{{ $item->product->name }}</p>
                                @if($item->size)
                                <p class="font-montserrat text-xs text-gray-400 mt-1">Ukuran: {{ $item->size }}</p>
                                @endif
                                <p class="font-montserrat text-xs text-gray-500 mt-1">x{{ $item->quantity }}</p>
                            </div>
                            <p class="font-montserrat text-sm font-bold text-black flex-shrink-0">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                        @endforeach
                    </div>

                    {{-- Catatan --}}
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <label class="block font-montserrat text-[10px] tracking-[3px] uppercase text-gray-400 mb-2">Catatan (opsional)</label>
                        <input type="text" name="notes" placeholder="Pesan untuk penjual..."
                            class="w-full border-b border-gray-200 py-2 font-montserrat text-sm outline-none focus:border-black transition-colors bg-transparent">
                    </div>
                </div>

                {{-- METODE PEMBAYARAN --}}
                <div class="bg-white border border-gray-200 p-6">
                    <h2 class="font-bebas text-xl tracking-wider mb-4">Metode Pembayaran</h2>
                    <div class="space-y-2">

                        <label class="flex items-center gap-3 p-4 border border-gray-200 cursor-pointer hover:border-black transition-all payment-option">
                            <input type="radio" name="payment_method" value="gopay" class="accent-black">
                            <i class="fas fa-wallet text-green-500"></i>
                            <span class="font-montserrat text-sm font-semibold">GoPay / QRIS</span>
                        </label>

                        <label class="flex items-center gap-3 p-4 border border-gray-200 cursor-pointer hover:border-black transition-all payment-option">
                            <input type="radio" name="payment_method" value="bank_transfer" class="accent-black">
                            <i class="fas fa-university text-blue-500"></i>
                            <span class="font-montserrat text-sm font-semibold">Transfer Bank</span>
                            <span class="font-montserrat text-xs text-gray-400">(BCA, BNI, BRI, Mandiri)</span>
                        </label>

                        <label class="flex items-center gap-3 p-4 border border-gray-200 cursor-pointer hover:border-black transition-all payment-option">
                            <input type="radio" name="payment_method" value="echannel" class="accent-black">
                            <i class="fas fa-mobile-alt text-orange-500"></i>
                            <span class="font-montserrat text-sm font-semibold">E-Money</span>
                            <span class="font-montserrat text-xs text-gray-400">(OVO, Dana, ShopeePay)</span>
                        </label>

                        <label class="flex items-center gap-3 p-4 border border-gray-200 cursor-pointer hover:border-black transition-all payment-option">
                            <input type="radio" name="payment_method" value="cod" class="accent-black">
                            <i class="fas fa-truck text-gray-600"></i>
                            <span class="font-montserrat text-sm font-semibold">COD</span>
                            <span class="font-montserrat text-xs text-gray-400">(Bayar di tempat)</span>
                        </label>

                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: Ringkasan --}}
            <div class="w-80 flex-shrink-0">
                <div class="bg-white border border-gray-200 p-6 sticky">
                    <h2 class="font-bebas text-xl tracking-wider mb-4 pb-3 border-b border-gray-100">Ringkasan Belanja</h2>

                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between">
                            <span class="font-montserrat text-xs text-gray-500">Total Harga ({{ $cart->items->sum('quantity') }} barang)</span>
                            <span class="font-montserrat text-xs font-semibold">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-montserrat text-xs text-gray-500">Ongkos Kirim</span>
                            <span class="font-montserrat text-xs font-semibold text-green-600">Gratis</span>
                        </div>
                    </div>

                    <div class="flex justify-between py-4 border-t border-gray-200 mb-6">
                        <span class="font-montserrat text-sm font-bold">TOTAL BAYAR</span>
                        <span class="font-bebas text-2xl tracking-wider">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                    </div>

                    <button type="button" onclick="submitCheckout()"
                        class="w-full py-3 bg-black text-white font-montserrat text-sm font-semibold tracking-wider hover:bg-neutral-800 transition-all duration-200">
                        Buat Pesanan
                    </button>

                    <p class="font-montserrat text-[10px] text-gray-400 text-center mt-3">
                        <i class="fas fa-shield-alt mr-1"></i> Aman dengan Midtrans
                    </p>
                </div>
            </div>

        </div>
    </form>
</section>

{{-- MODAL TAMBAH ALAMAT --}}
<div id="modal-add" class="hidden fixed inset-0 z-[9999] flex items-center justify-center">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeAddModal()"></div>
    <div class="relative bg-white w-full max-w-lg mx-4 p-8 z-10 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-bebas text-2xl tracking-wider">Tambah Alamat</h3>
            <button onclick="closeAddModal()" class="text-gray-400 hover:text-black transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('addresses.store') }}">
            @csrf
            @include('checkout.partials.address-form')
            <button type="submit"
                class="w-full py-3 bg-black text-white font-montserrat text-sm font-semibold tracking-wider hover:bg-neutral-800 transition-all mt-6">
                Simpan Alamat
            </button>
        </form>
    </div>
</div>

{{-- MODAL EDIT ALAMAT --}}
<div id="modal-edit" class="hidden fixed inset-0 z-[9999] flex items-center justify-center">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeEditModal()"></div>
    <div class="relative bg-white w-full max-w-lg mx-4 p-8 z-10 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h3 class="font-bebas text-2xl tracking-wider">Edit Alamat</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-black transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <form method="POST" id="edit-form" action="">
            @csrf @method('PATCH')
            @include('checkout.partials.address-form', ['edit' => true])
            <button type="submit"
                class="w-full py-3 bg-black text-white font-montserrat text-sm font-semibold tracking-wider hover:bg-neutral-800 transition-all mt-6">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Modal Tambah
    function openAddModal() {
        document.getElementById('modal-add').classList.remove('hidden');
    }
    function closeAddModal() {
        document.getElementById('modal-add').classList.add('hidden');
    }

    // Modal Edit
    function openEditModal(id, label, name, phone, address, city, province, postal, isDefault) {
        const form = document.getElementById('edit-form');
        form.action = `/addresses/${id}`;
        form.querySelector('[name="label"]').value = label;
        form.querySelector('[name="recipient_name"]').value = name;
        form.querySelector('[name="phone"]').value = phone;
        form.querySelector('[name="address"]').value = address;
        form.querySelector('[name="city"]').value = city;
        form.querySelector('[name="province"]').value = province;
        form.querySelector('[name="postal_code"]').value = postal;
        form.querySelector('[name="is_default"]').checked = isDefault;
        document.getElementById('modal-edit').classList.remove('hidden');
    }
    function closeEditModal() {
        document.getElementById('modal-edit').classList.add('hidden');
    }

    // Highlight alamat yang dipilih
    function selectAddress(id) {
        document.querySelectorAll('[id^="addr-label-"]').forEach(el => {
            el.classList.remove('border-black', 'bg-gray-50');
            el.classList.add('border-gray-200');
        });
        const selected = document.getElementById('addr-label-' + id);
        if (selected) {
            selected.classList.add('border-black', 'bg-gray-50');
            selected.classList.remove('border-gray-200');
        }
    }

    // Validasi sebelum submit
    function submitCheckout() {
        const address = document.querySelector('input[name="address_id"]:checked');
        const payment = document.querySelector('input[name="payment_method"]:checked');

        if (!address) {
            alert('Pilih alamat pengiriman terlebih dahulu!');
            return;
        }
        if (!payment) {
            alert('Pilih metode pembayaran terlebih dahulu!');
            return;
        }

        document.getElementById('checkout-form').submit();
    }
</script>
@endpush