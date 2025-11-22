@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12 flex justify-center">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-md w-full text-center border border-slate-100">
        <h2 class="text-2xl font-bold mb-2 text-slate-800">Selesaikan Pembayaran</h2>
        <p class="text-slate-500 mb-6">Order ID: #{{ $rental->id }}</p>
        <div class="text-3xl font-bold text-emerald-600 mb-8">
            Rp {{ number_format($rental->total_price, 0, ',', '.') }}
        </div>
        <button id="pay-button" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl transition shadow-lg">
            Bayar Sekarang
        </button>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        window.snap.pay('{{ $rental->snap_token }}', {
            onSuccess: function(result){
                window.location.href = "{{ route('customer.rentals.history') }}";
            },
            onPending: function(result){ location.reload(); },
            onError: function(result){ location.reload(); }
        });
    };
</script>
@endsection