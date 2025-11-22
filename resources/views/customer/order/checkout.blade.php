@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12 text-slate-800">

    <h1 class="text-2xl font-bold mb-6">Checkout Penyewaan</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- FORM TANGGAL -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl p-6">
            <h2 class="text-xl font-bold mb-4">Detail Penyewaan</h2>

            <form action="{{ route('customer.order.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="font-semibold text-sm">Tanggal Sewa</label>
                    <input type="date" name="rental_date" required
                           class="w-full mt-1 border p-3 rounded-lg">
                </div>

                <div class="mb-4">
                    <label class="font-semibold text-sm">Tanggal Pengembalian</label>
                    <input type="date" name="return_date" required
                           class="w-full mt-1 border p-3 rounded-lg">
                </div>

                <h3 class="font-semibold text-lg mt-6 mb-3">Barang dalam Penyewaan</h3>

                @foreach($cart as $id => $item)
                    <input type="hidden" name="items[{{ $loop->index }}][item_id]" value="{{ $id }}">
                    <input type="hidden" name="items[{{ $loop->index }}][quantity]" value="{{ $item['quantity'] }}">

                    <div class="flex items-center gap-4 border-b py-4">
                        <div class="w-16 h-16 bg-gray-50 overflow-hidden rounded-lg">
                            <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-contain">
                        </div>

                        <div class="flex-1">
                            <p class="font-bold">{{ $item['name'] }}</p>
                            <p class="text-sm text-slate-500">
                                {{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}
                            </p>
                        </div>

                        <p class="font-bold text-emerald-600">
                            Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach

                <button class="mt-8 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-lg">
                    Konfirmasi Penyewaan
                </button>

            </form>
        </div>

        <!-- RINGKASAN -->
        <div class="bg-white border border-slate-200 rounded-xl p-6 h-fit shadow-sm">

            <h2 class="text-xl font-bold mb-4">Ringkasan Pembayaran</h2>

            @php $total = 0; @endphp

            @foreach($cart as $c)
                @php $total += $c['price'] * $c['quantity']; @endphp
            @endforeach

            <div class="flex justify-between text-lg font-bold">
                <span>Total</span>
                <span class="text-emerald-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <p class="text-xs mt-3 text-slate-400">
                Harga dihitung per 24 jam dan akan disesuaikan berdasarkan durasi sewa.
            </p>

        </div>

    </div>

</div>
@endsection
