@extends('layouts.app')

@section('title', 'Pemesanan Berhasil - Foresta Adventure')

@section('content')

<div class="min-h-screen bg-gray-50 py-16 font-poppins">

    <div class="max-w-3xl mx-auto text-center px-6">

        <!-- Icon Success -->
        <div class="w-28 h-28 mx-auto bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center shadow mb-6">
            <i class="fa-solid fa-circle-check text-6xl"></i>
        </div>

        <h1 class="text-3xl font-extrabold text-gray-800 mb-2">
            Pemesanan Berhasil!
        </h1>

        <p class="text-gray-500 mb-8 text-lg">
            Penyewaan kamu sudah dibuat dengan status <span class="font-semibold text-emerald-600">Pending</span>.  
            Admin akan segera mengonfirmasi pesananmu.
        </p>

        <!-- Info Box -->
        <div class="bg-white shadow-md border border-gray-100 rounded-2xl p-6 text-left mb-10">
            
            <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Pesanan</h2>

            <div class="space-y-4 text-sm">

                <div class="flex justify-between">
                    <span class="text-gray-500">ID Pesanan</span>
                    <span class="font-semibold text-gray-800">#{{ $rental->id }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Pemesanan</span>
                    <span class="font-semibold text-gray-800">
                        {{ $rental->created_at->format('d M Y - H:i') }} WIB
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Jumlah Item</span>
                    <span class="font-semibold text-gray-800">
                        {{ $rental->details->count() }} barang
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="font-semibold text-emerald-600 capitalize">{{ $rental->status }}</span>
                </div>

            </div>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">

            <a href="{{ route('customer.rentals.show', $rental->id) }}"
               class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-eye"></i>
                Lihat Detail Pesanan
            </a>

            <a href="{{ route('customer.catalog.index') }}"
               class="px-6 py-3 bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 font-bold rounded-xl transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke Katalog
            </a>

        </div>

        <p class="text-xs text-gray-400 mt-10">
            <i class="fa-solid fa-shield-halved mr-1"></i> Foresta Adventure — Penyewaan alat outdoor terpercaya.
        </p>

    </div>

</div>

@endsection
