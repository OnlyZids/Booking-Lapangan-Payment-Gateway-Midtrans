<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <--- PENTING: Tambahkan ini buat hapus file gambar

class CourtController extends Controller
{
    public function index()
    {
        $courts = Court::latest()->get();
        return view('admin.courts.index', compact('courts'));
    }

    public function create()
    {
        return view('admin.courts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:lantai,karpet',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'required|boolean',
        ]);

        // Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courts', 'public');
        }

        Court::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'image' => $imagePath,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.courts.index')->with('success', 'Lapangan berhasil ditambahkan!');
    }

    // --- FUNGSI BARU: EDIT (Menampilkan Form) ---
    public function edit(Court $court)
    {
        // Kita kirim data lapangan yang mau diedit ke view
        return view('admin.courts.edit', compact('court'));
    }

    // --- FUNGSI BARU: UPDATE (Menyimpan Perubahan) ---
    public function update(Request $request, Court $court)
    {
        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:lantai,karpet',
            'price' => 'required|numeric|min:0',
            // Gambar jadi 'nullable' (boleh kosong) saat update, kalau user gak mau ganti gambar
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'required|boolean',
        ]);

        // Ambil data inputan selain gambar
        $data = $request->only(['name', 'type', 'price', 'is_active']);

        // Cek apakah ada upload gambar baru?
        if ($request->hasFile('image')) {
            // 1. Hapus gambar lama kalau ada
            if ($court->image) {
                Storage::disk('public')->delete($court->image);
            }
            // 2. Upload gambar baru dan masukkan path-nya ke data yang mau diupdate
            $data['image'] = $request->file('image')->store('courts', 'public');
        }

        // Update database
        $court->update($data);

        return redirect()->route('admin.courts.index')->with('success', 'Data lapangan berhasil diperbarui!');
    }

    public function destroy(Court $court)
    {
        // Hapus filenya dulu dari storage kalau ada
        if ($court->image) {
            Storage::disk('public')->delete($court->image);
        }
        
        $court->delete();
        return back()->with('success', 'Lapangan berhasil dihapus!');
    }
}