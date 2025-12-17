<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Court;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
  
    // 1. Menampilkan form booking
    public function show(Court $court)
    {
        return view('user.bookings.create', compact('court'));
    }

    // 2. Proses Simpan Booking
    public function store(Request $request, Court $court)
{
    // Validasi Input
    $request->validate([
        'date' => 'required|date|after_or_equal:today',
        'start_hour' => 'required|integer|min:8|max:22', 
        'duration' => 'required|integer|min:1|max:3',
    ]);

    // Format Waktu
    $startTime = Carbon::parse($request->date . ' ' . $request->start_hour . ':00:00');
    
    // --- PERBAIKAN DISINI ---
    // Kita tambahkan (int) untuk memaksa string jadi integer
    $endTime = $startTime->copy()->addHours((int) $request->duration); 

    // Cek Bentrok Jadwal
    $exists = Booking::where('court_id', $court->id)
        ->where('status', '!=', 'cancelled')
        ->where(function ($query) use ($startTime, $endTime) {
            $query->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime])
                  ->orWhere(function ($q) use ($startTime, $endTime) {
                      $q->where('start_time', '<', $startTime)
                        ->where('end_time', '>', $endTime);
                  });
        })
        ->exists();

    if ($exists) {
        return back()->withErrors(['msg' => 'Yah, jam segitu lapangan sudah dibooking orang lain! Coba jam lain bro.']);
    }

    // Hitung Harga
    $totalPrice = $court->price * (int) $request->duration; // Tambah (int) disini juga biar aman

    // Simpan Data
    $booking = Booking::create([
        'user_id' => Auth::id(),
        'court_id' => $court->id,
        'start_time' => $startTime,
        'end_time' => $endTime,
        'total_price' => $totalPrice,
        'status' => 'pending',
    ]);

    return redirect()->route('booking.payment', $booking->id);
}

    public function selectCourt()
    {
        // Ambil semua lapangan aktif
        $courts = \App\Models\Court::where('is_active', true)->get();
        
        // Tampilkan ke view khusus member
        return view('user.bookings.select', compact('courts'));
    }

    public function payment(Booking $booking)
    {
        // Security: Pastikan yg buka cuma pemilik booking
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Kalau status sudah lunas, lempar balik ke dashboard
        if ($booking->status === 'paid') {
            return redirect()->route('dashboard')->with('success', 'Booking sudah lunas!');
        }

        // --- LOGIC MIDTRANS MULAI DISINI ---
        
        // 1. Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // 2. Cek apakah booking ini sudah punya snap_token?
        // Kalau belum, kita minta baru ke Midtrans
        if (empty($booking->snap_token)) {
            
            $params = [
                'transaction_details' => [
                    'order_id' => $booking->id . '-' . rand(), // Order ID unik (tambah rand biar gak error kalau coba bayar ulang)
                    'gross_amount' => $booking->total_price,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone ?? '08123456789', // Default kalau kosong
                ],
            ];

            // Minta Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);

            // Simpan token ke database biar gak request mulu
            $booking->snap_token = $snapToken;
            $booking->save();
        }

        return view('user.bookings.payment', compact('booking'));
    }
}
