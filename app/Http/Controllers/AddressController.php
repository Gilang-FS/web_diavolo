<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    // Simpan alamat baru
    public function store(Request $request)
    {
        $request->validate([
            'label'          => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string',
            'city'           => 'required|string|max:100',
            'province'       => 'required|string|max:100',
            'postal_code'    => 'required|string|max:10',
        ]);

        // Kalau ini alamat pertama, otomatis jadi default
        $isDefault = auth()->user()->addresses()->count() === 0;

        // Kalau user centang "jadikan default"
        if ($request->is_default) {
            auth()->user()->addresses()->update(['is_default' => false]);
            $isDefault = true;
        }

        Address::create([
            'user_id'        => auth()->id(),
            'label'          => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'city'           => $request->city,
            'province'       => $request->province,
            'postal_code'    => $request->postal_code,
            'is_default'     => $isDefault,
        ]);

        return back()->with('success', 'Alamat berhasil ditambahkan!');
    }

    // Update alamat
    public function update(Request $request, Address $address)
    {
        // Pastikan alamat milik user yang login
        if ($address->user_id !== auth()->id()) abort(403);

        $request->validate([
            'label'          => 'required|string|max:50',
            'recipient_name' => 'required|string|max:255',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string',
            'city'           => 'required|string|max:100',
            'province'       => 'required|string|max:100',
            'postal_code'    => 'required|string|max:10',
        ]);

        if ($request->is_default) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        $address->update([
            'label'          => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'city'           => $request->city,
            'province'       => $request->province,
            'postal_code'    => $request->postal_code,
            'is_default'     => $request->is_default ?? $address->is_default,
        ]);

        return back()->with('success', 'Alamat berhasil diperbarui!');
    }

    // Hapus alamat
    public function destroy(Address $address)
    {
        if ($address->user_id !== auth()->id()) abort(403);
        $address->delete();
        return back()->with('success', 'Alamat berhasil dihapus!');
    }

    // Set sebagai default
    public function setDefault(Address $address)
    {
        if ($address->user_id !== auth()->id()) abort(403);
        auth()->user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);
        return back()->with('success', 'Alamat default berhasil diubah!');
    }
}