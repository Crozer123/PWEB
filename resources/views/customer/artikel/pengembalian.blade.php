@extends('layouts.app')

@section('title', 'Cara Pengembalian Alat - Foresta Adventure')

@section('content')

<div class="min-h-screen bg-gray-50">

    {{-- HEADER BANNER (Identik dengan Cara Sewa) --}}
    <div class="relative h-[400px] bg-cover bg-center"
         style="background-image: url('https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?w=1920');">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 to-slate-900/40"></div>

        <div class="relative h-full max-w-7xl mx-auto px-6 lg:px-8 flex flex-col justify-center">

            <h1 class="text-white text-5xl font-bold mb-4">
                Cara Pengembalian Alat
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

    {{-- KONTEN UTAMA DAN SIDEBAR --}}
    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ARTIKEL (lg:col-span-2) --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-8">

                    <div class="mb-10">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">PENGEMBALIAN ALAT</h2>
                        <h3 class="text-xl font-bold text-gray-700 mb-4">
                            Prosedur Mudah Mengembalikan Peralatan Setelah Bertualang
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            Berikut panduan lengkap yang perlu Anda perhatikan saat mengembalikan barang sewaan ke store kami.
                            Mohon pastikan semua langkah dipenuhi agar proses berjalan lancar.
                        </p>
                    </div>

                    @php
                        $steps = [
                            [
                                'title' => 'Cek Kelengkapan Barang',
                                'text' => 'Pastikan semua item yang Anda sewa lengkap, termasuk aksesoris kecil (pasak, tali, kantong tenda). Kelengkapan dicek bersama admin saat di store.',
                                'list' => [
                                    'Semua barang harus dikemas dengan rapi.',
                                    'Cek kondisi fisik barang sebelum dibawa ke store.'
                                ]
                            ],
                            [
                                'title' => 'Kembalikan Tepat Waktu',
                                'text' => 'Barang wajib dikembalikan sesuai tanggal dan jam yang tertera pada nota pemesanan.',
                                'list' => [
                                    'Keterlambatan akan dikenakan denda sesuai dengan harga sewa per hari.',
                                    'Hubungi admin jika Anda membutuhkan perpanjangan waktu.'
                                ]
                            ],
                            [
                                'title' => 'Tidak Perlu Dicuci',
                                'text' => 'Anda tidak perlu membersihkan atau mencuci peralatan (termasuk tenda dan sleeping bag). Tim kami yang akan menanganinya.',
                                'list' => [
                                    'Hanya pastikan tidak ada sampah atau kotoran berlebih (lumpur tebal) pada barang.',
                                    'Angin-anginkan barang jika basah untuk menghindari jamur.'
                                ]
                            ],
                            [
                                'title' => 'Verifikasi dan Pelunasan Denda',
                                'text' => 'Admin akan melakukan verifikasi fisik barang. Jika ada kerusakan atau denda, pelunasan dilakukan saat itu juga.',
                                'list' => [
                                    'Identitas yang dititipkan akan dikembalikan setelah proses selesai.'
                                ]
                            ]
                        ];
                    @endphp

                    {{-- LOOPING LANGKAH-LANGKAH PENGEMBALIAN --}}
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

                    {{-- BOX BANTUAN DI AKHIR ARTIKEL --}}
                    <div class="bg-lime-50 border-l-4 border-lime-400 p-6 rounded-lg mt-12">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-lime-600 mt-1" fill="currentColor">
                                <path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/>
                            </svg>

                            <div>
                                <h5 class="font-bold text-gray-800 mb-2">Penting: Kerusakan dan Denda</h5>
                                <p class="text-gray-600 text-sm">
                                    Penyewa wajib bertanggung jawab penuh atas kerusakan atau kehilangan yang terjadi pada barang sewaan. Biaya penggantian atau perbaikan akan dihitung sesuai harga pasar.
                                </p>

                                <div class="mt-3 flex gap-3">
                                    <a href="https://wa.me/6287812000155" target="_blank"
                                       class="inline-flex items-center gap-2 bg-lime-400 hover:bg-lime-500 text-gray-900 font-semibold px-4 py-2 rounded-lg transition text-sm">
                                        Hubungi Admin Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection