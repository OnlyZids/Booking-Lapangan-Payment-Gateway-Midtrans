<x-user-layout>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pembayaran</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                
                <div class="mb-6">
                    <svg class="w-16 h-16 text-emerald-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="text-2xl font-bold text-gray-900 mt-4">Booking Terkonfirmasi!</h3>
                    <p class="text-gray-500">Lakukan pembayaran sebelum kode expired.</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg text-left mb-6 max-w-md mx-auto border border-gray-200">
                    <p class="flex justify-between"><span>Lapangan:</span> <strong>{{ $booking->court->name }}</strong></p>
                    <p class="flex justify-between"><span>Jadwal:</span> <strong>{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i') }}</strong></p>
                    <div class="border-t my-2"></div>
                    <p class="flex justify-between text-lg text-emerald-600 font-bold"><span>Total:</span> <span>Rp {{ number_format($booking->total_price) }}</span></p>
                </div>

                <button id="pay-button" class="bg-blue-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-blue-700 transition transform hover:-translate-y-1">
                    Bayar Sekarang
                </button>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{ $booking->snap_token }}', {
                onSuccess: function(result){
                    // Nanti kita arahkan ke dashboard dengan pesan sukses
                    alert("Pembayaran Berhasil!");
                    window.location.href = "{{ route('dashboard') }}";
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda!");
                    window.location.href = "{{ route('dashboard') }}";
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                    window.location.href = "{{ route('dashboard') }}";
                },
                onClose: function(){
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        });
    </script>
</x-user-layout>