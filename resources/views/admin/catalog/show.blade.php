@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10">

    <nav class="flex mb-8 text-sm text-slate-500">
        <a href="{{ route('catalog.index') }}" class="hover:text-emerald-600">Katalog</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800 font-medium">{{ $item->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

        <div class="space-y-4">
            <div class="aspect-square w-full bg-slate-100 rounded-3xl overflow-hidden relative shadow-lg border border-slate-100">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif

                @if($item->stock > 0)
                    <span class="absolute top-4 left-4 bg-emerald-500 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-md">
                        Tersedia
                    </span>
                @else
                    <span class="absolute top-4 left-4 bg-red-500 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-md">
                        Habis
                    </span>
                @endif
            </div>
        </div>

        <div>
            <span class="text-emerald-600 font-bold tracking-wide uppercase text-xs bg-emerald-50 px-3 py-1 rounded-full">
                {{ $item->category->name ?? 'Outdoor Gear' }}
            </span>

            <h1 class="text-4xl font-black text-slate-900 mt-4 mb-2 leading-tight">{{ $item->name }}</h1>

            <div class="flex items-center gap-4 mb-6">
                <div class="flex text-yellow-400 text-sm">★★★★★</div>
                <span class="text-slate-400 text-sm">| ID Barang: #{{ $item->id }}</span>
            </div>

            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 mb-8">
                <p class="text-slate-500 text-sm mb-1">Harga Sewa per Hari</p>
                <div class="flex items-end gap-2">
                    <span class="text-4xl font-bold text-slate-900">Rp {{ number_format($item->rental_price, 0, ',', '.') }}</span>
                    <span class="text-slate-500 mb-1">/ 24 Jam</span>
                </div>
            </div>

            <div class="prose prose-slate max-w-none mb-8 text-slate-600 leading-relaxed">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Deskripsi</h3>
                <p>{{ $item->description ?? 'Deskripsi belum ditambahkan untuk item ini.' }}</p>

                <ul class="mt-4 space-y-2 list-none pl-0">
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Kondisi Prima & Bersih
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Siap Pakai Langsung
                    </li>
                </ul>
            </div>

            <div class="flex gap-4">
                @if($item->stock > 0)
                    <button class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-emerald-500/30 transition transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        Sewa Sekarang
                    </button>
                @else
                    <button disabled class="flex-1 bg-slate-200 text-slate-400 font-bold py-4 rounded-xl cursor-not-allowed">
                        Stok Habis
                    </button>
                @endif

                <button class="px-4 py-4 bg-white border-2 border-slate-200 text-slate-600 rounded-xl hover:border-emerald-500 hover:text-emerald-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>
            </div>

            <p class="text-center text-xs text-slate-400 mt-4">
                Stok Tersedia: <span class="font-bold text-slate-700">{{ $item->stock }} Unit</span>
            </p>

        </div>
    </div>
</div>
@endsection
