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
        <form action="{{ route('admin.customers.bulkDestroy') }}" method="POST" id="bulk-delete-form">
            @csrf
            @method('DELETE')
            
            <div class="flex justify-between items-center mb-4 px-2">
                <label class="inline-flex items-center cursor-pointer text-slate-300 hover:text-white transition group">
                    <input type="checkbox" id="select-all" class="w-5 h-5 rounded border-slate-600 bg-slate-800 text-blue-500 focus:ring-blue-500 focus:ring-offset-slate-900 cursor-pointer" onclick="toggleAll(this)">
                    <span class="ml-3 font-medium select-none group-hover:text-blue-400">Pilih Semua</span>
                </label>
                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus SEMUA pelanggan yang dipilih?')" class="flex items-center gap-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 border border-red-500/30 px-4 py-2 rounded-xl font-bold text-sm transition shadow-lg shadow-red-500/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Terpilih
                </button>
            </div>

            <div class="overflow-x-auto text-left rounded-xl border border-slate-700/50">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-700 bg-slate-800/50 text-slate-400">
                            <th class="py-4 px-6 w-12"></th>
                            <th class="py-4 px-6 font-medium">Nama Pelanggan</th>
                            <th class="py-4 px-6 font-medium">Whatsapp / Email</th>
                            <th class="py-4 px-6 font-medium">Bergabung Pada</th>
                            <th class="py-4 px-6 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $c)
                        <tr class="border-b border-slate-800/50 hover:bg-slate-800/80 transition group">
                            <td class="py-4 px-6">
                                <input type="checkbox" name="customer_ids[]" value="{{ $c->id }}" class="customer-checkbox w-5 h-5 rounded border-slate-600 bg-slate-800 text-blue-500 focus:ring-blue-500 focus:ring-offset-slate-900 cursor-pointer transition">
                            </td>
                            <td class="py-4 px-6 text-white font-medium group-hover:text-blue-400 transition">{{ $c->name }}</td>
                            <td class="py-4 px-6">
                                <span class="block text-slate-300 font-medium">{{ $c->phone_number }}</span>
                                <span class="block text-slate-500 text-sm mt-0.5">{{ $c->email }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-400">
                                <span class="bg-slate-800 px-3 py-1 rounded-full text-xs border border-slate-700">{{ $c->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="javascript:void(0)" onclick="deleteSingle({{ $c->id }})" class="text-slate-500 hover:text-red-400 transition-colors p-2 inline-block rounded-lg hover:bg-red-500/10">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>

        <form id="single-delete-form" action="" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>

        <script>
            function toggleAll(source) {
                const checkboxes = document.querySelectorAll('.customer-checkbox');
                checkboxes.forEach(cb => cb.checked = source.checked);
            }

            function deleteSingle(id) {
                if(confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')) {
                    const form = document.getElementById('single-delete-form');
                    form.action = '/admin/customers/' + id;
                    form.submit();
                }
            }
        </script>
    @endif
</div>
@endsection
