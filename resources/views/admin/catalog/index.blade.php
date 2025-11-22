@extends('layouts.app')

@section('content')

<div class="text-center max-w-3xl mx-auto mb-12 mt-8">
    <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
        Peralatan <span class="text-emerald-600">Terbaik</span> Untuk Petualanganmu
    </h1>
    <p class="text-lg text-slate-500">
        Pilih perlengkapan outdoor berkualitas tinggi, bersih, dan siap pakai untuk menemani perjalanan Anda.
    </p>
</div>

<div class="max-w-xl mx-auto mb-12 relative">
    <input type="text" placeholder="Cari tenda, tas, atau sepatu..." class="w-full pl-12 pr-4 py-3 rounded-full border border-slate-200 shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
    <svg class="w-6 h-6 text-slate-400 absolute left-4 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
    @forelse($items as $item)
    <a href="{{ route('catalog.show', $item) }}" class="group bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full">
        
        <div class="relative h-56 bg-slate-100 overflow-hidden">
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            @else
                <div class="flex items-center justify-center h-full text-slate-300">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif

            <div class="absolute top-3 left-3">
                <span class="bg-white/90 backdrop-blur-sm text-slate-700 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                    {{ $item->category->name ?? 'Outdoor' }}
                </span>
            </div>
        </div>

        <div class="p-5 flex flex-col flex-grow">
            <h3 class="text-lg font-bold text-slate-800 group-hover:text-emerald-600 transition mb-1 line-clamp-1">
                {{ $item->name }}
            </h3>

            <div class="flex items-center gap-1 mb-3">
                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.11
