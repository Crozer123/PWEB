@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- HEADER UTAMA --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-slate-800">Detail Rental <span class="text-emerald-600">#{{ $rental->id }}</span></h2>
        </div>

        <a href="{{ route('admin.rentals.index') }}"
            class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-medium rounded-xl transition-colors duration-150 hover:bg-slate-50 hover:text-emerald-600 shadow-sm flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- KOLOM KIRI: INFORMASI PENYEWA --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 p-6 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-user-circle text-emerald-500"></i> Penyewa
                    </h3>
                </div>
                
                <div class="p-6 flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-br from-emerald-100 to-teal-200 mb-4">
                        <div class="w-full h-full rounded-full bg-white overflow-hidden flex items-center justify-center border-4 border-white shadow-sm">
                            @php
                                $photo = $rental->user->avatar ?? $rental->user->photo ?? $rental->user->profile_photo_path ?? null;
                            @endphp

                            @if(!empty($photo))
                                <img src="{{ asset('storage/' . $photo) }}" 
                                     alt="{{ $rental->user->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-slate-100 text-slate-400 flex items-center justify-center text-3xl font-bold">
                                    {{ substr($rental->user->name ?? 'U', 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <h4 class="text-xl font-bold text-slate-800">{{ $rental->user->name }}</h4>
                    <p class="text-sm text-slate-500 font-medium">{{ $rental->user->email }}</p>
                    <div class="mt-4">
                        <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider bg-blue-50 text-blue-600 rounded-full border border-blue-100">
                            Customer
                        </span>
                    </div>
                </div>
                
                <div class="bg-slate-50 p-4 border-t border-slate-100">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500">Bergabung Sejak:</span>
                        <span class="font-semibold text-slate-700">{{ $rental->user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: DETAIL TRANSAKSI --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- KARTU DETAIL SEWA --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-white p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-receipt text-blue-500"></i> Rincian Sewa
                    </h3>
                    
                    {{-- Status Badge --}}
                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                            'active' => 'bg-blue-50 text-blue-700 border-blue-100',
                            'rented' => 'bg-blue-50 text-blue-700 border-blue-100',
                            'returned' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                            'cancelled' => 'bg-rose-50 text-rose-700 border-rose-100',
                            'canceled' => 'bg-rose-50 text-rose-700 border-rose-100',
                        ];
                        $statusClass = $statusColors[$rental->status] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                        $statusLabel = match($rental->status) {
                            'rented' => 'Sedang Dipinjam',
                            'active' => 'Sedang Dipinjam',
                            'returned' => 'Selesai',
                            'pending' => 'Menunggu Konfirmasi',
                            'canceled' => 'Dibatalkan',
                            'cancelled' => 'Dibatalkan',
                            default => ucfirst($rental->status)
                        };
                    @endphp
                    <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide border {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Sewa</p>
                        <p class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="far fa-calendar-alt text-slate-400"></i>
                            {{ \Carbon\Carbon::parse($rental->rental_date)->translatedFormat('d M Y') }}
                        </p>
                    </div>

                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal Kembali</p>
                        <p class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="far fa-calendar-check text-slate-400"></i>
                            {{ \Carbon\Carbon::parse($rental->return_date)->translatedFormat('d M Y') }}
                        </p>
                    </div>

                    @if ($rental->returned_at)
                    <div class="sm:col-span-2 p-4 rounded-xl bg-emerald-50 border border-emerald-100 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">Dikembalikan Pada</p>
                            <p class="text-lg font-bold text-emerald-800">
                                {{ \Carbon\Carbon::parse($rental->returned_at)->translatedFormat('d M Y, H:i') }} WIB
                            </p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- TABEL ITEM --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-white p-6 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-box-open text-purple-500"></i> Item yang Disewa
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50 border-b border-slate-100">
                            <tr>
                                <th class="py-4 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Jumlah</th>
                                <th class="px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Harga</th>
                                <th class="px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach ($rental->details as $d)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-4 px-6 font-semibold text-slate-700">{{ $d->item->name }}</td>
                                <td class="px-6 text-slate-600 text-center font-medium">
                                    <span class="bg-slate-100 px-2 py-1 rounded text-xs font-bold">{{ $d->quantity }}</span>
                                </td>
                                <td class="px-6 text-slate-600 text-right text-sm">Rp {{ number_format($d->item->rental_price, 0, ',', '.') }}</td>
                                <td class="px-6 font-bold text-slate-800 text-right">Rp {{ number_format($d->subtotal_price, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50 border-t border-slate-100">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right font-bold text-slate-600 uppercase text-xs tracking-wider">Total Pembayaran</td>
                                <td class="px-6 py-4 text-right font-black text-xl text-emerald-600">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- FORM UPDATE STATUS --}}
            @if ($rental->status !== 'returned' && $rental->status !== 'cancelled' && $rental->status !== 'canceled')
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Update Status</h3>

                    <form method="POST" action="{{ route('admin.rentals.update', $rental->id) }}" class="flex flex-col sm:flex-row items-center gap-4">
                        @csrf
                        @method('PUT')
                        
                        <div class="relative w-full flex-1">
                            <select name="status" class="w-full p-3 pl-4 pr-10 border border-slate-200 rounded-xl focus:border-emerald-500 focus:ring-emerald-500 bg-slate-50 font-medium text-slate-700 appearance-none cursor-pointer transition hover:border-emerald-300">
                                <option value="rented" {{ ($rental->status=='rented' || $rental->status=='active') ? 'selected' : '' }}>Active (Sedang Dipinjam)</option>
                                <option value="returned" {{ $rental->status=='returned' ? 'selected' : '' }}>Returned (Sudah Dikembalikan)</option>
                                <option value="canceled" {{ ($rental->status=='canceled' || $rental->status=='cancelled') ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                                <option value="pending" {{ $rental->status=='pending' ? 'selected' : '' }}>Pending (Menunggu Persetujuan)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>

                        <button class="w-full sm:w-auto px-8 py-3 bg-emerald-600 text-white rounded-xl transition hover:bg-emerald-700 font-bold shadow-md hover:shadow-lg flex items-center justify-center gap-2 transform active:scale-95 duration-150">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection