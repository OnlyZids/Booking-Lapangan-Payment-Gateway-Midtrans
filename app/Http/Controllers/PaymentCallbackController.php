<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Services\Midtrans\CallbackService; // Kita pake library bawaan aja
use Midtrans\Config;
use Midtrans\Notification;

class PaymentCallbackController extends Controller
{
    public function handle()
    {
        // 1. Setup Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // 2. Baca Notifikasi dari Midtrans
        try {
            $notification = new Notification();
        } catch (\Exception $e) {
            return response(['message' => 'Notification invalid'], 400);
        }

        // 3. Ambil data penting
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $orderId = $notification->order_id;

        // KITA PERLU HATI-HATI DISINI!
        // Tadi kita kirim order_id formatnya: "ID_BOOKING-RANDOM" (Contoh: 5-827361)
        // Jadi kita harus pecah string-nya buat dapet ID asli booking-nya.
        $bookingId = explode('-', $orderId)[0]; 

        // Cari data booking di database
        $booking = Booking::find($bookingId);

        if (!$booking) {
            return response(['message' => 'Booking not found'], 404);
        }

        // 4. Logika Update Status Berdasarkan Laporan Midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $booking->update(['status' => 'pending']);
                } else {
                    $booking->update(['status' => 'paid']);
                }
            }
        } elseif ($status == 'settlement') {
            // Ini status paling umum kalau transfer bank sukses
            $booking->update(['status' => 'paid']);
        } elseif ($status == 'pending') {
            $booking->update(['status' => 'pending']);
        } elseif ($status == 'deny' || $status == 'expire' || $status == 'cancel') {
            $booking->update(['status' => 'cancelled']);
        }

        return response(['message' => 'Callback received successfully']);
    }
}