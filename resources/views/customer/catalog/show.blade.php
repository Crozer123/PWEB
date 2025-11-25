@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 font-poppins text-slate-800">
    
    <!-- Navigasi kecil di atas halaman -->
    <nav class="flex items-center text-sm text-slate-500 mb-8 overflow-x-auto whitespace-nowrap">
        <a href="{{ route('customer.dashboard') }}" class="hover:text-emerald-600 transition">Dashboard</a>
        <span class="mx-3 text-slate-300">/</span>
        <a href="{{ route('customer.catalog.index') }}" class="hover:text-emerald-600 transition">Katalog</a>
        <span class="mx-3 text-slate-300">/</span>
        <span class="text-emerald-600 font-semibold truncate">{{ $item->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
        

        <!-- GAMBAR PRODUK -->
        <div class="space-y-6">
            <div class="relative aspect-square bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 group">

                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" 
                         alt="{{ $item->name }}" 
                         class="w-full h-full object-contain p-8 transition duration-500 group-hover:scale-105">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-200">
                        <i class="fa-solid fa-image text-6xl"></i>
                    </div>
                @endif

                <!-- Badge stok kiri atas -->
                <div class="absolute top-4 left-4">
                    @if($item->stock > 5)
                        <span class="bg-emerald-100 text-emerald-700 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-2 shadow-sm">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Tersedia
                        </span>
                    @elseif($item->stock > 0)
                        <span class="bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-2 shadow-sm">
                            <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span> Stok Menipis
                        </span>
                    @else
                        <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-2 shadow-sm">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span> Habis
                        </span>
                    @endif
                </div>
            </div>
        </div>


        <!-- DETAIL PRODUK -->
        <div>

            <!-- Badge kategori -->
            <div class="mb-4">
                <a href="{{ route('customer.catalog.index', ['category' => $item->category_id]) }}" 
                   class="inline-block bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold px-3 py-1 rounded-md transition uppercase tracking-wide">
                    {{ $item->category->name ?? 'Umum' }}
                </a>
            </div>

            <!-- Nama produk -->
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight mb-4">
                {{ $item->name }}
            </h1>

            <!-- Rating dummy -->
            <div class="flex items-center gap-4 mb-6">
                <div class="flex text-yellow-400 text-sm">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                </div>
                <span class="text-slate-400 text-sm border-l border-slate-200 pl-4">ID: #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>

            <!-- Harga -->
            <div class="bg-emerald-50/50 rounded-2xl p-6 border border-emerald-100 mb-8 flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-sm mb-1 font-medium">Harga Sewa</p>
                    <div class="flex items-baseline gap-1">
                        <span class="text-3xl font-bold text-emerald-700">Rp {{ number_format($item->rental_price, 0, ',', '.') }}</span>
                        <span class="text-emerald-600 font-medium text-sm">/ 24 jam</span>
                    </div>
                </div>

                <!-- Info stok -->
                <div class="text-right hidden sm:block">
                    <p class="text-slate-500 text-xs mb-1">Sisa Stok</p>
                    <p class="text-xl font-bold text-slate-800">{{ $item->stock }} <span class="text-sm font-normal text-slate-500">Unit</span></p>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-8">
                <h3 class="font-bold text-lg text-slate-800 mb-3">Deskripsi Produk</h3>

                <p class="text-slate-600 leading-relaxed text-sm">
                    {{ $item->description ?? 'Belum ada deskripsi detail untuk produk ini.' }}
                </p>

                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-3 text-sm text-slate-600">
                        <i class="fa-solid fa-check-circle text-emerald-500"></i> Kondisi bersih & terawat
                    </li>
                    <li class="flex items-center gap-3 text-sm text-slate-600">
                        <i class="fa-solid fa-check-circle text-emerald-500"></i> Siap pakai langsung
                    </li>
                </ul>
            </div>

            <!-- Tombol aksi -->
            <div class="flex flex-col sm:flex-row gap-4 border-t border-slate-100 pt-8">

                @if($item->stock > 0)
                    <form action="{{ route('customer.cart.add', $item->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" 
                            class="w-full bg-white border-2 border-emerald-600 text-emerald-600 font-bold py-4 rounded-xl hover:bg-emerald-50 transition flex items-center justify-center gap-3">
                            <i class="fa-solid fa-cart-shopping"></i>
                            Masukkan Keranjang
                        </button>
                    </form>
                
                    <a href="{{ route('customer.order.single', $item->id) }}"
                        class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-emerald-500/30 transition transform hover:-translate-y-1 flex items-center justify-center gap-3">
                        <i class="fa-solid fa-bag-shopping"></i>
                        Sewa Sekarang
                    </a>
                @else
                    <button disabled class="flex-1 bg-slate-200 text-slate-400 font-bold py-4 rounded-xl cursor-not-allowed flex items-center justify-center gap-3">
                        <i class="fa-solid fa-ban"></i>
                        Stok Habis
                    </button>
                @endif
                
            </div>

            <p class="text-xs text-slate-400 mt-6">
                <i class="fa-solid fa-shield-halved mr-1"></i> Jaminan barang original & berkualitas.
            </p>

        </div>
    </div>


    <!-- Rekomendasi produk -->
    @if(isset($relatedItems) && $relatedItems->count() > 0)
    <div class="mt-20 border-t border-slate-100 pt-12">
        <h2 class="text-2xl font-bold text-slate-800 mb-8">Mungkin Anda Juga Suka</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedItems as $related)
                <a href="{{ route('catalog.show', $related->id) }}" class="group block">
                    <div class="bg-white rounded-xl border border-gray-100 p-4 hover:shadow-lg transition-all duration-300">
                        <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden mb-4 flex items-center justify-center">

                            @if($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}" class="w-full h-full object-contain p-2 group-hover:scale-105 transition">
                            @else
                                <i class="fa-solid fa-image text-gray-300 text-2xl"></i>
                            @endif

                        </div>

                        <h4 class="font-bold text-slate-800 line-clamp-1 group-hover:text-emerald-600 transition">
                            {{ $related->name }}
                        </h4>

                        <p class="text-emerald-600 font-bold text-sm mt-1">
                            Rp {{ number_format($related->rental_price, 0, ',', '.') }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
