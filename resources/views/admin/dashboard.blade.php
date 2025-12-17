<x-admin-layout>
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>
        <p class="text-gray-600">Selamat datang kembali, {{ Auth::user()->name }}!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-emerald-500">
            <div class="text-gray-500 text-sm">Total Pendapatan (Paid)</div>
            <div class="text-2xl font-bold text-gray-800">
                Rp {{ number_format($totalIncome) }}
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
            <div class="text-gray-500 text-sm">Booking Baru Hari Ini</div>
            <div class="text-2xl font-bold text-gray-800">{{ $todayBookings }}</div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-500">
            <div class="text-gray-500 text-sm">Total Lapangan</div>
            <div class="text-2xl font-bold text-gray-800">{{ $totalCourts }} Unit</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm">
        <h3 class="text-lg font-semibold mb-4">Grafik Pendapatan (7 Hari Terakhir)</h3>
        <div class="relative h-64 w-full">
            <canvas id="incomeChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('incomeChart');

        new Chart(ctx, {
            type: 'line', // Jenis grafik: Garis
            data: {
                // Ambil data dari Controller (Blade to JS)
                labels: @json($labels), 
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($data),
                    borderWidth: 2,
                    borderColor: '#10b981', // Warna Emerald
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.3, // Garis agak melengkung biar smooth
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // Format angka rupiah di sumbu Y
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda biar bersih
                    }
                }
            }
        });
    </script>

</x-admin-layout>