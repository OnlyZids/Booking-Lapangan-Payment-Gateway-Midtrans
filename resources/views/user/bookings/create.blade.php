<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Booking {{ $court->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="h-48 bg-gray-200">
                             @if($court->image)
                                <img src="{{ asset('storage/' . $court->image) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold">{{ $court->name }}</h3>
                            <p class="text-sm text-gray-500 mb-4">{{ ucfirst($court->type) }} Court</p>
                            
                            <div class="border-t pt-4">
                                <p class="text-gray-600">Harga Sewa:</p>
                                <p class="text-2xl font-bold text-emerald-600">Rp {{ number_format($court->price) }}</p>
                                <p class="text-xs text-gray-500">per jam</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4">Pilih Jadwal Main</h3>

                        @if ($errors->any())
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                                <strong class="font-bold">Oops!</strong>
                                <span class="block sm:inline">{{ $errors->first() }}</span>
                            </div>
                        @endif

                        <form action="{{ route('booking.store', $court->id) }}" method="POST">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Main</label>
                                    <input type="date" name="date" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500" required min="{{ date('Y-m-d') }}">
                                </div>

                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Durasi (Jam)</label>
                                    <select name="duration" class="w-full border-gray-300 rounded-md shadow-sm">
                                        <option value="1">1 Jam</option>
                                        <option value="2">2 Jam</option>
                                        <option value="3">3 Jam</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Jam Mulai</label>
                                <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                                    @for ($i = 8; $i <= 22; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="start_hour" value="{{ $i }}" class="peer sr-only" required>
                                            <div class="peer-checked:bg-emerald-600 peer-checked:text-white bg-gray-100 text-gray-700 py-2 rounded text-center text-sm font-medium hover:bg-gray-200 transition">
                                                {{ sprintf('%02d', $i) }}:00
                                            </div>
                                        </label>
                                    @endfor
                                </div>
                                <p class="text-xs text-gray-500 mt-2">*Pilih waktu mulai main.</p>
                            </div>

                            <button type="submit" class="w-full bg-gray-900 text-white font-bold py-3 px-4 rounded hover:bg-gray-800 transition">
                                Lanjut Pembayaran ->
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-user-layout>