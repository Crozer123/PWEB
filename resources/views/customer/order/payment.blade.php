@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Penyelesaian Pembayaran</h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Kolom Kiri: Ringkasan Pesanan -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Ringkasan Sewa</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">ID Sewa</span>
                                <span class="font-medium text-gray-900">#RNT-{{ $rental->id }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Tanggal Sewa</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($rental->rental_date)->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Tanggal Kembali</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($rental->return_date)->format('d M Y') }}</span>
                            </div>
                            
                            <hr class="border-dashed border-gray-200">
                            
                            <!-- List Item Singkat -->
                            <div class="space-y-2">
                                <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Item</p>
                                @foreach($rental->details as $detail)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 truncate w-32">{{ $detail->item->name }}</span>
                                    <span class="text-gray-900">x{{ $detail->quantity }}</span>
                                </div>
                                @endforeach
                            </div>

                            <hr class="border-gray-200">

                            <div class="flex justify-between items-center">
                                <span class="text-base font-bold text-gray-800">Total Tagihan</span>
                                <span class="text-xl font-bold text-green-600">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Pilihan Metode Pembayaran -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-6">Pilih Metode Pembayaran</h3>

                        <!-- Form untuk menangani pilihan -->
                        <form id="payment-form" action="{{ route('customer.payment.cod', $rental->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="space-y-4">
                                <!-- Opsi 1: Midtrans / Transfer Online -->
                                <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 hover:border-green-500 transition-all group">
                                    <input type="radio" name="payment_method" value="midtrans" class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300" checked>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="block text-sm font-medium text-gray-900 group-hover:text-green-700">
                                                Transfer Bank / E-Wallet (Otomatis)
                                            </span>
                                            <!-- Icon Kartu -->
                                            <svg class="w-6 h-6 text-gray-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                        </div>
                                        <span class="block text-xs text-gray-500 mt-1">BCA, Mandiri, BNI, BRI, GoPay, ShopeePay via Midtrans.</span>
                                    </div>
                                </label>

                                <!-- Opsi 2: Bayar di Tempat (COD) -->
                                <label class="relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 hover:border-green-500 transition-all group">
                                    <input type="radio" name="payment_method" value="cod" class="h-5 w-5 text-green-600 focus:ring-green-500 border-gray-300">
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <span class="block text-sm font-medium text-gray-900 group-hover:text-green-700">
                                                Bayar di Tempat (COD)
                                            </span>
                                            <!-- Icon Cash -->
                                            <svg class="w-6 h-6 text-gray-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <span class="block text-xs text-gray-500 mt-1">Bayar tunai saat mengambil barang di toko.</span>
                                    </div>
                                </label>
                            </div>

                            <div class="mt-8">
                                <button type="button" id="pay-button" class="w-full bg-gradient-to-r from-green-600 to-teal-600 text-white font-bold py-4 px-6 rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                                    Bayar Sekarang
                                </button>
                                <p class="text-center text-xs text-gray-400 mt-4">Transaksi aman dan terenkripsi.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Midtrans -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    const payButton = document.getElementById('pay-button');
    const form = document.getElementById('payment-form');
    
    payButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Ambil nilai radio button yang dipilih
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;

        if (selectedMethod === 'cod') {
            // Jika COD, submit form secara manual ke controller untuk update status
            if(confirm('Anda memilih Bayar di Tempat. Pastikan datang ke toko untuk pengambilan barang. Lanjutkan?')) {
                form.submit();
            }
        } else {
            // Jika Midtrans, jalankan Snap Popup
            window.snap.pay('{{ $rental->snap_token }}', {
                onSuccess: function(result) {
                    // Redirect ke halaman sukses midtrans (biasanya finish redirect url)
                    window.location.href = "{{ route('customer.dashboard') }}?status=success";
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran!");
                    location.reload();
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                    location.reload();
                },
                onClose: function() {
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        }
    });
</script>
@endsection