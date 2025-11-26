@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 font-poppins text-slate-800">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1 text-sm">
                <a href="{{ route('admin.items.index') }}" class="text-slate-400 hover:text-emerald-600 transition font-medium flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-500">Detail Barang</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-800 tracking-tight">{{ $item->name }}</h1>
        </div>
        
        <div class="flex gap-3">
            <a href="{{ route('admin.items.edit', $item) }}" class="px-5 py-2.5 bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 rounded-xl font-semibold transition flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square"></i> Edit Barang
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-2">
                <div class="relative rounded-2xl overflow-hidden bg-slate-50 aspect-square group">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" 
                             alt="{{ $item->name }}" 
                             class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                        
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition duration-300 flex items-center justify-center"></div>
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                            <i class="fa-regular fa-image text-6xl mb-3"></i>
                            <span class="text-sm font-medium">Tidak ada gambar</span>
                        </div>
                    @endif
                    
                    <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-lg shadow-sm border border-white/50">
                        <span class="text-xs font-bold text-slate-600 font-mono">ID: #{{ $item->id }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-box-archive text-slate-400"></i> Status Stok
                </h3>
                
                @php
                    if($item->stock > 10) {
                        $stockClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                        $icon = 'fa-check-circle';
                        $msg = 'Stok Aman';
                        $desc = 'Siap untuk disewakan';
                    } elseif($item->stock > 0) {
                        $stockClass = 'bg-amber-50 text-amber-700 border-amber-100';
                        $icon = 'fa-triangle-exclamation';
                        $msg = 'Stok Menipis';
                        $desc = 'Segera lakukan restock';
                    } else {
                        $stockClass = 'bg-rose-50 text-rose-700 border-rose-100';
                        $icon = 'fa-circle-xmark';
                        $msg = 'Stok Habis';
                        $desc = 'Barang tidak tersedia';
                    }
                @endphp

                <div class="flex items-center justify-between p-4 rounded-2xl border {{ $stockClass }}">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid {{ $icon }} text-2xl"></i>
                        <div>
                            <p class="font-bold leading-tight">{{ $msg }}</p>
                            <p class="text-xs opacity-80 mt-0.5">{{ $desc }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block text-2xl font-bold leading-none">{{ $item->stock }}</span>
                        <span class="text-[10px] uppercase font-bold opacity-70">Unit</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-50">
                    <h3 class="font-bold text-lg text-slate-800">Informasi Barang</h3>
                </div>
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-blue-200 transition group">
                        <div class="w-12 h-12 rounded-xl bg-white text-blue-600 border border-blue-100 flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Harga Sewa</p>
                            <p class="text-xl font-bold text-slate-800">
                                Rp {{ number_format($item->rental_price, 0, ',', '.') }}
                                <span class="text-xs text-slate-400 font-normal lowercase">/ hari</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 hover:border-purple-200 transition group">
                        <div class="w-12 h-12 rounded-xl bg-white text-purple-600 border border-purple-100 flex items-center justify-center text-xl shadow-sm group-hover:scale-110 transition">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Kategori</p>
                            <p class="text-xl font-bold text-slate-800">{{ $item->category->name ?? 'Tanpa Kategori' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 min-h-[200px]">
                <h3 class="font-bold text-lg text-slate-800 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-align-left text-emerald-500"></i> Deskripsi
                </h3>
                <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                    {!! nl2br(e($item->description)) !!}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection