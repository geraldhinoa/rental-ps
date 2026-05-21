@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-display font-bold text-white mb-2">Kelola <span class="text-indigo-500">Promo</span></h1>
    <p class="text-slate-400">Atur kode voucher diskon yang bisa digunakan pelanggan Anda.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 glass-panel rounded-2xl overflow-hidden p-6 border-t border-white/5">
        <h3 class="text-lg font-bold text-white mb-4">Daftar Kode Promo</h3>
        
        @if(session('success'))
            <div class="bg-green-500/20 text-green-400 text-sm font-bold p-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-900/50 text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="px-4 py-3 font-medium">Kode Voucher</th>
                        <th class="px-4 py-3 font-medium">Potongan (Rp)</th>
                        <th class="px-4 py-3 font-medium">Status Aplikasi</th>
                        <th class="px-4 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($promos as $promo)
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-4 py-4">
                            <span class="font-mono bg-indigo-500/20 text-indigo-300 font-bold px-3 py-1 rounded border border-indigo-500/30">{{ $promo->code }}</span>
                        </td>
                        <td class="px-4 py-4 text-white font-bold">Rp {{ number_format($promo->discount_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-4">
                            @if($promo->is_active)
                                <span class="text-green-400 text-xs font-bold px-2 py-1 bg-green-400/10 rounded-full border border-green-400/20 flex items-center w-max gap-2"><span class="w-2 h-2 bg-green-500 rounded-full"></span> Aktif</span>
                            @else
                                <span class="text-slate-400 text-xs font-bold px-2 py-1 bg-slate-400/10 rounded-full border border-slate-400/20">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="/admin/promo/toggle" method="POST">
                                    @csrf
                                    <input type="hidden" name="code" value="{{ $promo->code }}">
                                    <button type="submit" class="text-xs font-bold px-3 py-1 rounded border {{ $promo->is_active ? 'border-red-500/50 text-red-400 hover:bg-red-500/20' : 'border-green-500/50 text-green-400 hover:bg-green-500/20' }} transition">
                                        {{ $promo->is_active ? 'Matikan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <form action="/admin/promos/{{ $promo->id }}" method="POST" onsubmit="return confirm('Hapus voucher promo ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-500 hover:text-red-400 p-1 transition" title="Hapus Permanen">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-10 text-center text-slate-500">Belum ada promo yang dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Add Promo -->
    <div class="glass-panel p-6 rounded-2xl h-fit border border-indigo-500/20">
        <h3 class="text-lg font-bold text-white mb-4">Buat Promo Baru</h3>
        
        <form action="/admin/promos" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">Kode Voucher (Huruf Besar)</label>
                <input type="text" name="code" required placeholder="Misal: MERDEKA20" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white outline-none focus:border-indigo-500 font-mono uppercase">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">Nilai Potongan (Rupiah)</label>
                <input type="number" name="discount_amount" required placeholder="Misal: 15000" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">Deskripsi Singkat (Tampil di Beranda)</label>
                <input type="text" name="description" required placeholder="Misal: Diskon Kemerdekaan RI" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white outline-none focus:border-indigo-500">
            </div>
            <p class="text-xs text-slate-500 leading-relaxed mt-2">Voucher yang dibuat akan otomatis langsung aktif dan bisa digunakan oleh pelanggan saat memesan.</p>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-xl transition mt-4 shadow-[0_0_15px_rgba(79,70,229,0.4)] flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Buat Promo
            </button>
        </form>
    </div>
</div>
@endsection
