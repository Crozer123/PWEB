@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 py-10 relative overflow-hidden">
    
    {{-- Background Decoration --}}
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-emerald-600/10 to-transparent -z-10"></div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">

        {{-- 1. HEADER SECTION --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div>
                {{-- Breadcrumb / Back --}}
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-emerald-600 transition mb-2 group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Dashboard
                </a>
                <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-800 to-slate-600 tracking-tight">
                    Inventory Items
                </h1>
                <p class="text-slate-500 mt-2 text-lg">Kelola semua peralatan dan stok rental Anda.</p>
            </div>

            {{-- Add Button --}}
            <a href="{{ route('admin.items.create') }}" 
               class="group relative inline-flex items-center justify-center px-8 py-3 font-bold text-white transition-all duration-200 bg-emerald-600 font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-600 hover:bg-emerald-700 hover:shadow-lg hover:-translate-y-1">
                <span class="mr-2 text-lg">+</span> Tambah Item Baru
                <div class="absolute inset-0 rounded-xl ring-2 ring-white/20 group-hover:ring-white/40 transition-all"></div>
            </a>
        </div>

        {{-- 2. SEARCH BAR (Clean & Functional) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 mb-6">
            <form action="{{ route('admin.items.index') }}" method="GET" class="flex items-center gap-4">
                
                {{-- Input Pencarian --}}
                <div class="relative w-full md:w-96">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari nama item..." 
                           class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition duration-150 sm:text-sm">
                </div>

                {{-- Tombol Reset (Hanya muncul jika sedang mencari) --}}
                @if(request('search'))
                    <a href="{{ route('admin.items.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 border border-rose-200 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-xl text-sm font-bold transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Reset
                    </a>
                @endif

            </form>
        </div>

        {{-- 3. TABLE CONTAINER --}}
        <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            @foreach (['Item Details', 'Category', 'Price / Day', 'Stock Status', 'Actions'] as $head)
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    {{ $head }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse ($items as $item)
                        <tr class="hover:bg-slate-50/80 transition duration-200 group">
                            
                            {{-- ITEM COLUMN --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-14 w-14 relative">
                                        @if($item->image)
                                            <img class="h-14 w-14 rounded-xl object-cover shadow-sm border border-slate-100 group-hover:scale-105 transition duration-300"
                                                 src="{{ asset('storage/' . $item->image) }}"
                                                 alt="{{ $item->name }}">
                                        @else
                                            <div class="h-14 w-14 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-slate-800 group-hover:text-emerald-600 transition">{{ $item->name }}</div>
                                        <div class="text-xs text-slate-400 font-mono mt-0.5">ID: #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- CATEGORY COLUMN --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    {{ $item->category->name ?? 'Uncategorized' }}
                                </span>
                            </td>

                            {{-- PRICE COLUMN --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-700">
                                    Rp {{ number_format($item->rental_price, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-slate-400">per hari</div>
                            </td>

                            {{-- STOCK STATUS PILL --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $stock = $item->stock;
                                    $status = match(true) {
                                        $stock == 0 => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'dot' => 'bg-red-500', 'label' => 'Out of Stock'],
                                        $stock <= 5 => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500', 'label' => 'Low Stock (' . $stock . ')'],
                                        default => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500', 'label' => 'In Stock (' . $stock . ')']
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold {{ $status['bg'] }} {{ $status['text'] }} border border-transparent">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $status['dot'] }}"></span>
                                    {{ $status['label'] }}
                                </span>
                            </td>

                            {{-- ACTION ICONS ROW --}}
                            <td class="px-6 py-4 whitespace-nowrap text-left">
                                <div class="flex items-center justify-start gap-1">
                                    
                                    {{-- View --}}
                                    <a href="{{ route('admin.items.show', $item) }}" class="group/btn relative p-2 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-[10px] font-bold text-white bg-slate-800 rounded opacity-0 group-hover/btn:opacity-100 transition-opacity duration-200 pointer-events-none z-10 shadow-lg">Detail</span>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.items.edit', $item) }}" class="group/btn relative p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-[10px] font-bold text-white bg-slate-800 rounded opacity-0 group-hover/btn:opacity-100 transition-opacity duration-200 pointer-events-none z-10 shadow-lg">Edit</span>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus item ini permanen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="group/btn relative p-2 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-all duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-[10px] font-bold text-white bg-slate-800 rounded opacity-0 group-hover/btn:opacity-100 transition-opacity duration-200 pointer-events-none z-10 shadow-lg">Hapus</span>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Belum ada item</h3>
                                    <p class="text-slate-500 mt-1 mb-6 max-w-sm mx-auto">Inventory Anda masih kosong. Mulai tambahkan peralatan untuk disewakan.</p>
                                    <a href="{{ route('admin.items.create') }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition shadow-md">
                                        Tambah Item Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Footer --}}
            @if ($items->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection