<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pilih Lapangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Mau Main di Mana Hari Ini? 🏸</h3>
                <p class="text-gray-500">Pilih lapangan favoritmu dan atur jadwalnya.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($courts as $court)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100 group">
                    <div class="h-48 bg-gray-200 w-full relative overflow-hidden">
                        @if($court->image)
                            <img src="{{ asset('storage/' . $court->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
                        @endif
                        
                        <span class="absolute top-4 right-4 bg-white/90 backdrop-blur text-gray-800 text-xs font-bold px-2 py-1 rounded shadow">
                            {{ ucfirst($court->type) }}
                        </span>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-end mb-4">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900">{{ $court->name }}</h4>
                                <p class="text-sm text-gray-500">Indoor Arena</p>
                            </div>
                            <div class="text-right">
                                <span class="block text-emerald-600 font-bold text-lg">Rp {{ number_format($court->price/1000, 0) }}k</span>
                                <span class="text-xs text-gray-400">/jam</span>
                            </div>
                        </div>

                        <a href="{{ route('booking.show', $court->id) }}" class="block w-full text-center bg-gray-900 text-white font-bold py-3 rounded-lg hover:bg-emerald-600 transition group-hover:shadow-md">
                            Pilih Jadwal ->
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>