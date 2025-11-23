@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    .font-poppins { font-family: 'Poppins', sans-serif; }
</style>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 font-poppins text-slate-800">

    {{-- HERO BANNER --}}
    <div class="relative rounded-3xl overflow-hidden mb-10 shadow-xl h-64 md:h-72 flex items-center group">
        <img src="https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?q=80&w=1470&auto=format&fit=crop" 
             alt="Camping Banner" 
             class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        
        <div class="absolute inset-0 bg-slate-900/70"></div>

        <div class="relative z-10 px-8 md:px-12 w-full flex flex-col md:flex-row justify-between items-center gap-6">

            @php
                $hour = now()->format('H');
                $hour = now()->setTimezone('Asia/Jakarta')->format('H');
                if ($hour < 12) {
                    $greeting = 'Selamat Pagi';
                    $icon = 'fa-mug-hot';
                } elseif ($hour < 15) {
                    $greeting = 'Selamat Siang';
                    $icon = 'fa-sun';
                } elseif ($hour < 18) {
                    $greeting = 'Selamat Sore';
                    $icon = 'fa-cloud-sun';
                } else {
                    $greeting = 'Selamat Malam';
                    $icon = 'fa-moon';
                }
            @endphp

            <div class="text-white">
                <p class="text-emerald-400 font-bold tracking-wider uppercase text-xs md:text-sm mb-2 flex items-center gap-2">
                    <i class="fa-solid {{ $icon }}"></i> {{ $greeting }}, Admin!
                </p>

                <h1 class="text-3xl md:text-4xl font-bold leading-tight mb-3">
                    Siap Kelola <span class="text-emerald-400">Petualangan?</span>
                </h1>

                <div class="flex flex-wrap gap-4 text-sm font-medium text-slate-300">
                    <span class="bg-white/10 px-3 py-1 rounded-full backdrop-blur-sm border border-white/10">
                        📅 {{ now()->translatedFormat('l, d F Y') }}
                    </span>
                    <span class="bg-white/10 px-3 py-1 rounded-full backdrop-blur-sm border border-white/10">
                        Server Status: <span class="text-emerald-400">● Online</span>
                    </span>
                </div>
            </div>

        </div>
    </div>

    {{-- CARD STAT --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        
        <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 hover:border-emerald-200 hover:-translate-y-1 transition duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl group-hover:scale-110 transition shadow-sm">
                    <i class="fa-solid fa-person-hiking"></i>
                </div>
                @if($activeRentals > 0)
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                    </span>
                @endif
            </div>
            <div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $activeRentals }}</h3>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Sedang Disewa</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 hover:border-emerald-200 hover:-translate-y-1 transition duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl group-hover:scale-110 transition shadow-sm">
                    <i class="fa-solid fa-tents"></i>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalItems }}</h3>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Total Gear</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 hover:border-emerald-200 hover:-translate-y-1 transition duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl group-hover:scale-110 transition shadow-sm">
                    <i class="fa-solid fa-users-viewfinder"></i>
                </div>
            </div>
            <div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $totalUsers }}</h3>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Sobat Petualang</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 hover:border-rose-200 hover:-translate-y-1 transition duration-300 group relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center text-xl group-hover:scale-110 transition shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-slate-800">{{ $lowStockCount }}</h3>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Perlu Restock</p>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- Riwayat --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-white">
                <h3 class="font-bold text-lg text-slate-800">Transaksi Terkini</h3>
                <a href="{{ route('admin.rentals.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 transition">
                    Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                @if ($recentRentals->count() === 0)
                    <div class="flex flex-col items-center justify-center py-16 text-center px-4">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 text-4xl mb-4">
                            <i class="fa-solid fa-mug-hot"></i>
                        </div>
                        <h4 class="text-slate-700 font-bold text-base mb-1">Belum ada yang sewa nih</h4>
                    </div>
                @else
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-400 font-semibold uppercase bg-slate-50/50 border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4">Penyewa</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Total Gear</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach ($recentRentals as $rental)
                        <tr class="hover:bg-slate-50/80 transition group cursor-pointer" onclick="window.location='{{ route('admin.rentals.show', $rental->id) }}'">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-100 to-emerald-200 text-emerald-700 flex items-center justify-center text-xs font-bold border-2 border-white shadow-sm">
                                        {{ substr($rental->user->name ?? 'User', 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-700">{{ $rental->user->name ?? 'Unknown User' }}</div>
                                        <div class="text-[11px] text-slate-400">
                                            {{ $rental->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold border 
                                    {{ $rental->status == 'rented' ? 'bg-blue-50 text-blue-600 border-blue-100' : 
                                      ($rental->status == 'returned' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 
                                      ($rental->status == 'canceled' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-amber-50 text-amber-600 border-amber-100')) }}">
                                    {{ ucfirst($rental->status == 'rented' ? 'Active' : $rental->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                {{-- Menggunakan details->sum('quantity') karena relasi yang benar adalah details --}}
                                <span class="font-bold text-slate-800">{{ $rental->details->sum('quantity') }}</span> Unit
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>

        {{-- Low Stock --}}
        <div class="space-y-8">
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-slate-800">Stok Menipis</h3>
                    @if($lowStockCount > 0)
                        <span class="bg-rose-50 text-rose-600 text-[10px] font-bold px-2 py-1 rounded-md animate-pulse">
                            {{ $lowStockCount }} Item Kritis
                        </span>
                    @endif
                </div>

                @if ($lowStockList->count() === 0)
                    <div class="py-6 text-center">
                        <p class="text-sm text-emerald-600 font-medium">
                            <i class="fa-solid fa-check-circle mr-1"></i> Aman, stok melimpah!
                        </p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($lowStockList as $item)
                            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-700">{{ $item->name }}</h4>
                                    <span class="text-[10px] text-rose-500 font-semibold">Segera Restock!</span>
                                </div>
                                <div class="text-xl font-bold text-rose-500">{{ $item->stock }}</div>
                            </div>
                        @endforeach
                    </div>
                    
                    <a href="{{ route('admin.items.create') }}" class="mt-6 block w-full py-3 text-center text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-xl transition shadow-md hover:shadow-lg">
                        <i class="fa-solid fa-plus mr-1"></i> Restock Barang
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection