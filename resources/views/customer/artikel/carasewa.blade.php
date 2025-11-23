@extends('layouts.app')

@section('title', 'Cara Sewa - For Rest Adventure')

@section('content')

<div class="min-h-screen bg-gray-50">

    <div class="relative h-[400px] bg-cover bg-center"
         style="background-image: url('https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=1920');">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-slate-900/40"></div>

        <div class="relative h-full max-w-7xl mx-auto px-6 lg:px-8 flex flex-col justify-center">
            <h1 class="text-white text-5xl font-bold mb-4">
                Cara Pemesanan di For Rest Adventure
            </h1>

            <div class="flex items-center gap-6 text-white text-sm">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/></svg>
                    For Rest Adventure
                </span>

                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor"><path d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z"/></svg>
                    {{ now()->translatedFormat('d M Y') }}
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-8">

                    <div class="mb-10">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">CARA SEWA</h2>
                        <h3 class="text-xl font-bold text-gray-700 mb-4">
                            Panduan Penyewaan Peralatan di For Rest Adventure
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            For Rest Adventure menyediakan berbagai perlengkapan outdoor berkualitas tinggi.
                            Berikut panduan lengkap untuk melakukan penyewaan secara mudah dan cepat.
                        </p>
                    </div>

                    @php
                        $steps = [
                            [
                                'title' => 'Akses Menu Katalog',
                                'text' => 'Buka halaman katalog untuk melihat barang yang tersedia. Stok selalu real-time.',
                                'list' => []
                            ],
                            [
                                'title' => 'Pastikan Profil Kamu Sudah Lengkap',
                                'text' => 'Pastikan nama, email, dan nomor telepon sudah benar untuk memperlancar verifikasi.',
                                'list' => [
                                    'Perbarui data profil jika ada perubahan.',
                                    'Informasi profil digunakan untuk transaksi dan disimpan aman.'
                                ]
                            ],
                            [
                                'title' => 'Pilih Barang dan Lakukan Transaksi',
                                'text' => 'Setelah memilih barang, lakukan pemesanan melalui website.',
                                'list' => [
                                    'Upload bukti pembayaran pada halaman transaksi.',
                                    'Konfirmasi pembayaran via WhatsApp agar cepat diproses.'
                                ]
                            ],
                            [
                                'title' => 'Pengambilan Barang di Store',
                                'text' => 'Ambil barang sesuai jadwal pengambilan yang disepakati.',
                                'list' => []
                            ],
                            [
                                'title' => 'Gunakan Peralatan dengan Baik',
                                'text' => 'Gunakan peralatan dengan benar dan jaga kebersihannya.',
                                'list' => []
                            ],
                            [
                                'title' => 'Pengembalian Barang',
                                'text' => 'Kembalikan barang sesuai tanggal yang telah ditentukan.',
                                'list' => [
                                    'Tidak perlu mencuci — tim kami yang akan membersihkan.'
                                ]
                            ]
                        ];
                    @endphp

                    @foreach ($steps as $i => $step)
                        <div class="mb-8">
                            <div class="flex items-start gap-4 mb-4">
                                <div class="w-10 h-10 bg-teal-600 text-white rounded-full flex items-center justify-center font-bold">
                                    {{ $i + 1 }}
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-800 mb-2">{{ $step['title'] }}</h4>
                                    <p class="text-gray-600 leading-relaxed mb-3">{{ $step['text'] }}</p>

                                    @if (count($step['list']) > 0)
                                        <ul class="space-y-2 ml-4">
                                            @foreach ($step['list'] as $item)
                                                <li class="flex items-start gap-2 text-gray-600">
                                                    <svg class="w-5 h-5 text-teal-600 mt-0.5" fill="currentColor">
                                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.7-9.3a1 1 0 00-1.4-1.4L9 10.6 7.7 9.3a1 1 0 00-1.4 1.4l2 2a1 1 0 001.4 0l4-4z"/>
                                                    </svg>
                                                    {{ $item }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="bg-lime-50 border-l-4 border-lime-400 p-6 rounded-lg mt-12">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-lime-600 mt-1" fill="currentColor">
                                <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
                            </svg>

                            <div>
                                <h5 class="font-bold text-gray-800 mb-2">Butuh bantuan?</h5>
                                <p class="text-gray-600 text-sm">
                                    Hubungi kami lewat WhatsApp untuk pertanyaan lebih lanjut.
                                </p>

                                <div class="mt-3 flex gap-3">
                                    <a href="https://wa.me/6287812000155" target="_blank"
                                       class="inline-flex items-center gap-2 bg-lime-400 hover:bg-lime-500 text-gray-900 font-semibold px-4 py-2 rounded-lg transition text-sm">
                                        WhatsApp
                                    </a>

                                    <a href="{{ route('customer.catalog.index') }}"
                                       class="inline-flex items-center bg-white hover:bg-gray-50 text-gray-700 font-semibold px-4 py-2 rounded-lg border border-gray-300 text-sm transition">
                                        Mulai Sewa Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Artikel Terkait</h3>

                    <div class="space-y-6">
                        {{-- LINK SUDAH DIPERBAIKI --}}
                        <a href="{{ route('customer.artikel.pengembalian') }}" class="block group">
                            <h4 class="font-bold text-gray-800 group-hover:text-teal-600 transition mb-1">
                                Cara Pengembalian Alat
                            </h4>
                            <p class="text-sm text-gray-500">
                                Panduan lengkap mengembalikan peralatan dengan benar.
                            </p>
                            <p class="text-xs text-gray-400 mt-1">12 November 2025</p>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection