@extends('layouts.app')

@section('title', 'Detail Penyewaan - Foresta Adventure')

@section('content')

<div class="min-h-screen bg-slate-50 py-12 font-poppins relative overflow-hidden">
    
    {{-- Background Decoration --}}
    <div class="absolute top-0 left-0 w-full h-64 bg-gradient-to-b from-emerald-600/10 to-transparent -z-10"></div>

    <div class="container mx-auto px-4 max-w-4xl relative z-10">

        {{-- Header Navigation --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 mb-1">Detail Penyewaan</h1>
                <p class="text-slate-500 text-sm font-mono">
                    ID Transaksi: <span class="font-bold text-slate-700">#{{ $rental->id }}</span>
                </p>
            </div>

            <a href="{{ route('customer.rentals.history') }}"
               class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-600 hover:text-emerald-600 hover:border-emerald-200 hover:shadow-sm transition text-sm font-semibold flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                <span class="hidden sm:inline">Kembali</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left Column: Main Details --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Status Banner --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden">
                    @php
                        $statusConfig = match($rental->status) {
                            'pending' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'icon' => 'fa-hourglass-half', 'label' => 'Menunggu Konfirmasi'],
                            'approved' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'icon' => 'fa-check-circle', 'label' => 'Disetujui'],
                            'rented' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'icon' => 'fa-person-hiking', 'label' => 'Sedang Disewa'],
                            'returned' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'icon' => 'fa-box-archive', 'label' => 'Selesai'],
                            'cancelled' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'icon' => 'fa-circle-xmark', 'label' => 'Dibatalkan'],
                            default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'icon' => 'fa-info-circle', 'label' => ucfirst($rental->status)],
                        };
                    @endphp
                    
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Status Pesanan</p>
                            <h2 class="text-2xl font-bold {{ $statusConfig['text'] }} flex items-center gap-3">
                                <i class="fa-solid {{ $statusConfig['icon'] }}"></i>
                                {{ $statusConfig['label'] }}
                            </h2>
                            <p class="text-sm text-slate-500 mt-2">
                                @if($rental->status == 'pending')
                                    Mohon tunggu, admin sedang mengecek ketersediaan barang.
                                @elseif($rental->status == 'rented')
                                    Selamat berpetualang! Jangan lupa kembalikan tepat waktu.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Item List --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-box-open text-emerald-500"></i> Barang yang Disewa
                        </h3>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @foreach ($rental->details as $detail)
                        <div class="p-4 flex items-center gap-4 hover:bg-slate-50 transition">
                            {{-- Product Image --}}
                            <div class="w-16 h-16 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0 relative">
                                @if($detail->item->image)
                                    <img src="{{ \Illuminate\Support\Str::startsWith($detail->item->image, 'http') ? $detail->item->image : asset('storage/' . $detail->item->image) }}" 
                                         class="w-full h-full object-cover" 
                                         alt="{{ $detail->item->name }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300 absolute inset-0">
                                        <i class="fa-solid fa-image text-xl"></i>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1">
                                <h4 class="font-bold text-slate-800">{{ $detail->item->name }}</h4>
                                <p class="text-xs text-slate-500">
                                    Rp {{ number_format($detail->item->rental_price, 0, ',', '.') }} / hari
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-xs text-slate-400 font-bold uppercase mb-1">Subtotal</p>
                                <p class="font-bold text-emerald-600">
                                    Rp {{ number_format($detail->subtotal_price, 0, ',', '.') }}
                                </p>
                                <span class="inline-block bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-full font-bold mt-1">
                                    x{{ $detail->quantity }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Right Column: Summary & Actions --}}
            <div class="lg:col-span-1 space-y-6">
                
                {{-- Rental Info Card --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-50 pb-2">Rincian Waktu</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase">Tanggal Sewa</p>
                            <p class="font-medium text-slate-700">
                                <i class="fa-regular fa-calendar text-emerald-500 mr-2"></i>
                                {{ \Carbon\Carbon::parse($rental->rental_date)->format('d M Y') }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase">Tanggal Kembali</p>
                            <p class="font-medium text-slate-700">
                                <i class="fa-regular fa-calendar-check text-emerald-500 mr-2"></i>
                                {{ \Carbon\Carbon::parse($rental->return_date)->format('d M Y') }}
                            </p>
                        </div>

                        @if($rental->returned_at)
                        <div class="bg-emerald-50 p-3 rounded-xl border border-emerald-100">
                            <p class="text-xs text-emerald-600 font-bold uppercase">Dikembalikan Pada</p>
                            <p class="font-bold text-emerald-800 text-sm mt-1">
                                {{ \Carbon\Carbon::parse($rental->returned_at)->format('d M Y - H:i') }}
                            </p>
                        </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium">Total Bayar</span>
                            <span class="text-xl font-black text-slate-800">
                                Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Help Button --}}
                <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20ingin%20tanya%20tentang%20pesanan%20ID%20{{ $rental->id }}" 
                   target="_blank"
                   class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white text-center font-bold py-3 rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                    <i class="fa-brands fa-whatsapp mr-2"></i> Hubungi Admin
                </a>

            </div>

        </div>

    </div>
</div>

@endsection