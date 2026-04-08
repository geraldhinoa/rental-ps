@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-display font-bold text-white mb-2">Data <span class="text-blue-500">Pelanggan</span></h1>
    <p class="text-slate-400">Database kontak pelanggan setia GAMEZONE.</p>
</div>

<div class="glass-panel rounded-2xl border border-white/5 p-8 text-center text-slate-500">
    @if($customers->isEmpty())
        <div class="flex flex-col items-center justify-center py-12">
            <svg class="w-16 h-16 text-slate-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <h3 class="text-xl font-bold text-white mb-2">Belum ada pelanggan terdaftar</h3>
            <p class="max-w-md mx-auto">Riwayat penyewa akan otomatis direkam dan dikumpulkan di sini.</p>
        </div>
    @else
        <div class="overflow-x-auto text-left">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-700 text-slate-400">
                        <th class="py-4 px-6 font-medium">Nama Pelanggan</th>
                        <th class="py-4 px-6 font-medium">Whatsapp / Email</th>
                        <th class="py-4 px-6 font-medium">Bergabung Pada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $c)
                    <tr class="border-b border-slate-800/50 hover:bg-slate-800/30 transition">
                        <td class="py-4 px-6 text-white font-medium">{{ $c->name }}</td>
                        <td class="py-4 px-6">
                            <span class="block text-slate-300">{{ $c->phone_number }}</span>
                            <span class="block text-slate-500 text-sm">{{ $c->email }}</span>
                        </td>
                        <td class="py-4 px-6 text-slate-400">{{ $c->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
