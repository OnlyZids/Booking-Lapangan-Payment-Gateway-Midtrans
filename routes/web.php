<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CourtController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\HomeController;
use App\Models\Booking;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');

// --- GROUP ROUTE UNTUK USER BIASA ---
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard User (Tempat booking nanti)
    Route::get('/dashboard', function () {
        // Ambil booking milik user yang sedang login, urutkan dari yang terbaru
        $bookings = Booking::where('user_id', Auth::id())
                    ->with('court') // Load data lapangan juga
                    ->latest()
                    ->get();
                    
        return view('dashboard', compact('bookings'));
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    // Profile User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Route buat milih lapangan (Khusus Member)
    Route::get('/booking/new', [\App\Http\Controllers\User\BookingController::class, 'selectCourt'])->name('booking.select');


    Route::get('/booking/{court}', [\App\Http\Controllers\User\BookingController::class, 'show'])->name('booking.show');
    Route::post('/booking/{court}', [\App\Http\Controllers\User\BookingController::class, 'store'])->name('booking.store');

    // Route Halaman Bayar (Step 5)
    Route::get('/booking/{booking}/payment', [\App\Http\Controllers\User\BookingController::class, 'payment'])->name('booking.payment');
});

// --- GROUP ROUTE KHUSUS ADMIN ---
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Nanti tambah route manage lapangan & booking disini
    Route::get('/courts', [\App\Http\Controllers\Admin\CourtController::class, 'index'])->name('courts.index');
    Route::get('/courts/create', [\App\Http\Controllers\Admin\CourtController::class, 'create'])->name('courts.create');
    Route::post('/courts', [\App\Http\Controllers\Admin\CourtController::class, 'store'])->name('courts.store');
    Route::get('/courts/{court}/edit', [\App\Http\Controllers\Admin\CourtController::class, 'edit'])->name('courts.edit');
    Route::put('/courts/{court}', [\App\Http\Controllers\Admin\CourtController::class, 'update'])->name('courts.update');
    Route::delete('/courts/{court}', [\App\Http\Controllers\Admin\CourtController::class, 'destroy'])->name('courts.destroy');

    Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/update-status', [\App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.update-status');
});
// Midtrans Callback Handler
Route::post('midtrans-callback', [App\Http\Controllers\PaymentCallbackController::class, 'handle']);



require __DIR__.'/auth.php';
