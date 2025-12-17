<x-admin-layout>
    
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Lapangan (Courts)</h2>
        <a href="{{ route('admin.courts.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded transition flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
            Tambah Lapangan
        </a>
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
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Foto
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Nama Lapangan
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Tipe Lantai
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Harga / Jam
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courts as $court)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                <div class="flex-shrink-0 w-20 h-12 bg-gray-100 rounded overflow-hidden">
                                    @if($court->image)
                                        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $court->image) }}" alt="{{ $court->name }}">
                                    @else
                                        <div class="flex items-center justify-center h-full text-xs text-gray-400 font-bold">No Img</div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm font-bold text-gray-900">
                                {{ $court->name }}
                            </td>
                            <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $court->type == 'karpet' ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ ucfirst($court->type) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm font-bold text-emerald-600">
                                Rp {{ number_format($court->price) }}
                            </td>
                            <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm text-center">
                                @if($court->is_active)
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                        Aktif ✅
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">
                                        Non-Aktif ❌
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('admin.courts.edit', $court->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-100 p-2 rounded hover:bg-blue-200 transition" title="Edit">
                                        ✏️
                                    </a>
                                    <form action="{{ route('admin.courts.destroy', $court->id) }}" method="POST" onsubmit="return confirm('Yakin hapus lapangan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 bg-red-100 p-2 rounded hover:bg-red-200 transition" title="Hapus">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-admin-layout>