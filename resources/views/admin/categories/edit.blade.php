@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-md bg-white rounded-xl shadow-sm border border-slate-100 p-8">
        
        <h2 class="text-xl font-bold text-slate-800 mb-6">Edit Kategori</h2>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}"
                       class="w-full rounded-lg border-slate-300 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition"
                       required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.categories.index') }}" class="w-1/2 text-center text-slate-500 hover:text-slate-700 font-medium py-3 transition">
                    Batal
                </a>
                <button type="submit" class="w-1/2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl transition shadow-md">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection