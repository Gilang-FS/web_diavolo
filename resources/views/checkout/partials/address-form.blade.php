<div class="space-y-4">
    <div>
        <label class="block font-montserrat text-[10px] tracking-[3px] uppercase text-gray-400 mb-2">Label Alamat *</label>
        <input type="text" name="label" placeholder="contoh: Rumah, Kantor"
            class="w-full border-b border-gray-200 py-2 font-montserrat text-sm outline-none focus:border-black transition-colors bg-transparent">
    </div>
    <div>
        <label class="block font-montserrat text-[10px] tracking-[3px] uppercase text-gray-400 mb-2">Nama Penerima *</label>
        <input type="text" name="recipient_name"
            class="w-full border-b border-gray-200 py-2 font-montserrat text-sm outline-none focus:border-black transition-colors bg-transparent">
    </div>
    <div>
        <label class="block font-montserrat text-[10px] tracking-[3px] uppercase text-gray-400 mb-2">Nomor HP *</label>
        <input type="text" name="phone" placeholder="08xxxxxxxxxx"
            class="w-full border-b border-gray-200 py-2 font-montserrat text-sm outline-none focus:border-black transition-colors bg-transparent">
    </div>
    <div>
        <label class="block font-montserrat text-[10px] tracking-[3px] uppercase text-gray-400 mb-2">Alamat Lengkap *</label>
        <textarea name="address" rows="2"
            class="w-full border-b border-gray-200 py-2 font-montserrat text-sm outline-none focus:border-black transition-colors bg-transparent resize-none"></textarea>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block font-montserrat text-[10px] tracking-[3px] uppercase text-gray-400 mb-2">Kota *</label>
            <input type="text" name="city"
                class="w-full border-b border-gray-200 py-2 font-montserrat text-sm outline-none focus:border-black transition-colors bg-transparent">
        </div>
        <div>
            <label class="block font-montserrat text-[10px] tracking-[3px] uppercase text-gray-400 mb-2">Provinsi *</label>
            <input type="text" name="province"
                class="w-full border-b border-gray-200 py-2 font-montserrat text-sm outline-none focus:border-black transition-colors bg-transparent">
        </div>
    </div>
    <div>
        <label class="block font-montserrat text-[10px] tracking-[3px] uppercase text-gray-400 mb-2">Kode Pos *</label>
        <input type="text" name="postal_code"
            class="w-full border-b border-gray-200 py-2 font-montserrat text-sm outline-none focus:border-black transition-colors bg-transparent">
    </div>
    <label class="flex items-center gap-2 cursor-pointer mt-2">
        <input type="checkbox" name="is_default" class="accent-black">
        <span class="font-montserrat text-xs text-gray-600 tracking-wider">Jadikan alamat default</span>
    </label>
</div>