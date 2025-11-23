@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    .font-poppins { font-family: 'Poppins', sans-serif; }
</style>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 font-poppins text-slate-800">

    {{-- HERO BANNER (Mirip Admin) --}}
    <div class="relative rounded-3xl overflow-hidden mb-10 shadow-xl h-64 md:h-72 flex items-center group">
        {{-- Gambar Background (Bisa diganti URL-nya sesuai selera) --}}
        <img src="https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=1470&auto=format&fit=crop" 
             alt="Camping Customer" 
             class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        
        <div class="absolute inset-0 bg-slate-900/70"></div>

        <div class="relative z-10 px-8 md:px-12 w-full flex flex-col md:flex-row justify-between items-center gap-6">

            @php
                // Logika Sapaan Waktu (Pagi/Siang/Sore/Malam)
                // Paksa Timezone Asia/Jakarta agar akurat
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
                    <i class="fa-solid {{ $icon }}"></i> {{ $greeting }}, {{ Auth::user()->name }}!
                </p>

                <h1 class="text-3xl md:text-4xl font-bold leading-tight mb-3">
                    Siap Menjelajah <span class="text-emerald-400">Alam Bebas?</span>
                </h1>

                <div class="flex flex-wrap gap-4 text-sm font-medium text-slate-300">
                    <span class="bg-white/10 px-3 py-1 rounded-full backdrop-blur-sm border border-white/10">
                        📅 {{ now()->translatedFormat('l, d F Y') }}
                    </span>
                    <a href="{{ route('customer.catalog.index') }}" 
                       class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-1 rounded-full backdrop-blur-sm transition shadow-lg flex items-center gap-2">
                       <i class="fa-solid fa-magnifying-glass"></i> Cari Alat Sekarang
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- CARD STATISTIK CUSTOMER --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        
        <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 hover:border-emerald-200 hover:-translate-y-1 transition duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl group-hover:scale-110 transition shadow-sm">
                    <i class="fa-solid fa-person-hiking"></i>
                </div>
                @if(($activeRentals ?? 0) > 0)
                    <span class="flex h-3 w-3 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                    </span>
                @endif
            </div>
            <div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $activeRentals ?? 0 }}</h3>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Sedang Disewa</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-slate-100 hover:border-emerald-200 hover:-translate-y-1 transition duration-300 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl group-hover:scale-110 transition shadow-sm">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>
            <div>
                {{-- Hitung jumlah riwayat jika ada --}}
                <h3 class="text-3xl font-bold text-slate-800">{{ isset($recentRentals) ? $recentRentals->count() : 0 }}</h3>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Riwayat Transaksi</p>
            </div>
        </div>

    </div>

    {{-- RIWAYAT TRANSAKSI --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-white">
            <h3 class="font-bold text-lg text-slate-800">Aktivitas Terkini</h3>
            <a href="{{ route('customer.rentals.history') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 transition">
                Lihat Semua <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            @if (!isset($recentRentals) || $recentRentals->count() === 0)
                <div class="flex flex-col items-center justify-center py-16 text-center px-4">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 text-4xl mb-4">
                        <i class="fa-solid fa-basket-shopping"></i>
                    </div>
                    <h4 class="text-slate-700 font-bold text-base mb-1">Belum ada penyewaan</h4>
                    <p class="text-slate-400 text-sm mb-4">Yuk mulai petualanganmu sekarang!</p>
                    <a href="{{ route('customer.catalog.index') }}" class="px-6 py-2 bg-emerald-600 text-white rounded-full font-bold text-sm hover:bg-emerald-700 transition">
                        Sewa Alat
                    </a>
                </div>
            @else
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-400 font-semibold uppercase bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Tanggal Sewa</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Total Barang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($recentRentals as $rental)
                    <tr class="hover:bg-slate-50/80 transition group cursor-pointer" onclick="window.location='{{ route('customer.rentals.show', $rental->id) }}'">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-100 to-emerald-200 text-emerald-700 flex items-center justify-center text-xs font-bold border-2 border-white shadow-sm">
                                    <i class="fa-regular fa-calendar-check"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-700">{{ $rental->created_at->format('d F Y') }}</div>
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
                                {{ ucfirst($rental->status == 'rented' ? 'Sedang Dipinjam' : $rental->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-bold text-slate-800">{{ $rental->details->sum('quantity') }}</span> Unit
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

</div>
@endsection