@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 font-poppins text-slate-800">

    <nav class="flex items-center text-sm text-slate-500 mb-8">
        <a href="{{ route('customer.dashboard') }}" class="hover:text-emerald-600">Dashboard</a>
        <span class="mx-3">/</span>
        <a href="{{ route('customer.catalog.index') }}" class="hover:text-emerald-600">Katalog</a>
        <span class="mx-3">/</span>
        <span class="text-emerald-600 font-semibold">Form Penyewaan</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        <!-- ITEM INFO -->
        <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-sm">
            <h2 class="text-xl font-bold mb-6">Detail Barang</h2>

            <div class="flex gap-6">
                <div class="w-32 h-32 bg-gray-50 rounded-xl overflow-hidden flex items-center justify-center border">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-contain p-2">
                    @else
                        <i class="fa-solid fa-image text-gray-300 text-2xl"></i>
                    @endif
                </div>

                <div>
                    <p class="text-lg font-bold text-slate-800">{{ $item->name }}</p>
                    <p class="text-emerald-600 font-semibold mt-2">
                        Rp {{ number_format($item->rental_price, 0, ',', '.') }} / 24 Jam
                    </p>
                    <p class="text-sm text-slate-500 mt-2">
                        Stok tersedia: <span class="font-semibold">{{ $item->stock }}</span>
                    </p>
                </div>
            </div>
        </div>

        @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                <strong class="font-bold">Periksa input Anda:</strong>
                <ul class="list-disc list-inside mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- FORM -->
        <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-sm">

            <h2 class="text-xl font-bold mb-6">Form Penyewaan</h2>

            <form action="{{ route('customer.order.store') }}" method="POST" class="space-y-5">
                @csrf

                <input type="hidden" name="items[0][item_id]" value="{{ $item->id }}">

                <!-- Tanggal Sewa -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Tanggal Sewa</label>
                    <input type="date" name="rental_date" required class="w-full p-3 border rounded-xl">
                </div>

                <!-- Tanggal Kembali -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Tanggal Pengembalian</label>
                    <input type="date" name="return_date" required class="w-full p-3 border rounded-xl">
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-semibold mb-1">Jumlah Unit</label>
                    <input type="number" name="items[0][quantity]" min="1" max="{{ $item->stock }}" value="1"
                        class="w-full p-3 border rounded-xl">
                </div>

                <!-- Submit -->
                <button
                    class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-md hover:shadow-emerald-500/30 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check-circle"></i>
                    Buat Penyewaan
                </button>
            </form>

        </div>

    </div>
</div>
@endsection
