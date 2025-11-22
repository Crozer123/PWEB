@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow-sm border">

    <div class="flex justify-between mb-4">
        <h2 class="text-xl font-bold">Edit Rental #{{ $rental->id }}</h2>

        <a href="{{ route('admin.rentals.index') }}"
           class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.rentals.update', $rental->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="font-medium block mb-1">Status Rental</label>
            <select name="status" class="p-2 border rounded w-full">
                {{-- PERBAIKAN: Ubah 'active' jadi 'rented' --}}
                <option value="rented" {{ $rental->status=='rented' ? 'selected' : '' }}>
                    Active (Sedang Dipinjam)
                </option>
                
                <option value="returned" {{ $rental->status=='returned' ? 'selected' : '' }}>
                    Returned (Sudah Dikembalikan)
                </option>
                
                {{-- PERBAIKAN: Ubah 'cancelled' jadi 'canceled' (L satu) --}}
                <option value="canceled" {{ $rental->status=='canceled' ? 'selected' : '' }}>
                    Cancelled (Dibatalkan)
                </option>

                <option value="pending" {{ $rental->status=='pending' ? 'selected' : '' }}>
                    Pending
                </option>
            </select>
        </div>

        <button class="px-6 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">
            Simpan Perubahan
        </button>
    </form>

</div>

@endsection