@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-display font-bold text-white mb-2">Halo, Admin! 👋</h1>
    <p class="text-slate-400">Berikut adalah update rental Anda secara real-time hari ini.</p>
</div>

<!-- Metrics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition"></div>
        <div class="flex items-start justify-between mb-2">
            <h3 class="text-slate-400 text-sm font-medium">Pendapatan Hari Ini</h3>
            <div class="p-2 bg-blue-500/20 rounded-lg text-blue-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <h2 class="text-3xl font-bold tracking-tight text-white mb-1">Rp {{ number_format($revenue, 0, ',', '.') }}</h2>
        <p class="text-xs text-green-400 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            +15% dari kemarin
        </p>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-cyan-500/10 rounded-full blur-2xl group-hover:bg-cyan-500/20 transition"></div>
        <div class="flex items-start justify-between mb-2">
            <h3 class="text-slate-400 text-sm font-medium">Pesanan Aktif</h3>
            <div class="p-2 bg-cyan-500/20 rounded-lg text-cyan-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <h2 class="text-3xl font-bold tracking-tight text-white mb-1">{{ $activeRentals }} <span class="text-lg text-slate-500 font-normal">Sewa</span></h2>
        <p class="text-xs text-slate-400">Sedang bermain sekarang</p>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-500/10 rounded-full blur-2xl group-hover:bg-yellow-500/20 transition"></div>
        <div class="flex items-start justify-between mb-2">
            <h3 class="text-slate-400 text-sm font-medium">Menunggu Validasi</h3>
            <div class="p-2 bg-yellow-500/20 rounded-lg text-yellow-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <h2 class="text-3xl font-bold tracking-tight text-white mb-1">{{ $pendingBookings }} <span class="text-lg text-slate-500 font-normal">Antrean</span></h2>
        <p class="text-xs text-yellow-400">Memerlukan Konfirmasi</p>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl group-hover:bg-purple-500/20 transition"></div>
        <div class="flex items-start justify-between mb-2">
            <h3 class="text-slate-400 text-sm font-medium">Ketersediaan Mesin</h3>
            <div class="p-2 bg-purple-500/20 rounded-lg text-purple-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
            </div>
        </div>
        <h2 class="text-3xl font-bold tracking-tight text-white mb-1">12/30</h2>
        <p class="text-xs text-slate-400">Mesin sedang menganggur</p>
    </div>
</div>

<!-- Data Table -->
<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-slate-800 flex items-center justify-between">
        <h3 class="text-lg font-bold text-white">Transaksi Terbaru</h3>
        <button class="bg-slate-800 text-sm text-slate-300 font-medium px-4 py-2 rounded-lg hover:bg-slate-700 transition">Lihat Semua</button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-900/50 text-slate-400 border-b border-slate-800">
                <tr>
                    <th class="px-6 py-4 font-medium">ID Transaksi</th>
                    <th class="px-6 py-4 font-medium">Pelanggan</th>
                    <th class="px-6 py-4 font-medium">Mesin</th>
                    <th class="px-6 py-4 font-medium">Waktu/Durasi</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/80">
                @forelse($bookings as $trx)
                <tr class="hover:bg-slate-800/30 transition">
                    <td class="px-6 py-4 text-white font-medium">#TRX-0{{ $trx->id * 100 }}</td>
                    <td class="px-6 py-4 text-slate-300">{{ $trx->user->name ?? 'Guest' }}</td>
                    <td class="px-6 py-4 text-ps-neon cursor-pointer hover:underline">{{ $trx->inventory->name ?? 'PS Unit' }}</td>
                    <td class="px-6 py-4 text-slate-400">{{ \Carbon\Carbon::parse($trx->start_time)->format('H:i') }} (Sampai {{ \Carbon\Carbon::parse($trx->end_time)->format('H:i') }})</td>
                    <td class="px-6 py-4">
                        @if($trx->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> Aktif
                            </span>
                        @elseif($trx->status === 'pending')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Menunggu Validasi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-500/10 text-slate-400 border border-slate-500/20">
                                Selesai
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($trx->status === 'pending')
                            <button class="text-blue-400 hover:text-blue-300 transition font-medium border border-blue-500/30 px-3 py-1 rounded-lg">Proses</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                        Belum ada pesanan yang masuk ke toko Anda hari ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Promo Engine Control -->
<div class="mt-8 glass-panel rounded-2xl overflow-hidden p-6">
    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        Kontrol Promo Hari Ini
    </h3>
    <form action="/admin/promo/toggle" method="POST" class="flex items-center gap-4">
        @csrf
        <input type="hidden" name="code" value="MARATHON35K">
        <div class="flex-1 bg-slate-900/50 border border-slate-700 p-4 rounded-xl flex items-center justify-between">
            <div>
                <p class="text-white font-bold">Promo: MARATHON35K (Potongan Rp 45.000)</p>
                <p class="text-slate-400 text-sm">Pelanggan bisa menggunakan kode ini di form pemesanan jika diaktifkan.</p>
            </div>
            @php $promo = \App\Models\Promo::where('code', 'MARATHON35K')->first(); @endphp
            @if($promo && $promo->is_active)
                <button type="submit" class="bg-red-500/10 text-red-400 border border-red-500/20 px-6 py-2 rounded-lg font-bold hover:bg-red-500/20 transition">
                    Matikan Promo
                </button>
            @else
                <button type="submit" class="bg-green-500/10 text-green-400 border border-green-500/20 px-6 py-2 rounded-lg font-bold hover:bg-green-500/20 transition">
                    Nyalakan Promo
                </button>
            @endif
        </div>
    </form>
</div>
@endsection
