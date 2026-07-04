<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OutfitController extends Controller
{
    public function create()
    {
        return view('outfits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|string',
            'image'    => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $imagePath = $request->file('image')->store('outfits', 'public');

        if (!$imagePath) {
            return back()->with('error', 'Gagal mengunggah gambar.')->withInput();
        }

        Outfit::create([
            'user_id'  => Auth::id(),
            'name'     => $request->name,
            'category' => $request->category,
            'image'    => $imagePath,
        ]);

        return redirect()->route('wardrobe')->with('success', 'Baju berhasil ditambahkan!');
    }

    // ====== TAMBAHKAN METHOD DI BAWAH INI ======

    // Tampilkan form edit
    public function edit(Outfit $outfit)
    {
        // Pastikan hanya pemilik yang bisa edit
        if ($outfit->user_id !== Auth::id()) {
            abort(403);
        }
        return view('outfits.edit', compact('outfit'));
    }

    // Proses update
    public function update(Request $request, Outfit $outfit)
    {
        if ($outfit->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|string',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'name'     => $request->name,
            'category' => $request->category,
        ];

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($outfit->image) {
                Storage::disk('public')->delete($outfit->image);
            }
            $data['image'] = $request->file('image')->store('outfits', 'public');
        }

        $outfit->update($data);

        return redirect()->route('wardrobe')->with('success', 'Baju berhasil diperbarui!');
    }

    // Hapus outfit
    public function destroy(Outfit $outfit)
    {
        if ($outfit->user_id !== Auth::id()) {
            abort(403);
        }

        // Hapus file gambar dari storage
        if ($outfit->image) {
            Storage::disk('public')->delete($outfit->image);
        }

        $outfit->delete();

        return response()->json(['message' => 'Baju berhasil dihapus']);
    }
}