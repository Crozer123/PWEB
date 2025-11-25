@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-slate-800 mb-8">Keranjang Penyewaan</h1>

    @if($cartItems->isEmpty())
        <div class="p-12 bg-white border border-slate-200 rounded-3xl text-center">
            <div class="text-slate-200 mb-4">
                <i class="fa-solid fa-cart-arrow-down text-6xl"></i>
            </div>
            <p class="text-slate-500 text-lg mb-6">Keranjang Anda masih kosong.</p>
            <a href="{{ route('customer.catalog.index') }}" class="px-6 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-4">
                @php $grandTotal = 0; @endphp
                @foreach($cartItems as $cartItem)
                    @php 
                        $total = $cartItem->quantity * $cartItem->item->rental_price; 
                        $grandTotal += $total;
                    @endphp

                    <div class="flex gap-4 p-4 bg-white border border-slate-100 rounded-2xl shadow-sm items-center">
                        <div class="w-20 h-20 bg-gray-50 rounded-xl overflow-hidden flex-shrink-0">
                            @if($cartItem->item->image)
                                <img src="{{ asset('storage/' . $cartItem->item->image) }}" class="w-full h-full object-contain">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <h3 class="font-bold text-slate-800">{{ $cartItem->item->name }}</h3>
                            <p class="text-emerald-600 font-semibold text-sm">
                                Rp {{ number_format($cartItem->item->rental_price, 0, ',', '.') }} / hari
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-sm text-slate-500 mb-2">Jumlah: <span class="font-bold text-slate-800">{{ $cartItem->quantity }}</span></p>
                            
                            <form action="{{ route('customer.cart.remove', $cartItem->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                                    <i class="fa-solid fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white border border-emerald-100 rounded-3xl p-6 shadow-sm sticky top-24">
                    <h3 class="font-bold text-xl mb-4 text-slate-800">Ringkasan Sewa</h3>

                    <div class="flex justify-between items-center mb-6 pb-6 border-b border-slate-100">
                        <span class="text-slate-500">Total Harga (per hari)</span>
                        <span class="font-bold text-emerald-600 text-xl">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('customer.cart.checkout') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-4 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Tanggal Mulai Sewa</label>
                                <input type="date" name="rental_date" class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1">Tanggal Pengembalian</label>
                                <input type="date" name="return_date" class="w-full rounded-xl border-slate-200 focus:border-emerald-500 focus:ring-emerald-500" required>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-emerald-500/30 transition transform hover:-translate-y-1">
                            Sewa Sekarang
                        </button>
                    </form>
                </div>
            </div>

        </div>
    @endif
</div>
@endsection