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
                   class="block bg-white border rounded-xl p-5 shadow-sm hover:shadow-md transition">

                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold text-emerald-700">
                                Pesanan #{{ $rental->id }}
                            </h3>
                            <p class="text-gray-500 text-sm">
                                Tanggal Sewa: {{ $rental->rental_date }}
                            </p>
                            <p class="text-gray-500 text-sm">
                                Kembali: {{ $rental->return_date }}
                            </p>
                        </div>

                        <div class="text-right">
                            <span class="px-3 py-1 text-sm rounded-full 
                                {{ $rental->status == 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($rental->status) }}
                            </span>

                            <p class="font-bold text-lg mt-2">
                                Rp {{ number_format($rental->total_price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $rentals->links() }}
        </div>
    @endif

</div>

@endsection
