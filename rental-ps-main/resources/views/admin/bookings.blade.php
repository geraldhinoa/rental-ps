@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-display font-bold text-white mb-2">Manajemen <span class="text-blue-500">Pesanan</span></h1>
    <p class="text-slate-400">Kelola dan konfirmasi semua permintaan sewa konsol di sini.</p>
</div>

<!-- Simulasi Konten -->
<div class="glass-panel rounded-2xl border border-white/5 p-8 text-center text-slate-500">
    @if($bookings->isEmpty())
        <div class="flex flex-col items-center justify-center py-12">
            <svg class="w-16 h-16 text-slate-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <h3 class="text-xl font-bold text-white mb-2">Belum ada pesanan aktif</h3>
            <p class="max-w-md mx-auto">Saat Anda mulai menerima pesanan dari halaman Booking, tabel antrean akan muncul di sini secara otomatis.</p>
        </div>
    @else
        <div class="overflow-x-auto text-left">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-700 text-slate-400">
                        <th class="py-4 px-4 font-medium">ID Transaksi</th>
                        <th class="py-4 px-4 font-medium">Pelanggan</th>
                        <th class="py-4 px-4 font-medium">Mesin</th>
                        <th class="py-4 px-4 font-medium">Waktu/Durasi</th>
                        <th class="py-4 px-4 font-medium">Status</th>
                        <th class="py-4 px-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                    <tr class="border-b border-slate-800/50 hover:bg-slate-800/30 transition">
                        <td class="py-4 px-4 text-white font-bold">#TRX-0{{ $booking->id * 100 }}</td>
                        <td class="py-4 px-4 text-slate-300">{{ $booking->user->name ?? 'Gelap' }}</td>
                        <td class="py-4 px-4 text-blue-400">{{ $booking->inventory->name ?? '-' }}</td>
                        <td class="py-4 px-4 text-slate-400">
                            {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}
                            <span class="text-xs text-slate-500 block">(Sampai {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }})</span>
                        </td>
                        <td class="py-4 px-4">
                            @if($booking->status == 'pending')
                                <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-xs font-bold border border-yellow-500/30 flex w-max items-center gap-2"><span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span> Menunggu Validasi</span>
                            @else
                                <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-xs font-bold border border-blue-500/30 flex w-max items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-400"></span> Sedang Bermain</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-right">
                            <button class="bg-blue-600/20 hover:bg-blue-600 border border-blue-500 transition-colors text-white px-4 py-2 rounded-lg text-sm font-bold">Proses</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
