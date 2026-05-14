@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-12 mb-20 px-4">
    
    @if(session('success'))
    <div class="mb-8 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-400 font-bold text-center flex items-center justify-center gap-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar Profile -->
        <div class="w-full md:w-1/3 space-y-6">
            <div class="glass-panel p-8 rounded-3xl relative overflow-hidden text-center border-t border-white/10">
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 bg-blue-500/20 rounded-full blur-[30px]"></div>
                
                <div class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-600 to-indigo-800 rounded-full flex items-center justify-center shadow-[0_0_20px_rgba(59,130,246,0.3)] mb-4 border-2 border-white/10">
                    <span class="text-3xl font-black text-white font-display">{{ substr($user->name, 0, 1) }}</span>
                </div>
                
                <h2 class="text-xl font-display font-bold text-white">{{ $user->name }}</h2>
                <p class="text-slate-400 text-sm mb-6">
                    @if(str_ends_with($user->email, '@guest.gamezone.com'))
                        <span class="text-xs font-bold text-yellow-500/80 uppercase tracking-widest">Email Belum Diatur</span>
                    @else
                        {{ $user->email }}
                    @endif
                </p>
                
                <div class="bg-slate-900/50 rounded-xl p-4 text-left border border-white/5 space-y-3">
                    <div>
                        <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">No WhatsApp</span>
                        <p class="text-white font-medium text-sm">{{ $user->phone_number ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Bergabung Sejak</span>
                        <p class="text-white font-medium text-sm">{{ $user->created_at->translatedFormat('d M Y') }}</p>
                    </div>
                </div>
                
                <div class="mt-4 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 border border-blue-500/30 rounded-xl p-4 text-center">
                    <span class="text-xs text-blue-300 font-bold uppercase tracking-wider block mb-1">Member Terverifikasi</span>
                    <span class="text-white font-bold text-sm">Total Belanja: Rp {{ number_format($bookings->where('status', '!=', 'cancelled')->sum('total_price'), 0, ',', '.') }}</span>
                </div>
                
                <div class="mt-6">
                    <a href="/logout" class="block w-full py-3 rounded-xl border border-red-500/30 text-red-400 font-bold hover:bg-red-500/10 transition-colors uppercase tracking-widest text-sm">
                        Keluar Akun
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full md:w-2/3">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-display font-black text-white uppercase drop-shadow-lg">Riwayat <span class="text-blue-400">Pesanan</span></h2>
                    <p class="text-slate-400">Daftar semua penyewaan konsol Anda.</p>
                </div>
                <a href="/booking" class="premium-btn py-2 px-6 rounded-lg text-white font-bold text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Sewa Baru
                </a>
            </div>

            <div class="space-y-4">
                @forelse($bookings as $booking)
                <div class="glass-panel p-6 rounded-2xl flex flex-col sm:flex-row justify-between sm:items-center gap-4 hover:border-blue-500/30 transition-colors">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-2 py-1 bg-slate-800 text-slate-300 rounded text-xs font-bold border border-white/5 font-mono">
                                {{ $booking->payment->transaction_reference ?? 'TRX-...' }}
                            </span>
                            @if($booking->payment->payment_status === 'pending')
                                <span class="text-yellow-400 text-xs font-bold uppercase tracking-widest flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span> Belum Bayar
                                </span>
                            @else
                                <span class="text-green-400 text-xs font-bold uppercase tracking-widest flex items-center gap-1">
                                    <span class="w-2 h-2 rounded-full bg-green-400"></span> Lunas
                                </span>
                            @endif
                        </div>
                        
                        <h4 class="text-lg font-bold text-white font-display mb-1">
                            Sewa {{ $booking->inventory->category->name ?? 'Konsol' }}
                        </h4>
                        <p class="text-sm text-slate-400 mb-2">
                            {{ \Carbon\Carbon::parse($booking->start_time)->translatedFormat('d M Y, H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->translatedFormat('d M Y, H:i') }}
                        </p>
                    </div>
                    
                    <div class="sm:text-right flex flex-row sm:flex-col justify-between sm:justify-center items-center sm:items-end">
                        <div class="mb-2">
                            <span class="block text-xs text-slate-500 font-bold uppercase tracking-wider mb-1">Total Tagihan</span>
                            <span class="text-xl font-black text-blue-300 font-display">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                        <a href="/booking/{{ $booking->id }}/receipt" class="text-sm font-bold text-cyan-400 hover:text-cyan-300 underline underline-offset-4">Lihat Struk</a>
                    </div>
                </div>
                @empty
                <div class="glass-panel p-10 rounded-3xl text-center border-dashed border-2 border-white/10">
                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-500">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Belum ada riwayat pesanan</h3>
                    <p class="text-slate-400 mb-6">Kamu belum pernah menyewa konsol. Yuk mulai sewa sekarang!</p>
                    <a href="/booking" class="inline-block premium-btn py-3 px-8 rounded-xl font-bold text-white">Mulai Sewa</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
