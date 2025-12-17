<x-admin-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Tambah Lapangan Baru</h2>
        <p class="text-gray-600">Masukkan detail lapangan badminton baru.</p>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-2xl">
        <div class="p-6 bg-white border-b border-gray-200">
            
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Oops! Ada kesalahan:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.courts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lapangan</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: Lapangan A" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tipe Lantai</label>
                        <select name="type" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="lantai">Lantai Kayu/Semen</option>
                            <option value="karpet">Karpet Vinyl</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Harga per Jam (Rp)</label>
                        <input type="number" name="price" value="{{ old('price') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="20000" required min="0">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Status Lapangan</label>
                    <select name="is_active" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="1" selected>Aktif (Bisa Dibooking)</option>
                        <option value="0">Non-Aktif (Maintenance)</option>
                    </select>
                </div>

                <div class="mb-6 border-t pt-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Foto Lapangan</label>
                    <input type="file" name="image" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-emerald-50 file:text-emerald-700
                        hover:file:bg-emerald-100 transition
                    " required>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('admin.courts.index') }}" class="text-gray-500 hover:text-gray-700 font-bold">Batal</a>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition">
                        Simpan Lapangan
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-admin-layout>