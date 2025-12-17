<x-admin-layout>
    
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Booking Masuk</h2>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Lapangan & Waktu
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Total Bayar
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Aksi Manual
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center">
                                    <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap font-bold">
                                            {{ $booking->user->name }}
                                        </p>
                                        <p class="text-gray-500 whitespace-no-wrap text-xs">
                                            {{ $booking->user->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap font-bold">{{ $booking->court->name }}</p>
                                <p class="text-gray-600 whitespace-no-wrap text-xs">
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y') }}
                                </p>
                                <p class="text-gray-600 whitespace-no-wrap text-xs">
                                    {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                </p>
                            </td>

                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-bold text-emerald-600">
                                Rp {{ number_format($booking->total_price) }}
                            </td>

                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                @if($booking->status == 'paid')
                                    <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Lunas</span>
                                    </span>
                                @elseif($booking->status == 'pending')
                                    <span class="relative inline-block px-3 py-1 font-semibold text-yellow-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-yellow-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Pending</span>
                                    </span>
                                @else
                                    <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                        <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                        <span class="relative">Batal</span>
                                    </span>
                                @endif
                            </td>

                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                @if($booking->status == 'pending')
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="bg-green-500 text-white p-2 rounded hover:bg-green-600" title="Set Lunas" onclick="return confirm('Yakin ubah status jadi LUNAS?')">
                                                ✅
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.bookings.update-status', $booking->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="bg-red-500 text-white p-2 rounded hover:bg-red-600" title="Batalkan Booking" onclick="return confirm('Yakin batalkan booking ini?')">
                                                ❌
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>

</x-admin-layout>