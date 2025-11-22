@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Penyewaan</h2>
            <p class="text-sm text-gray-500">Kelola semua data penyewaan pelanggan di sini.</p>
        </div>
        
        <div class="flex gap-2">
             {{-- <button class="px-4 py-2 bg-white border rounded-lg text-sm font-medium hover:bg-gray-50">Filter</button> --}}
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="p-4 font-semibold">ID Transaksi</th>
                        <th class="p-4 font-semibold">Pelanggan</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold">Total Pembayaran</th>
                        <th class="p-4 font-semibold">Tanggal Sewa</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($rentals as $r)
                    <tr class="hover:bg-gray-50 transition-colors duration-200 group">
                        
                        <td class="p-4 text-sm text-gray-500 font-mono">
                            #{{ $r->id }}
                        </td>

                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                    {{ substr($r->user->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-gray-900">{{ $r->user->name }}</span>
                            </div>
                        </td>

                        <td class="p-4">
                            @php
                                $statusColor = match($r->status) {
                                    'paid', 'completed', 'selesai' => 'bg-green-100 text-green-700 border-green-200',
                                    'pending', 'menunggu' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                    'cancelled', 'batal' => 'bg-red-100 text-red-700 border-red-200',
                                    'active', 'disewa' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    default => 'bg-gray-100 text-gray-700 border-gray-200',
                                };
                            @endphp
                            <span class="px-3 py-1 text-xs font-medium rounded-full border {{ $statusColor }}">
                                {{ ucfirst($r->status) }}
                            </span>
                        </td>

                        <td class="p-4 font-medium text-gray-900">
                            Rp {{ number_format($r->total_price, 0, ',', '.') }}
                        </td>

                        <td class="p-4 text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($r->rental_date)->format('d M Y') }}
                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($r->rental_date)->format('H:i') }} WIB</div>
                        </td>

                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <a href="{{ route('admin.rentals.show', $r->id) }}" 
                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" 
                                   title="Lihat Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <a href="{{ route('admin.rentals.edit', $r->id) }}" 
                                   class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" 
                                   title="Edit Data">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <form action="{{ route('admin.rentals.destroy', $r->id) }}" method="POST" class="inline-block">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)" 
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" 
                                            title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                <p>Belum ada data penyewaan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($rentals->hasPages())
        <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
            {{ $rentals->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    function confirmDelete(button) {
        if (confirm('Apakah Anda yakin ingin menghapus data penyewaan ini? Data tidak dapat dikembalikan.')) {
            button.closest('form').submit();
        }
    }
</script>
@endsection