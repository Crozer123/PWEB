@extends('layouts.app')

@section('title', 'Cara Pengembalian - Foresta Adventure')

@section('content')

<div class="min-h-screen bg-slate-50 font-poppins">

    {{-- 1. HERO BANNER --}}
    <div class="relative h-[400px] bg-cover bg-center bg-fixed"
         style="background-image: url('https://images.unsplash.com/photo-1533575770077-052fa2c609fc?w=1920');">
        <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-[2px]"></div>

        <div class="relative h-full max-w-7xl mx-auto px-6 lg:px-8 flex flex-col justify-center text-center items-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-emerald-300 text-sm font-medium mb-4 backdrop-blur-md">
                <i class="fa-solid fa-rotate-left"></i> Prosedur Pengembalian
            </div>
            <h1 class="text-white text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
                Selesai Bertualang?
            </h1>
            <p class="text-slate-300 text-lg max-w-2xl">
                Panduan mudah mengembalikan peralatan sewaan di <span class="text-emerald-400 font-bold">For Rest Adventure</span>. Pastikan semua lengkap agar bebas denda.
            </p>
        </div>
    </div>

    {{-- 2. MAIN CONTENT --}}
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- KOLOM KIRI: TIMELINE PENGEMBALIAN --}}
            <div class="lg:col-span-2">
                
                <div class="mb-10 border-b border-slate-200 pb-6">
                    <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-3">
                        <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </span>
                        Alur Pengembalian Barang
                    </h2>
                </div>

                @php
                    $steps = [
                        [
                            'icon' => 'fa-box-open',
                            'color' => 'blue',
                            'title' => '1. Cek Kelengkapan Barang',
                            'text' => 'Sebelum meninggalkan lokasi camping, pastikan tidak ada barang yang tertinggal. Cek pasak tenda, tali, frame, dan aksesoris kecil lainnya.',
                            'list' => ['Barang harus sesuai dengan daftar sewa.', 'Packing kembali dengan rapi.']
                        ],
                        [
                            'icon' => 'fa-clock',
                            'color' => 'amber',
                            'title' => '2. Perhatikan Waktu Pengembalian',
                            'text' => 'Kembalikan barang sesuai tanggal dan jam yang tertera di nota. Keterlambatan pengembalian akan dikenakan denda harian (overtime).',
                            'list' => ['Toleransi keterlambatan maksimal 1 jam.']
                        ],
                        [
                            'icon' => 'fa-hands-bubbles',
                            'color' => 'teal',
                            'title' => '3. Kondisi Kebersihan',
                            'text' => 'Anda TIDAK PERLU mencuci peralatan (tenda, sleeping bag, dll). Tim kami yang akan mencucinya secara profesional.',
                            'list' => ['Cukup bersihkan dari sampah kasar/sisa makanan.', 'Pastikan barang kering (tidak basah kuyup).']
                        ],
                        [
                            'icon' => 'fa-store',
                            'color' => 'indigo',
                            'title' => '4. Serahkan ke Petugas Store',
                            'text' => 'Datang ke store dan serahkan barang beserta nota sewa (digital/fisik) kepada petugas kami untuk dilakukan pengecekan.',
                            'list' => []
                        ],
                        [
                            'icon' => 'fa-magnifying-glass-chart',
                            'color' => 'rose',
                            'title' => '5. Pengecekan Fisik (Quality Control)',
                            'text' => 'Petugas akan mengecek kondisi fisik barang di depan Anda. Kerusakan (sobek, patah, hilang) akan dikenakan biaya penggantian sesuai harga barang.',
                            'list' => ['Pengecekan memakan waktu 5-10 menit.']
                        ],
                        [
                            'icon' => 'fa-handshake',
                            'color' => 'emerald',
                            'title' => '6. Selesai & Pengambilan Identitas',
                            'text' => 'Setelah dinyatakan aman (atau denda lunas), kartu identitas (KTP) yang dititipkan akan kami kembalikan',
                            'list' => []
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
                
                {{-- Card Peraturan Denda --}}
                <div class="bg-rose-50 border border-rose-100 rounded-3xl p-6 shadow-sm">
                    <h3 class="font-bold text-rose-700 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation"></i> Peraturan Denda
                    </h3>
                    <ul class="space-y-3 text-sm text-rose-800">
                        <li class="flex gap-2">
                            <span class="font-bold">•</span>
                            <span>Terlambat: Denda 100% harga sewa per hari.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="font-bold">•</span>
                            <span>Hilang/Rusak Parah: Mengganti seharga barang baru.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="font-bold">•</span>
                            <span>Rusak Ringan: Biaya service ditanggung penyewa.</span>
                        </li>
                    </ul>
                </div>

                {{-- Card Bantuan --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                    <h3 class="font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-headset text-emerald-500"></i> Kontak Admin
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl">
                            <i class="fa-brands fa-whatsapp text-emerald-500 text-xl mt-1"></i>
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase">Konfirmasi Telat</p>
                                <a href="https://wa.me/6283869634931" target="_blank" class="text-slate-800 font-bold hover:text-emerald-600 transition">+62 838-6963-4931</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Artikel Lainnya --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                    <h3 class="font-bold text-slate-800 mb-4">Info Lainnya</h3>
                    <a href="{{ route('customer.artikel.carasewa') }}" class="flex items-center gap-4 group">
                        <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-emerald-100 group-hover:text-emerald-600 transition">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-700 text-sm group-hover:text-emerald-600 transition">Cara Sewa Alat</h4>
                            <p class="text-xs text-slate-400">Panduan pemula menyewa alat</p>
                        </div>
                    </a>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection