@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            
            <!-- Card Pemberitahuan -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                
                <!-- Header Status -->
                <div class="bg-gradient-to-r from-green-600 to-teal-600 p-8 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white bg-opacity-20 rounded-full mb-4 backdrop-blur-sm">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m8-2a2 2 0 100-4m0 4a2 2 0 110-4m-6 8h12j"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Pesanan Berhasil Dibuat!</h1>
                    <p class="text-green-50 text-lg">Silakan selesaikan pembayaran di toko.</p>
                </div>

                <div class="p-8">
                    <!-- Instruksi Pembayaran -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8 rounded-r-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Tunjukkan <strong>ID Sewa</strong> di bawah ini kepada kasir kami untuk melakukan pembayaran dan pengambilan barang.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pesanan Singkat -->
                    <div class="border rounded-xl p-6 bg-gray-50 mb-8">
                        <div class="flex justify-between items-center mb-4 border-b border-gray-200 pb-4">
                            <span class="text-gray-500">ID Sewa</span>
                            <span class="text-2xl font-bold text-gray-800 tracking-wider">#RNT-{{ $rental->id }}</span>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tanggal Pengambilan</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($rental->rental_date)->format('d F Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tanggal Pengembalian</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($rental->return_date)->format('d F Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Total Item</span>
                                <span class="font-medium text-gray-900">{{ $rental->details->sum('quantity') }} Barang</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                            <span class="font-semibold text-gray-700">Total Tagihan</span>
                            <span class="text-xl font-bold text-green-600">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('customer.rentals.history') }}" class="w-full sm:w-auto px-6 py-3 bg-gray-800 text-white rounded-xl hover:bg-gray-700 transition font-medium text-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Lihat Riwayat Pesanan
                        </a>
                        <a href="{{ route('customer.dashboard') }}" class="w-full sm:w-auto px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-medium text-center">
                            Kembali ke Katalog
                        </a>
                    </div>

                </div>
            </div>
            
            <p class="text-center text-gray-400 text-sm mt-8">
                Harap lakukan pembayaran maksimal 1x24 jam sebelum tanggal pengambilan.
            </p>

        </div>
    </div>
</div>
@endsection