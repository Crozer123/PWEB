@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow-md border">

    <div class="flex justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Rental #{{ $rental->id }}</h2>

        <a href="{{ route('admin.rentals.index') }}"
            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg transition-colors duration-150 hover:bg-gray-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

        <div class="rounded-lg border border-gray-200 bg-gray-50 p-5 shadow-sm">
            <h3 class="mb-3 text-lg font-semibold text-gray-700">Informasi Penyewa</h3>
            <p class="text-gray-600"><strong>Nama:</strong> {{ $rental->user->name }}</p>
            <p class="text-gray-600"><strong>Email:</strong> {{ $rental->user->email }}</p>
        </div>

        <div class="rounded-lg border border-gray-200 bg-gray-50 p-5 shadow-sm md:col-span-2">
            <h3 class="mb-3 text-lg font-semibold text-gray-700">Detail Sewa</h3>
            <div class="grid grid-cols-2 gap-y-2">
                <p class="text-gray-600"><strong>Tanggal Sewa:</strong> 
                    <span class="font-medium">{{ \Carbon\Carbon::parse($rental->rental_date)->format('d M Y') }}</span>
                </p>

                <p class="text-gray-600"><strong>Tanggal Kembali:</strong> 
                    <span class="font-medium">{{ \Carbon\Carbon::parse($rental->return_date)->format('d M Y') }}</span>
                </p>

                @if ($rental->returned_at)
                <p class="text-gray-600 col-span-2">
                    <strong>Dikembalikan Pada:</strong> 
                    <span class="text-emerald-600 font-medium">{{ \Carbon\Carbon::parse($rental->returned_at)->format('d M Y H:i') }}</span>
                </p>
                @endif

                @php
                    $statusColors = [
                        'pending' => 'bg-amber-100 text-amber-800',
                        'active' => 'bg-blue-100 text-blue-800',
                        'returned' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                    ];
                    $statusClass = $statusColors[$rental->status] ?? 'bg-gray-100 text-gray-800';
                @endphp

                <p class="text-gray-600"><strong>Status:</strong>
                    <span class="px-2 py-1 text-xs rounded font-semibold {{ $statusClass }}">
                        {{ ucfirst($rental->status) }}
                    </span>
                </p>

                <p class="text-gray-600"><strong>Total Harga:</strong> 
                    <span class="text-lg font-bold text-gray-800">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="mt-8 border-t pt-6">
        <h3 class="mb-3 text-xl font-bold text-gray-800">Item yang Disewa</h3>

        <div class="overflow-x-auto rounded-lg border">
            <table class="min-w-full text-left divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50 text-gray-600">
                        <th class="py-3 px-4 text-xs uppercase tracking-wider">Item</th>
                        <th class="px-4 text-xs uppercase tracking-wider">Kuantitas</th>
                        <th class="px-4 text-xs uppercase tracking-wider">Harga/Hari</th>
                        <th class="px-4 text-xs uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach ($rental->details as $d)
                    <tr>
                        <td class="py-3 px-4 font-medium text-gray-900">{{ $d->item->name }}</td>
                        <td class="px-4 text-gray-700">{{ $d->quantity }}</td>
                        <td class="px-4 text-gray-700">Rp {{ number_format($d->item->price_per_day ?? 0, 0, ',', '.') }}</td>
                        <td class="px-4 font-semibold text-gray-800">Rp {{ number_format($d->subtotal_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($rental->status !== 'returned' && $rental->status !== 'cancelled')
        <div class="mt-8 border-t pt-6">
            <h3 class="mb-4 text-xl font-bold text-gray-800">Update Status Rental</h3>

            <form method="POST" action="{{ route('admin.rentals.update', $rental->id) }}" class="flex items-center space-x-3">
                @csrf
                @method('PUT')
                
                <select name="status" class="p-2 border border-gray-300 rounded-lg focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="active" {{ $rental->status=='active' ? 'selected' : '' }}>Active (Barang Dipinjam)</option>
                    <option value="returned" {{ $rental->status=='returned' ? 'selected' : '' }}>Returned (Barang Dikembalikan)</option>
                    <option value="cancelled" {{ $rental->status=='cancelled' ? 'selected' : '' }}>Cancelled (Dibatalkan)</option>
                    <option value="pending" {{ $rental->status=='pending' ? 'selected' : '' }}>Pending (Menunggu Persetujuan)</option>
                </select>

                <button class="px-4 py-2 bg-emerald-600 text-white rounded-lg transition-colors duration-150 hover:bg-emerald-700 font-medium">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    @else
        <div class="mt-8 border-t pt-6 p-4 bg-green-50 rounded-lg border-green-200">
            <p class="text-lg font-semibold text-green-700">
                <i class="fas fa-check-circle mr-2"></i> Transaksi ini sudah diselesaikan.
            </p>
        </div>
    @endif

</div>
@endsection
