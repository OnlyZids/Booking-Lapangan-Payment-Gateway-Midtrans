<x-user-layout>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 md:flex md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Riwayat Booking</h1>
                <p class="mt-2 text-gray-600">Pantau status pembayaran dan jadwal mainmu disini.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <a href="{{ route('home') }}#courts" class="inline-flex items-center px-6 py-3 border border-transparent rounded-full shadow-sm text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition transform hover:-translate-y-1">
                    + Booking Lapangan Baru
                </a>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
            
            @if($bookings->isEmpty())
                <div class="text-center py-20 px-6">
                    <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada bookingan nih</h3>
                    <p class="text-gray-500 mb-6">Yuk mulai main badminton biar sehat!</p>
                    <a href="{{ route('home') }}#courts" class="text-emerald-600 font-bold hover:underline">Cari Lapangan Sekarang &rarr;</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jadwal Main</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Info Lapangan</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Durasi</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total Harga</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-lg overflow-hidden">
                                            @if($booking->court->image)
                                                <img class="h-10 w-10 object-cover" src="{{ asset('storage/' . $booking->court->image) }}">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-xs text-gray-500">No img</div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $booking->court->name }}</div>
                                            <div class="text-xs text-gray-500 capitalize">{{ $booking->court->type }} Court</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($booking->start_time)->diffInHours($booking->end_time) }} Jam
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600">
                                    Rp {{ number_format($booking->total_price) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($booking->status == 'paid')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200">
                                            LUNAS ✅
                                        </span>
                                    @elseif($booking->status == 'pending')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200 animate-pulse">
                                            PENDING ⏳
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200">
                                            BATAL ❌
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    @if($booking->status == 'pending')
                                        <a href="{{ route('booking.payment', $booking->id) }}" class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-xs font-bold shadow transition">
                                            Bayar Sekarang
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</x-user-layout>