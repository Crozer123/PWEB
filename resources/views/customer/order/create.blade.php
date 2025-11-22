@extends('layouts.app')

@section('title', 'Form Penyewaan')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 font-poppins text-slate-800">

    <nav class="flex items-center text-sm text-slate-500 mb-8">
        <a href="{{ route('customer.dashboard') }}" class="hover:text-emerald-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('customer.catalog.index') }}" class="hover:text-emerald-600">Katalog</a>
        <span class="mx-2">/</span>
        <span class="text-emerald-600 font-semibold">Form Penyewaan</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

        {{-- LEFT: DETAIL ITEM --}}
        <div class="bg-white rounded-xl shadow p-6 border border-slate-100">
            <h2 class="font-bold text-lg mb-4">Detail Barang</h2>

            <div class="flex items-start gap-4">
                <img src="{{ asset('storage/' . $item->image) }}" 
                    class="w-32 h-32 object-cover rounded-lg border">

                <div>
                    <h3 class="text-xl font-bold">{{ $item->name }}</h3>
                    <p class="text-emerald-600 font-semibold">
                        Rp {{ number_format($item->rental_price, 0, ',', '.') }} / 24 Jam
                    </p>
                    <p class="mt-2 text-sm">
                        Stok tersedia: <strong>{{ $item->stock }}</strong>
                    </p>
                </div>
            </div>
        </div>

        {{-- RIGHT: FORM --}}
        <div class="bg-white rounded-xl shadow p-6 border border-slate-100">

            <h2 class="font-bold text-lg mb-4">Form Penyewaan</h2>

            <form action="{{ route('customer.order.store') }}" method="POST">
                @csrf

                {{-- ITEM ID --}}
                <input type="hidden" name="items[0][item_id]" value="{{ $item->id }}">

                {{-- Tanggal sewa --}}
                <label class="block text-sm font-semibold mb-1">Tanggal Sewa</label>
                <input type="date" 
                       name="rental_date" 
                       required 
                       class="w-full border rounded-lg p-3 mb-4">

                {{-- Tanggal kembali --}}
                <label class="block text-sm font-semibold mb-1">Tanggal Pengembalian</label>
                <input type="date" 
                       name="return_date" 
                       required 
                       class="w-full border rounded-lg p-3 mb-4">

                {{-- Quantity --}}
                <label class="block text-sm font-semibold mb-1">Jumlah Unit</label>
                <input type="number" 
                       name="items[0][quantity]" 
                       value="1" 
                       min="1" 
                       max="{{ $item->stock }}" 
                       required 
                       class="w-full border rounded-lg p-3 mb-6">

                {{-- Submit --}}
                <button class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-xl font-bold">
                    <i class="fa-solid fa-check mr-2"></i>
                    Buat Penyewaan
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
