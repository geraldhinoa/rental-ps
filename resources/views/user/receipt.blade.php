@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12 mb-20 px-4">
    
    @if(session('success'))
    <div class="mb-6 p-3 bg-green-500/20 border border-green-500/50 rounded text-green-400 font-bold text-center text-sm">
        {{ session('success') }}
    </div>
    @endif

    <!-- Midtrans Snap Sandbox -->
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-YOURKEY') }}"></script>

    <!-- Receipt Container (Thermal Paper Style) -->
    <div class="bg-white text-black font-mono text-sm relative shadow-2xl mx-auto drop-shadow-[0_20px_20px_rgba(0,0,0,0.5)]">
        <!-- Top Jagged Edge -->
        <div class="h-3 w-full bg-[url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 20 10\' preserveAspectRatio=\'none\'%3E%3Cpolygon points=\'0,10 5,0 10,10 15,0 20,10\' fill=\'white\'/%3E%3C/svg%3E')] bg-repeat-x bg-top absolute top-[-10px] left-0"></div>

        <div class="p-6 relative">
            <!-- Watermark / Stamp -->
            @if($booking->payment->payment_status !== 'pending')
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-0 overflow-hidden">
                <div class="text-[5rem] font-black text-green-500/30 border-8 border-green-500/30 rounded-3xl p-6 transform -rotate-12 uppercase tracking-widest drop-shadow-md">
                    LUNAS
                </div>
            </div>
            @endif

            <!-- Header -->
            <div class="text-center mb-4 relative z-10">
                <div class="flex justify-center mb-2">
                    <svg class="w-12 h-12 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold tracking-widest uppercase">GAMEZONE</h2>
                <p class="text-xs leading-tight mt-1">Watu Kandang, Penanggal, Kec. Candipuro<br>Kabupaten Lumajang, Jawa Timur</p>
                <p class="text-xs mt-1">Struk Penyewaan Resmi</p>
                <p class="text-xs mt-1 font-bold">{{ $booking->payment->transaction_reference }}</p>
            </div>

            <!-- Dashed Divider -->
            <div class="border-b-2 border-dashed border-gray-400 my-4"></div>

            <!-- Info -->
            <div class="flex justify-between text-xs mb-4">
                <div>
                    <p>No: {{ $booking->id }}</p>
                    <p>Tgl: {{ \Carbon\Carbon::parse($booking->created_at)->setTimezone('Asia/Jakarta')->format('Y-m-d') }}</p>
                    <p>Waktu: {{ \Carbon\Carbon::parse($booking->created_at)->setTimezone('Asia/Jakarta')->format('H:i:s') }} WIB</p>
                </div>
                <div class="text-right">
                    <p>Klien: {{ substr($booking->user->name, 0, 15) }}</p>
                    <p>Tipe: {{ $booking->payment->payment_method }}</p>
                </div>
            </div>

            <div class="border-b-2 border-dashed border-gray-400 my-4"></div>

            <!-- Items -->
            <div class="mb-4 text-xs">
                <div class="font-bold mb-1">Penyewaan:</div>
                <div class="flex justify-between">
                    <div>
                        {{ $booking->inventory->category->name ?? 'Konsol PS' }}<br>
                        ({{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/y H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('d/m/y H:i') }})
                    </div>
                </div>
                <div class="flex justify-between mt-2">
                    <div>1 x Harga Sewa</div>
                    <div>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                </div>
            </div>

            <div class="border-b-2 border-dashed border-gray-400 my-4"></div>

            <!-- Totals -->
            <div class="space-y-1 text-sm font-bold">
                <div class="flex justify-between">
                    <span>Sub Total</span>
                    <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-base mt-2 pt-2 border-t border-gray-300">
                    <span>Total</span>
                    <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-normal text-xs mt-2 relative z-10">
                    <span>Status</span>
                    @if($booking->payment->payment_status === 'pending')
                        <span class="text-gray-600 font-bold border border-gray-400 px-2 py-0.5 rounded">BELUM LUNAS</span>
                    @else
                        <span class="text-green-600 font-bold border-2 border-green-500 px-2 py-0.5 rounded-md animate-pulse">LUNAS</span>
                    @endif
                </div>
            </div>

            <div class="border-b-2 border-dashed border-gray-400 my-4"></div>

            <!-- Footer -->
            <div class="text-center text-xs mt-4 relative z-10">
                <p>Terima kasih telah menyewa di GAMEZONE.</p>
                <p class="mt-1">Harap simpan struk ini sebagai bukti.</p>
                @if($booking->payment->payment_status === 'pending')
                    <p class="mt-2 font-bold uppercase">> SILAKAN BAYAR KE ADMIN <</p>
                @else
                    <p class="mt-2 font-bold uppercase text-green-600">> PEMBAYARAN BERHASIL <</p>
                @endif
                
                <div class="mt-6 flex justify-center">
                    <!-- Fake QR for thermal look -->
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $booking->payment->transaction_reference }}" alt="QR Code" class="w-24 h-24 grayscale">
                </div>
            </div>
        </div>

        <!-- Bottom Jagged Edge -->
        <div class="h-3 w-full bg-[url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 20 10\' preserveAspectRatio=\'none\'%3E%3Cpolygon points=\'0,0 5,10 10,0 15,10 20,0\' fill=\'white\'/%3E%3C/svg%3E')] bg-repeat-x bg-bottom absolute bottom-[-10px] left-0 drop-shadow-[0_5px_5px_rgba(0,0,0,0.2)]"></div>
    </div>

    <div class="mt-8 flex flex-col sm:flex-row justify-center gap-4">
        @if($booking->payment->payment_status === 'pending' && $booking->payment->payment_method === 'OTOMATIS')
        <form method="POST" action="/payment/simulate/{{ $booking->payment->booking_id }}" class="w-full sm:w-auto" id="payment-form">
            @csrf
            <button type="button" id="pay-button" class="w-full premium-btn bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-black py-3 px-8 rounded-xl text-center flex items-center justify-center gap-2 transition-colors font-display tracking-wide shadow-[0_0_20px_rgba(99,102,241,0.5)] border border-white/10 uppercase text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                BAYAR SEKARANG (Midtrans)
            </button>
        </form>
        @elseif($booking->payment->payment_status === 'pending' && $booking->payment->payment_method === 'CASH')
        <div class="w-full sm:w-auto bg-amber-500/10 border border-amber-500/30 text-amber-400 font-bold py-3 px-8 rounded-xl text-center flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            PEMBAYARAN DI KASIR
        </div>
        @endif
        <a href="https://wa.me/6285808750161?text=Halo%20Admin%20GAMEZONE,%20saya%20sudah%20melakukan%20pemesanan%20dengan%20referensi%20{{ $booking->payment->transaction_reference }}." target="_blank" class="w-full sm:w-auto premium-btn bg-green-600 hover:bg-green-500 text-white font-black py-3 px-8 rounded-xl text-center flex items-center justify-center transition-colors font-display tracking-wide shadow-[0_0_15px_rgba(34,197,94,0.3)]">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                HUBUNGI ADMIN VIA WA
            </div>
        </a>
        <a href="/user/dashboard" class="py-3 px-8 rounded-xl text-center font-bold text-slate-300 hover:bg-white/5 border border-white/10 transition-colors bg-slate-800">
            Kembali ke Dasbor
        </a>
    </div>

</div>

@if(isset($snapToken))
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        // SnapToken acquired from backend
        window.snap.pay('{{ $snapToken }}', {
            // Optional
            onSuccess: function(result){
                document.getElementById('payment-form').submit();
            },
            // Optional
            onPending: function(result){
                alert("Menunggu pembayaran Anda!");
            },
            // Optional
            onError: function(result){
                alert("Pembayaran gagal!");
            }
        });
    };
</script>
@endif

@endsection
