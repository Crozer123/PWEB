@extends('layouts.app')

@section('content')
    @php
        $isEdit = isset($item);
        $title = $isEdit ? 'Edit Barang: ' . $item->name : 'Tambah Barang Baru';
        $action = $isEdit ? route('admin.items.update', $item) : route('admin.items.store');
        $method = $isEdit ? 'PUT' : 'POST';
    @endphp

    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $title }}</h1>

        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method($method)

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $item->name ?? '') }}"
                           class="w-full rounded-lg border px-4 py-2 outline-none transition focus:ring-2 {{ $errors->has('name') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }}">
                    @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" id="category_id" required
                            class="w-full rounded-lg border px-4 py-2 outline-none transition focus:ring-2 {{ $errors->has('category_id') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }}">
                        <option value=""> Pilih Kategori </option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (old('category_id', $item->category_id ?? '') == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="rental_price" class="block text-sm font-medium text-gray-700 mb-1">Harga Sewa per Hari (Rp)</label>
                    <input type="number" name="rental_price" id="rental_price" required min="1000" step="any" value="{{ old('rental_price', $item->rental_price ?? '') }}"
                           class="w-full rounded-lg border px-4 py-2 outline-none transition focus:ring-2 {{ $errors->has('rental_price') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }}">
                    @error('rental_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stok Total</label>
                    <input type="number" name="stock" id="stock" required min="0" value="{{ old('stock', $item->stock ?? '') }}"
                           class="w-full rounded-lg border px-4 py-2 outline-none transition focus:ring-2 {{ $errors->has('stock') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }}">
                    @error('stock')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Barang</label>
                    <textarea name="description" id="description" rows="4" required
                              class="w-full rounded-lg border px-4 py-2 outline-none transition focus:ring-2 {{ $errors->has('description') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }}">{{ old('description', $item->description ?? '') }}</textarea>
                    @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Barang</label>
                    <input type="file" name="image" id="image"
                           class="w-full rounded-lg border px-4 py-2 outline-none transition focus:ring-2 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 {{ $errors->has('image') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-indigo-500 focus:border-indigo-500' }}">
                    @if ($isEdit && $item->image)
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-32 h-32 object-cover rounded-lg shadow-md">
                        </div>
                    @endif
                    @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="pt-2">
                    <a href="{{ route('admin.items.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition mr-3">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Barang' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection