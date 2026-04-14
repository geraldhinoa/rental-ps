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
@endsection
