@extends('layouts.app')

@section('content')

<div class="container mx-auto px-6 py-8 font-poppins">

    <h1 class="text-2xl font-bold text-emerald-800 mb-6">Riwayat Pesanan</h1>

    @if($rentals->count() == 0)
        <div class="bg-white p-10 rounded-xl shadow text-center border border-gray-100">
            <i class="fa-solid fa-box-open text-gray-300 text-5xl mb-4"></i>
            <h2 class="font-bold text-gray-700">Belum Ada Pesanan</h2>
            <p class="text-gray-500 text-sm">Mulai sewa perlengkapan outdoor sekarang.</p>

            <a href="{{ route('customer.catalog.index') }}"
               class="mt-4 inline-block px-6 py-2 bg-emerald-600 text-white rounded-lg text-sm">
                Lihat Katalog
            </a>
        </div>
    @else

        <div class="space-y-4">
            @foreach($rentals as $rental)
                <a href="{{ route('customer.rentals.show', $rental->id) }}"
                   class="block bg-white border border-gray-100 rounded-xl p-4 shadow-sm hover:shadow-md transition duration-200 group">

                    <div class="flex items-center gap-4">
                        
                        {{-- THUMBNAIL IMAGE (Ambil item pertama dari pesanan) --}}
                        <div class="w-20 h-20 bg-gray-50 rounded-lg overflow-hidden flex-shrink-0 border border-gray-200 relative">
                            @php $firstItem = $rental->items->first(); @endphp
                            
                            @if($firstItem && $firstItem->image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($firstItem->image, 'http') ? $firstItem->image : asset('storage/' . $firstItem->image) }}" 
                                     alt="{{ $firstItem->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <i class="fa-solid fa-image text-2xl"></i>
                                </div>
                            @endif

                            {{-- Jika item lebih dari 1, kasih badge +X --}}
                            @if($rental->items->count() > 1)
                                <div class="absolute bottom-0 right-0 bg-slate-800/70 text-white text-[10px] px-1.5 py-0.5 rounded-tl-md">
                                    +{{ $rental->items->count() - 1 }}
                                </div>
                            @endif
                        </div>

                        {{-- INFO PESANAN --}}
                        <div class="flex-1 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            
                            <div>
                                <h3 class="font-bold text-emerald-900 group-hover:text-emerald-600 transition">
                                    Pesanan #{{ $rental->id }}
                                </h3>
                                <p class="text-gray-500 text-xs sm:text-sm mt-1">
                                    <i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($rental->rental_date)->format('d M') }} 
                                    - 
                                    {{ \Carbon\Carbon::parse($rental->return_date)->format('d M Y') }}
                                </p>
                                <p class="text-slate-400 text-xs mt-0.5">
                                    {{ $rental->items->count() }} Barang
                                </p>
                            </div>

                            <div class="text-left sm:text-right">
                                <span class="inline-block px-3 py-1 text-xs font-bold rounded-full mb-2
                                    @class([
                                        'bg-blue-100 text-blue-700' => $rental->status == 'pending',
                                        'bg-amber-100 text-amber-700' => $rental->status == 'waiting',
                                        'bg-green-100 text-green-700' => $rental->status == 'approved' || $rental->status == 'completed',
                                        'bg-red-100 text-red-700' => $rental->status == 'rejected',
                                    ])">
                                    {{ ucfirst($rental->status) }}
                                </span>

                                <p class="font-bold text-lg text-slate-800">
                                    Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                                </p>
                            </div>

                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $rentals->links() }}
        </div>
    @endif

</div>

@endsection