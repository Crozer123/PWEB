@extends('layouts.app')

@section('title', 'Detail Penyewaan - Foresta Adventure')

@section('content')

<div class="min-h-screen bg-gray-50 py-10 font-poppins">

    <div class="max-w-5xl mx-auto px-6">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-1">Detail Penyewaan</h1>
                <p class="text-gray-500 text-sm">
                    ID Transaksi: <span class="font-semibold text-gray-700">#{{ $rental->id }}</span>
                </p>
            </div>

            <a href="{{ route('customer.rental.history') }}"
               class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 text-sm font-semibold flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Status Penyewaan</p>
                    <h2 class="text-xl font-bold text-gray-800 mt-1 capitalize">
                        {{ $rental->status }}
                    </h2>
                </div>

                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    @class([
                        'bg-blue-100 text-blue-700' => $rental->status == 'pending',
                        'bg-amber-100 text-amber-700' => $rental->status == 'waiting',
                        'bg-green-100 text-green-700' => $rental->status == 'approved',
                        'bg-red-100 text-red-700' => $rental->status == 'rejected',
                    ])">
                    {{ ucfirst($rental->status) }}
                </span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Informasi Penyewaan</h3>

            <div class="grid md:grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="text-gray-500">Tanggal Pesan</p>
                    <p class="font-semibold text-gray-800">
                        {{ $rental->created_at->format('d M Y - H:i') }} WIB
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Tanggal Pengembalian</p>
                    <p class="font-semibold text-gray-800">
                        {{ $rental->return_date ? $rental->return_date->format('d M Y') : '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Total Harga</p>
                    <p class="font-semibold text-gray-800">
                        Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Jumlah Barang</p>
                    <p class="font-semibold text-gray-800">
                        {{ $rental->items->count() }} item
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Barang yang Disewa</h3>

            <div class="space-y-4">
                @foreach ($rental->items as $item)
                <div class="flex items-center justify-between border-b pb-4">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('storage/' . $item->image) }}"
                             class="w-16 h-16 rounded-lg object-cover border">

                        <div>
                            <p class="font-semibold text-gray-800">{{ $item->name }}</p>
                            <p class="text-gray-500 text-sm">
                                Rp {{ number_format($item->price, 0, ',', '.') }} / hari
                            </p>
                        </div>
                    </div>

                    <p class="font-semibold text-gray-700">1 Unit</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Bukti Pembayaran</h3>

            @if ($rental->payment_proof)
                <img src="{{ asset('storage/'.$rental->payment_proof) }}"
                     class="w-full max-w-md rounded-xl shadow-md border">
            @else
                <p class="text-gray-500 text-sm">Belum ada bukti pembayaran diunggah.</p>
            @endif
        </div>

        <div class="bg-emerald-600 text-white rounded-xl p-6 flex items-center justify-between shadow-lg">
            <div>
                <h3 class="text-xl font-bold mb-1">Butuh bantuan?</h3>
                <p class="text-emerald-50 text-sm">Hubungi admin untuk konfirmasi lebih lanjut.</p>
            </div>

            <a href="https://wa.me/6283869634931"
               class="bg-white text-emerald-700 px-5 py-3 rounded-lg font-semibold shadow hover:bg-gray-100">
                Hubungi via WhatsApp
            </a>
        </div>

    </div>

</div>

@endsection
