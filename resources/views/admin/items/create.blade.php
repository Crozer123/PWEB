@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">

        {{-- Tombol Kembali ke Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 mb-6 px-4 py-2 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-50 transition text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Dashboard
        </a>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Tambah Produk Baru</h1>

            {{-- Tombol Kembali ke Daftar Produk --}}
            <a href="{{ route('admin.items.index') }}"
               class="px-4 py-2 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition shadow-md">
                Kembali ke Daftar Produk
            </a>
        </div>

        <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-100 p-6">
            <form action="{{ route('admin.items.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Barang:</label>
                    <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Kategori:</label>
                    <select name="category_id" id="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('category_id') border-red-500 @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $item)
                            <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->name ?? $item->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="rental_price" class="block text-gray-700 text-sm font-bold mb-2">Harga Rental per Hari:</label>
                    <input type="number" name="rental_price" id="rental_price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('rental_price') border-red-500 @enderror" value="{{ old('rental_price') }}" required min="0">
                    @error('rental_price')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition shadow-md">
                        Simpan Produk
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
