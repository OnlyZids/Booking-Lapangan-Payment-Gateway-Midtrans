<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Court;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. DATA KARTU ATAS
        // Total Pendapatan (Hanya yang statusnya 'paid')
        $totalIncome = Booking::where('status', 'paid')->sum('total_price');
        
        // Booking Masuk Hari Ini
        $todayBookings = Booking::whereDate('created_at', Carbon::today())->count();
        
        // Total Lapangan
        $totalCourts = Court::count();

        // 2. DATA UNTUK GRAFIK (CHART)
        // Kita ambil data pendapatan 7 hari terakhir
        $chartData = Booking::where('status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Pisahkan label (tanggal) dan data (nominal) buat Chart.js
        $labels = [];
        $data = [];

        foreach ($chartData as $item) {
            $labels[] = Carbon::parse($item->date)->format('d M'); // Contoh: 10 Dec
            $data[] = $item->total;
        }

        return view('admin.dashboard', compact('totalIncome', 'todayBookings', 'totalCourts', 'labels', 'data'));
    }
}