@extends('layouts.app')

@section('content')

<style>
    /* Font utama */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
    .font-poppins { font-family: 'Poppins', sans-serif; }
</style>

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 font-poppins text-slate-800">

    <!-- HERO BANNER -->
    <div class="relative bg-gradient-to-r from-emerald-900 to-emerald-800 rounded-3xl p-8 mb-10 overflow-hidden shadow-xl">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full -mr-16 -mt-16 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-40 h-40 bg-emerald-400 opacity-10 rounded-full -ml-10 -mb-10 blur-2xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center gap-6">
                <div class="bg-white/10 p-4 rounded-2xl backdrop-blur-sm border border-white/10 shadow-inner">
                    <i class="fa-solid fa-person-hiking text-4xl text-emerald-300"></i>
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white tracking-tight mb-1">
                        Halo, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-emerald-100 text-sm md:text-base font-light">
                        Siap bertualang hari ini? Pantau status penyewaanmu di sini.
                    </p>
                </div>
            </div>

            <div class="hidden md:block">
                <a href="{{ route('customer.catalog.index') }}"
                   class="bg-white text-emerald-900 hover:bg-emerald-50 px-6 py-3 rounded-xl font-bold text-sm transition shadow-lg flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari Alat Outdoor
                </a>
            </div>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

        <!-- Total sewa aktif -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]
            border border-slate-100 hover:border-emerald-200 hover:-translate-y-1 transition duration-300 group">

            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center
                    text-xl group-hover:scale-110 transition shadow-sm">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <span class="text-[10px] font-bold bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full border border-blue-100">
                    Status
                </span>
            </div>

            <h3 class="text-3xl font-bold text-slate-800">{{ $activeRentals ?? 0 }}</h3>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Sedang Disewa</p>
        </div>

        <!-- Transaksi terbaru -->
        <div class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]
            border border-slate-100 hover:border-emerald-200 hover:-translate-y-1 transition duration-300 group">

            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center
                    text-xl group-hover:scale-110 transition shadow-sm">
                    <i class="fa-solid fa-receipt"></i>
                </div>
            </div>

            <h3 class="text-3xl font-bold text-slate-800">{{ isset($recentRentals) ? $recentRentals->count() : 0 }}</h3>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Transaksi Terakhir</p>
        </div>
    </div>

    <!-- TABLE RIWAYAT PENYEWAAN -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">

        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-white">
            <div class="flex items-center gap-3">
                <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                <div>
                    <h3 class="font-bold text-lg text-slate-800">Riwayat Penyewaan Saya</h3>
                    <p class="text-xs text-slate-400">Daftar transaksi terbaru Anda</p>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">

            @if (!isset($recentRentals) || $recentRentals->count() === 0)
                <!-- Empty state -->
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center
                        text-slate-300 text-3xl mb-4">
                        <i class="fa-solid fa-basket-shopping"></i>
                    </div>
                    <p class="text-slate-500 font-medium">Anda belum menyewa alat apapun.</p>
                    <a href="{{ route('customer.catalog.index') }}"
                       class="mt-4 text-emerald-600 font-bold text-sm hover:underline">
                        Mulai Sewa Sekarang
                    </a>
                </div>

            @else
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-400 font-semibold uppercase bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Tanggal Sewa</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Jumlah Barang</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-50">
                    @foreach ($recentRentals as $r)
                    <tr class="hover:bg-slate-50/80 transition group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center
                                    justify-center text-xs font-bold border-2 border-white shadow-sm">
                                    <i class="fa-regular fa-calendar"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-700">{{ $r->created_at->format('d F Y') }}</div>
                                    <div class="text-[11px] text-slate-400">Pukul {{ $r->created_at->format('H:i') }} WIB</div>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span class="px-3 py-1.5 rounded-full text-[11px] font-bold bg-slate-50 text-slate-600
                                border border-slate-100">
                                {{ ucfirst($r->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right">
                            <span class="font-bold text-slate-800 text-base">{{ $r->details->sum('quantity') }}</span>
                            <span class="text-xs text-slate-400">Unit</span>
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
