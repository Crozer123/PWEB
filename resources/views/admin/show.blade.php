@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        
        <!-- Header with Back Button -->
        <div class="mb-8">
            <a href="{{ route('admin.items.index') }}" class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold transition group mb-4">
                <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('Back to Items List') }}
            </a>
            
            <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-2xl shadow-xl p-8">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 p-4 rounded-xl">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-white">{{ $item->name }}</h1>
                        <p class="text-green-100 mt-1">{{ __('Item Details & Information') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column - Image -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden sticky top-8">
                    <div class="relative">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-96 object-cover">
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-lg shadow-lg">
                                <span class="text-xs font-bold text-gray-700">ID: #{{ $item->id }}</span>
                            </div>
                        @else
                            <div class="w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-500 font-medium">{{ __('No Image Available') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="p-6 border-t border-gray-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-4 bg-green-50 rounded-xl">
                                <svg class="w-8 h-8 mx-auto text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-2xl font-bold text-gray-800">Rp{{ number_format($item->rental_price, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ __('Price/Day') }}</p>
                            </div>
                            <div class="text-center p-4 bg-teal-50 rounded-xl">
                                <svg class="w-8 h-8 mx-auto text-teal-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="text-2xl font-bold text-gray-800">{{ $item->stock }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ __('Units in Stock') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Button -->
                    <div class="p-6 border-t border-gray-100">
                        <a href="{{ route('admin.items.edit', $item) }}" class="flex items-center justify-center w-full bg-gradient-to-r from-green-600 to-teal-600 text-white font-bold py-3 px-6 rounded-xl hover:from-green-700 hover:to-teal-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            {{ __('Edit Item') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column - Details -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Basic Information Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-teal-500 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('Basic Information') }}
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-4 rounded-xl border-l-4 border-green-500">
                                    <p class="text-sm font-medium text-gray-500 mb-1 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                        </svg>
                                        {{ __('Item ID') }}
                                    </p>
                                    <p class="text-lg font-bold text-gray-900">#{{ $item->id }}</p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-xl border-l-4 border-teal-500">
                                    <p class="text-sm font-medium text-gray-500 mb-1 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                        {{ __('Category') }}
                                    </p>
                                    <p class="text-lg font-bold text-gray-900">{{ $item->category->name ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="bg-gray-50 p-4 rounded-xl border-l-4 border-blue-500">
                                    <p class="text-sm font-medium text-gray-500 mb-1 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ __('Rental Price (per day)') }}
                                    </p>
                                    <p class="text-lg font-bold text-gray-900">Rp{{ number_format($item->rental_price, 0, ',', '.') }}</p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-xl border-l-4 border-purple-500">
                                    <p class="text-sm font-medium text-gray-500 mb-1 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        {{ __('Total Stock') }}
                                    </p>
                                    <p class="text-lg font-bold text-gray-900">{{ $item->stock }} {{ __('units') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-teal-500 to-blue-500 px-6 py-4">
                        <h2 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                            {{ __('Description') }}
                        </h2>
                    </div>
                    <div class="p-6">
                        <div class="prose max-w-none">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $item->description }}</p>
                        </div>  
                    </div>
                </div>

                <!-- Stock Status Banner -->
                <div class="bg-gradient-to-r {{ $item->stock > 10 ? 'from-green-500 to-teal-500' : ($item->stock > 0 ? 'from-yellow-500 to-orange-500' : 'from-red-500 to-pink-500') }} rounded-2xl shadow-xl p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white/20 p-4 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($item->stock > 10)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    @elseif($item->stock > 0)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    @endif
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white">
                                    @if($item->stock > 10)
                                        {{ __('In Stock') }}
                                    @elseif($item->stock > 0)
                                        {{ __('Low Stock') }}
                                    @else
                                        {{ __('Out of Stock') }}
                                    @endif
                                </h3>
                                <p class="text-white/80">
                                    @if($item->stock > 10)
                                        {{ __('Item is available for rental') }}
                                    @elseif($item->stock > 0)
                                        {{ __('Only few items remaining') }}
                                    @else
                                        {{ __('Item needs to be restocked') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-5xl font-bold text-white">{{ $item->stock }}</p>
                            <p class="text-white/80 text-sm">{{ __('units') }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection