@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 flex justify-center">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-md w-full text-center border border-slate-100">
        
        {{-- Icon Dompet --}}
        <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-wallet text-4xl text-emerald-600"></i>
        </div>

        <h2 class="text-2xl font-bold mb-2 text-slate-800">Selesaikan Pembayaran</h2>
        <p class="text-slate-500 mb-6">Order ID: #{{ $rental->id }}</p>

        {{-- Detail Harga --}}
        <div class="bg-slate-50 p-4 rounded-xl mb-8">
            <p class="text-sm text-slate-500 mb-1">Total Tagihan</p>
            <div class="text-3xl font-bold text-emerald-600">
                Rp {{ number_format($rental->total_price, 0, ',', '.') }}
            </div>
        </div>

        {{-- Tombol Bayar --}}
        <button id="pay-button" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl transition shadow-lg shadow-emerald-200">
            Bayar Sekarang
        </button>
    </div>
</div>

{{-- 
    PENTING:
    Script ditempatkan di sini agar UI dimuat terlebih dahulu.
    Pastikan config('services.midtrans.client_key') sudah diatur di .env dan config/services.php 
--}}
<script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    
    payButton.addEventListener('click', function () {
        // Trigger snap popup. @TODO: Ganti $rental->snap_token dengan token dari controller
        window.snap.pay('{{ $rental->snap_token }}', {
            onSuccess: function (result) {
                // Pembayaran sukses
                // alert("payment success!"); 
                window.location.href = "{{ route('customer.rentals.history') }}";
                console.log(result);
            },
            onPending: function (result) {
                // Menunggu pembayaran
                // alert("wating your payment!"); 
                location.reload(); 
                console.log(result);
            },
            onError: function (result) {
                // Pembayaran gagal
                // alert("payment failed!"); 
                location.reload();
                console.log(result);
            },
            onClose: function () {
                // Saat popup ditutup tanpa bayar
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
@endsection