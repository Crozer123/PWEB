@extends('layouts.app')

@section('title', 'Cara Sewa - Foresta Adventure')

@section('content')

<div class="min-h-screen bg-slate-50 font-poppins">

    {{-- 1. HERO BANNER --}}
    <div class="relative h-[400px] bg-cover bg-center bg-fixed"
         style="background-image: url('https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=1920');">
        <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-[2px]"></div>

        <div class="relative h-full max-w-7xl mx-auto px-6 lg:px-8 flex flex-col justify-center text-center items-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-emerald-300 text-sm font-medium mb-4 backdrop-blur-md">
                <i class="fa-solid fa-circle-info"></i> Panduan Pelanggan
            </div>
            <h1 class="text-white text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
                Cara Mudah Sewa Alat Outdoor
            </h1>
            <p class="text-slate-300 text-lg max-w-2xl">
                Nikmati petualangan tanpa ribet. Ikuti langkah mudah berikut untuk menyewa peralatan camping di <span class="text-emerald-400 font-bold">For Rest Adventure</span>.
            </p>
        </div>
    </div>

    {{-- 2. MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- KOLOM KIRI: TIMELINE LANGKAH-LANGKAH --}}
            <div class="lg:col-span-2">
                
                <div class="mb-10 border-b border-slate-200 pb-6">
                    <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                        <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600">
                            <i class="fa-solid fa-list-check"></i>
                        </span>
                        Alur Peminjaman
                    </h2>
                </div>

                @php
                    $steps = [
                        [
                            'icon' => 'fa-magnifying-glass',
                            'color' => 'blue',
                            'title' => '1. Pilih Barang di Katalog',
                            'text' => 'Jelajahi menu katalog kami. Gunakan fitur pencarian atau kategori untuk menemukan tenda, carrier, atau alat masak yang Anda butuhkan. Stok kami selalu update secara real-time.',
                            'list' => []
                        ],
                        [
                            'icon' => 'fa-user-check',
                            'color' => 'emerald',
                            'title' => '2. Lengkapi Profil Anda',
                            'text' => 'Sebelum menyewa pastikan anda  melengkapi data diri',
                            'list' => ['Data wajib valid untuk validasi admin.', 'Privasi data Anda terjamin aman.']
                        ],
                        [
                            'icon' => 'fa-cart-shopping',
                            'color' => 'amber',
                            'title' => '3. Checkout & Pembayaran',
                            'text' => 'Masukkan barang ke keranjang, pilih tanggal sewa dan tanggal kembali dan Lakukan checkout.',
                            'list' => []
                        ],
                        [
                            'icon' => 'fa-store',
                            'color' => 'indigo',
                            'title' => '4. Pengambilan Barang',
                            'text' => 'Datang ke store For Rest Adventure sesuai tanggal sewa. Tunjukkan Invoice ID / Bukti Sewa kepada petugas kami.',
                            'list' => []
                        ],
                        [
                            'icon' => 'fa-campground',
                            'color' => 'rose',
                            'title' => '5. Selamat Berpetualang!',
                            'text' => 'Gunakan peralatan dengan bijak dan hati-hati. Nikmati momen camping Anda bersama alam.',
                            'list' => []
                        ],
                        [
                            'icon' => 'fa-rotate-left',
                            'color' => 'teal',
                            'title' => '6. Pengembalian Barang',
                            'text' => 'Kembalikan barang tepat waktu sesuai jadwal. Keterlambatan akan dikenakan denda harian.',
                            'list' => ['Barang tidak perlu dicuci (tim kami yang membersihkan).', 'Pastikan tidak ada bagian yang hilang.']
                        ]
                    ];
                @endphp

                <div class="relative space-y-12 pl-4 sm:pl-0">
                    {{-- Garis Vertikal --}}
                    <div class="absolute left-4 sm:left-8 top-0 bottom-0 w-0.5 bg-slate-200 -z-10 hidden sm:block"></div>

                    @foreach ($steps as $step)
                        <div class="relative flex flex-col sm:flex-row gap-6 group">
                            
                            {{-- Ikon Bulat --}}
                            <div class="flex-shrink-0 w-16 h-16 sm:w-16 sm:h-16 rounded-2xl bg-white border-2 border-{{ $step['color'] }}-100 shadow-sm flex items-center justify-center z-10 group-hover:scale-110 transition duration-300 relative">
                                <div class="absolute inset-0 bg-{{ $step['color'] }}-50 rounded-2xl transform rotate-6 transition group-hover:rotate-12 -z-10"></div>
                                <i class="fa-solid {{ $step['icon'] }} text-2xl text-{{ $step['color'] }}-500"></i>
                            </div>

                            {{-- Konten Text --}}
                            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition flex-1">
                                <h3 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-{{ $step['color'] }}-600 transition">{{ $step['title'] }}</h3>
                                <p class="text-slate-600 text-sm leading-relaxed mb-3">
                                    {{ $step['text'] }}
                                </p>
                                @if (count($step['list']) > 0)
                                    <ul class="space-y-1">
                                        @foreach ($step['list'] as $item)
                                            <li class="flex items-start gap-2 text-xs text-slate-500">
                                                <i class="fa-solid fa-check text-emerald-500 mt-0.5"></i>
                                                {{ $item }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            {{-- KOLOM KANAN: SIDEBAR --}}
            <div class="lg:col-span-1 space-y-8">
                
                {{-- Card Mulai Sewa --}}
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-8 text-white shadow-xl text-center relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-10 -mt-10 transition transform group-hover:scale-150"></div>
                    
                    <div class="relative z-10">
                        <div class="w-16 h-16 mx-auto bg-emerald-500 rounded-2xl flex items-center justify-center mb-4 shadow-lg shadow-emerald-500/30">
                            <i class="fa-solid fa-rocket text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Siap Menyewa?</h3>
                        <p class="text-slate-300 text-sm mb-6">Stok peralatan terbaik. Booking sekarang!</p>
                        <a href="{{ route('customer.catalog.index') }}" class="block w-full py-3 bg-white text-slate-900 font-bold rounded-xl hover:bg-emerald- 50 transition shadow-lg">
                            Lihat Katalog
                        </a>
                    </div>
                </div>

                {{-- Card Bantuan --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-headset text-emerald-500"></i> Bantuan Admin
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl">
                            <i class="fa-brands fa-whatsapp text-emerald-500 text-xl mt-1"></i>
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase">WhatsApp Admin</p>
                                <a href="https://wa.me/6283869634931" target="_blank" class="text-slate-800 font-bold hover:text-emerald-600 transition">+62 838-6963-4931</a>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl">
                            <i class="fa-solid fa-location-dot text-rose-500 text-xl mt-1"></i>
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase">Lokasi Store</p>
                                <p class="text-sm text-slate-700 font-medium">Jl. karimata Jember</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Artikel Lainnya --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                    <h3 class="font-bold text-slate-800 mb-4">Info Lainnya</h3>
                    <a href="{{ route('customer.artikel.pengembalian') }}" class="flex items-center gap-4 group">
                        <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-emerald-100 group-hover:text-emerald-600 transition">
                            <i class="fa-solid fa-rotate-left"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-700 text-sm group-hover:text-emerald-600 transition">Syarat Pengembalian</h4>
                            <p class="text-xs text-slate-400">Baca aturan denda & kerusakan</p>
                        </div>
                    </a>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection