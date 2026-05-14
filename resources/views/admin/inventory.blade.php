@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-display font-bold text-white mb-2">Inventaris <span class="text-blue-500">Mesin</span></h1>
    <p class="text-slate-400">Pantau ketersediaan dan kondisi unit PlayStation.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-blue-600/10 border border-blue-500/20 rounded-xl p-6">
        <h3 class="text-xl font-bold text-white mb-2">PS5</h3>
        <p class="text-blue-400 font-bold text-3xl">{{ $ps5Count }} <span class="text-sm font-normal text-slate-400">Total Unit</span></p>
    </div>
    <div class="bg-purple-600/10 border border-purple-500/20 rounded-xl p-6">
        <h3 class="text-xl font-bold text-white mb-2">PS4 Pro</h3>
        <p class="text-purple-400 font-bold text-3xl">{{ $ps4Count }} <span class="text-sm font-normal text-slate-400">Total Unit</span></p>
    </div>
    <div class="bg-emerald-600/10 border border-emerald-500/20 rounded-xl p-6">
        <h3 class="text-xl font-bold text-white mb-2">PS3 Retro</h3>
        <p class="text-emerald-400 font-bold text-3xl">{{ $ps3Count }} <span class="text-sm font-normal text-slate-400">Total Unit</span></p>
    </div>
</div>

<div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 glass-panel rounded-2xl overflow-hidden p-6">
        <h3 class="text-lg font-bold text-white mb-4">Daftar Inventaris</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-900/50 text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="px-4 py-3 font-medium">ID</th>
                        <th class="px-4 py-3 font-medium">Nama/Kode Mesin</th>
                        <th class="px-4 py-3 font-medium">Kategori</th>
                        <th class="px-4 py-3 font-medium">Status Saat Ini</th>
                        <th class="px-4 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @forelse($inventories ?? [] as $inv)
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-4 py-3 text-slate-500 font-mono">#{{ $inv->id }}</td>
                        <td class="px-4 py-3 text-white font-bold">{{ $inv->name }}</td>
                        <td class="px-4 py-3 text-slate-400">{{ $inv->category->name ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($inv->status == 'available')
                                <span class="text-green-400 text-xs font-bold px-2 py-1 bg-green-400/10 rounded-full border border-green-400/20">Tersedia</span>
                            @elseif($inv->status == 'rented')
                                <span class="text-blue-400 text-xs font-bold px-2 py-1 bg-blue-400/10 rounded-full border border-blue-400/20">Sedang Disewa</span>
                            @else
                                <span class="text-red-400 text-xs font-bold px-2 py-1 bg-red-400/10 rounded-full border border-red-400/20">Maintenance</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <form action="/admin/inventory/{{ $inv->id }}" method="POST" onsubmit="return confirm('Hapus mesin ini secara permanen?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400 p-1">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-slate-500">Belum ada data mesin.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="glass-panel p-6 rounded-2xl h-fit border border-blue-500/20">
        <h3 class="text-lg font-bold text-white mb-4">Mendaftarkan Mesin Baru</h3>
        
        @if(session('success'))
            <div class="bg-green-500/20 text-green-400 text-sm p-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        
        <form action="/admin/inventory" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">Kategori Konsol</label>
                <select name="category_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white outline-none focus:border-blue-500">
                    <option value="">-- Pilih --</option>
                    @foreach($categories ?? [] as $c)
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">Nama / Kode Unit (Bebas)</label>
                <input type="text" name="name" required placeholder="Misal: PS5 - TV 1 Pojok" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white outline-none focus:border-blue-500">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 rounded-lg transition mt-4 shadow-[0_0_15px_rgba(37,99,235,0.4)]">
                + Tambah Mesin
            </button>
        </form>
    </div>

    <!-- Atur Harga Sewa -->
    <div class="glass-panel p-6 rounded-2xl h-fit border border-purple-500/20 mt-8 lg:mt-0 lg:col-span-1 lg:col-start-3">
        <h3 class="text-lg font-bold text-white mb-4">Atur Harga Sewa (Per Jam)</h3>
        
        <form action="/admin/inventory/prices" method="POST" class="space-y-4">
            @csrf
            @foreach($categories ?? [] as $c)
            <div>
                <label class="block text-xs font-bold text-slate-400 mb-1 uppercase">{{ $c->name }}</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-slate-400 font-bold">Rp</span>
                    <input type="number" name="prices[{{ $c->id }}]" value="{{ $c->price_per_hour ?? 0 }}" required class="w-full bg-slate-900 border border-slate-700 rounded-lg pl-10 pr-3 py-2 text-white outline-none focus:border-purple-500">
                </div>
            </div>
            @endforeach
            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-500 text-white font-bold py-2 rounded-lg transition mt-4 shadow-[0_0_15px_rgba(168,85,247,0.4)]">
                Simpan Harga
            </button>
        </form>
    </div>
</div>
@endsection
