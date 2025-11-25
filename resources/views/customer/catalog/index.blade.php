@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 font-poppins text-slate-800">

    <!-- HEADER & SEARCH -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-emerald-900">Katalog Gear</h1>
            <p class="text-slate-500 text-sm">Temukan perlengkapan terbaik untuk petualanganmu.</p>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('customer.catalog.index') }}" method="GET" class="w-full md:w-96">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari tenda, tas, atau sepatu..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 transition outline-none shadow-sm">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-3.5 text-gray-400"></i>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <!-- SIDEBAR FILTER -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm sticky top-24">
                <h3 class="font-bold text-lg mb-4 flex items-center gap-2 text-slate-800">
                    <i class="fa-solid fa-filter text-emerald-500"></i> Kategori
                </h3>

                <div class="space-y-1">

                    <a href="{{ route('customer.catalog.index') }}"
                       class="flex justify-between items-center px-3 py-2.5 rounded-lg transition {{ !request('category') ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span>Semua Gear</span>
                        <span class="text-xs bg-white px-2 py-0.5 rounded-full border {{ !request('category') ? 'border-emerald-200' : 'border-gray-200' }}">
                            {{ \App\Models\Item::count() }}
                        </span>
                    </a>

                    @foreach($categories as $cat)
                        <a href="{{ route('customer.catalog.index', ['category' => $cat->id]) }}"
                           class="flex justify-between items-center px-3 py-2.5 rounded-lg transition {{ request('category') == $cat->id ? 'bg-emerald-50 text-emerald-700 font-bold' : 'text-gray-600 hover:bg-gray-50' }}">
                            <span>{{ $cat->name }}</span>
                            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
                                {{ $cat->items_count }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- GRID PRODUK -->
        <div class="lg:col-span-3">

            @if($items->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($items as $item)
                    <a href="{{ route('customer.catalog.show', $item->id) }}" class="group block h-full">
                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 h-full flex flex-col p-4 relative">

                            @if($item->stock <= 0)
                                <div class="absolute inset-0 bg-white/60 z-10 flex items-center justify-center rounded-xl">
                                    <span class="bg-gray-800 text-white px-3 py-1 rounded-full text-xs font-bold">Stok Habis</span>
                                </div>
                            @endif

                            <div class="relative aspect-square overflow-hidden rounded-lg bg-gray-50 mb-4 flex items-center justify-center">
                                @if($item->image)
                                  <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}"
                                    alt="{{ $item->name }}"
                                    class="w-full h-full object-cover p-2 group-hover:scale-110 transition duration-500">
                                @else
                                    <i class="fa-solid fa-image text-4xl text-gray-300"></i>
                                @endif
                            </div>

                            <div class="text-center flex flex-col flex-grow">
                                <h3 class="font-bold text-gray-800 text-sm md:text-base mb-2 line-clamp-2 group-hover:text-emerald-600 transition">
                                    {{ $item->name }}
                                </h3>

                                <div class="mt-auto">
                                    <p class="text-gray-500 text-sm mb-1">Sewa per hari</p>
                                    <p class="font-bold text-lg text-slate-800">
                                        Rp {{ number_format($item->rental_price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </a>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $items->withQueryString()->links() }}
                </div>

            @else

                <div class="text-center py-16 bg-white rounded-2xl border border-dashed border-gray-200">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-box-open text-gray-300 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Barang Tidak Ditemukan</h3>
                    <p class="text-gray-500 text-sm">Coba cari dengan kata kunci lain atau reset filter.</p>
                    <a href="{{ route('customer.catalog.index') }}" class="mt-4 inline-block px-4 py-2 bg-emerald-600 text-white text-sm font-bold rounded-lg hover:bg-emerald-700 transition">
                        Reset Pencarian
                    </a>
                </div>

            @endif

        </div>
    </div>
</div>

@endsection
