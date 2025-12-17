<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // 1. Tampilkan Daftar Semua Booking
    public function index()
    {
        // Ambil data booking, urutkan dari yang terbaru, dan load data relasinya (user & court)
        $bookings = Booking::with(['user', 'court'])->latest()->paginate(10);
        
        return view('admin.bookings.index', compact('bookings'));
    }

    // 2. Fungsi Ubah Status (Pending -> Paid / Cancelled)
    public function updateStatus(Request $request, Booking $booking)
    {
        // Validasi input status
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled'
        ]);

        // Update database
        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Status booking berhasil diperbarui!');
    }
}