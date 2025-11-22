@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12">

    <h1 class="text-2xl font-bold mb-6">Keranjang Penyewaan</h1>

    @if(count($cart) === 0)
        <div class="p-6 bg-white border border-slate-200 rounded-xl text-center">
            <p class="text-slate-500">Keranjang masih kosong.</p>
        </div>
        @return
    @endif

    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">

        <table class="w-full text-left">
            <thead>
                <tr class="text-sm text-slate-500 border-b">
                    <th class="py-2">Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @php $grandTotal = 0; @endphp

                @foreach($cart as $id => $item)
                    @php 
                        $total = $item['quantity'] * $item['price']; 
                        $grandTotal += $total;
                    @endphp

                    <tr class="border-b">
                        <td class="py-4 flex items-center gap-3">
                            <div class="w-14 h-14 bg-gray-50 border rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/'.$item['image']) }}" class="w-full h-full object-contain">
                            </div>
                            {{ $item['name'] }}
                        </td>

                        <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>

                        <td>
                            <form action="{{ route('customer.cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PUT')

                                <input type="number" name="quantity" min="1" max="{{ $item['stock'] }}"
                                       value="{{ $item['quantity'] }}"
                                       class="w-20 p-2 border rounded-lg">

                                <button class="text-emerald-600 font-bold text-sm">Update</button>
                            </form>
                        </td>

                        <td>
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </td>

                        <td>
                            <form action="{{ route('customer.cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 font-bold text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>

        <!-- Grand total -->
        <div class="text-right mt-6">
            <h3 class="text-xl font-bold">
                Total: Rp {{ number_format($grandTotal, 0, ',', '.') }}
            </h3>
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('customer.checkout') }}"
               class="bg-emerald-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-emerald-700">
                Lanjutkan Checkout
            </a>
        </div>

    </div>
</div>
@endsection
