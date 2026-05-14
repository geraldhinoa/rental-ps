@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-display font-black text-white mb-3 uppercase tracking-wider">Formulir <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Pemesanan</span></h1>
        <p class="text-slate-400 font-medium">Pesan mesin konsol idaman Anda dengan mudah, cepat, dan tanpa ribet.</p>
    </div>

    <div class="glass-panel p-8 md:p-10 rounded-[2rem] relative overflow-hidden border border-white/10">

        @if($errors->any())
            <div id="alert-box" class="mb-8 p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/50 flex items-start gap-3 shadow-[0_0_15px_rgba(234,179,8,0.2)]">
                <div class="text-yellow-400 mt-0.5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-yellow-400 font-bold font-display uppercase tracking-wider text-sm mb-1">Data Belum Lengkap</h3>
                    <ul class="text-slate-300 font-medium text-sm list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Scroll to alert script -->
        @if(session('error') || $errors->any())
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const alertBox = document.getElementById('alert-box');
                    if(alertBox) {
                        alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            </script>
        @endif

        <form action="/booking" method="POST" class="relative z-10" x-data="{ 
            unit: '{{ request('category') ?: (($stock['ps5'] > 0) ? 'ps5' : (($stock['ps4'] > 0) ? 'ps4' : (($stock['ps3'] > 0) ? 'ps3' : 'ps5'))) }}', 
            rental_type: 'main_di_tempat',
            duration: 1, 
            payment_method: 'otomatis',
            promo_code: '{{ request('promo') }}',
            promo_error: '',
            promos: @js($promos ?? []),
            hasTouchedTime: false,
            init() {
                this.updateTime();
                setInterval(() => {
                    if (!this.hasTouchedTime) {
                        this.updateTime();
                    }
                }, 10000); // Check and update every 10 seconds to be responsive
            },
            updateTime() {
                const now = new Date();
                const offset = now.getTimezoneOffset() * 60000;
                const localTime = (new Date(now - offset)).toISOString().slice(0, 16);
                this.$refs.startTime.value = localTime;
            },
            getRate() { 
                let rate = 4000;
                if (this.rental_type === 'bawa_pulang') {
                    if(this.unit === 'ps5') rate = 200000;
                    else if(this.unit === 'ps4') rate = 100000;
                    else rate = 50000; // ps3
                } else {
                    if(this.unit === 'ps5') rate = 10000;
                    else if(this.unit === 'ps4') rate = 6000;
                    else rate = 4000; // ps3
                }
                return rate;
            },
            getDiscount() {
                this.promo_error = '';
                if (!this.promo_code) return 0;
                
                let matched = this.promos.find(p => p.code.toUpperCase() === this.promo_code.toUpperCase() && p.is_active);
                
                if (matched) {
                    let discount = parseFloat(matched.discount_amount);
                    let subtotal = this.getRate() * this.duration;
                    
                    if (subtotal <= discount) {
                        this.promo_error = 'Opps! Minimal transaksi kamu harus lebih dari Rp ' + discount.toLocaleString('id-ID') + ' untuk menggunakan kode ini.';
                        return 0;
                    }
                    
                    return discount;
                }
                
                if (this.promo_code.length > 4) {
                    this.promo_error = 'Kode promo tidak ditemukan atau sudah kadaluarsa!';
                }
                
                return 0;
            },
            calculateTotal() { 
                let final = (this.getRate() * this.duration) - this.getDiscount();
                return final < 0 ? 0 : final;
            },
            isPromoValid() {
                return this.getDiscount() > 0;
            }
        }" x-init="init()">
            @csrf
            
            @if(session('error'))
            <div id="alert-box" class="mb-6 bg-red-500/20 border border-red-500/50 text-red-100 p-4 rounded-xl flex gap-3 items-start">
                <svg class="w-6 h-6 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div>
                    <h4 class="font-bold text-red-300">Pemesanan Gagal</h4>
                    <p class="text-sm mt-1 opacity-90">{{ session('error') }}</p>
                </div>
            </div>
            @endif
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Data Pemesan -->
                <div class="space-y-6">
                    <h3 class="text-xl font-bold font-display uppercase tracking-widest text-white border-b border-white/10 pb-3">Data Diri</h3>
                    
                    <div>
                        <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">NAMA LENGKAP</label>
                        <input type="text" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium" placeholder="Masukkan nama Anda">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">NOMOR WHATSAPP</label>
                        <input type="text" name="phone" value="{{ Auth::check() ? Auth::user()->phone_number : '' }}" required class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium" placeholder="08...">
                    </div>
                </div>

                <!-- Info Booking -->
                <div class="space-y-6">
                    <h3 class="text-xl font-bold font-display uppercase tracking-widest text-white border-b border-white/10 pb-3">Detail Sewa</h3>

                    <div>
                        <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">PILIH KONSOL</label>
                        <div x-data="{ openDropdown: false }" class="relative">
                            <div @click="openDropdown = !openDropdown" @click.away="openDropdown = false" class="w-full bg-slate-900/80 border border-slate-700 hover:border-blue-500 rounded-xl px-4 py-3 text-white cursor-pointer flex justify-between items-center transition-all shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500" tabindex="0">
                                <div class="flex items-center gap-3 font-bold">
                                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    <span x-text="unit === 'ps5' ? 'PlayStation 5 {{ $stock['ps5'] > 0 ? '('.$stock['ps5'].' Tersedia)' : '(Penuh/Habis)' }}' : (unit === 'ps4' ? 'PlayStation 4 Pro {{ $stock['ps4'] > 0 ? '('.$stock['ps4'].' Tersedia)' : '(Penuh/Habis)' }}' : 'PlayStation 3 Retro {{ $stock['ps3'] > 0 ? '('.$stock['ps3'].' Tersedia)' : '(Penuh/Habis)' }}')"></span>
                                </div>
                                <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="{'rotate-180': openDropdown}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                            
                            <div x-show="openDropdown" x-transition.opacity.duration.200ms class="absolute z-50 w-full mt-2 bg-slate-800 border border-slate-600 rounded-xl shadow-2xl overflow-hidden" style="display: none;">
                                <div @click="unit = 'ps5'; openDropdown = false" class="px-4 py-3 hover:bg-blue-600 cursor-pointer transition-colors flex items-center gap-3 border-b border-slate-700/50" :class="unit === 'ps5' ? 'bg-blue-600/50 text-white' : 'text-slate-300'">
                                    <span class="font-bold">PlayStation 5</span>
                                    <span class="text-xs px-2 py-1 rounded-full ml-auto {{ $stock['ps5'] > 0 ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">{{ $stock['ps5'] > 0 ? $stock['ps5'].' Tersedia' : 'Penuh/Habis' }}</span>
                                </div>
                                <div @click="unit = 'ps4'; openDropdown = false" class="px-4 py-3 hover:bg-blue-600 cursor-pointer transition-colors flex items-center gap-3 border-b border-slate-700/50" :class="unit === 'ps4' ? 'bg-blue-600/50 text-white' : 'text-slate-300'">
                                    <span class="font-bold">PlayStation 4 Pro</span>
                                    <span class="text-xs px-2 py-1 rounded-full ml-auto {{ $stock['ps4'] > 0 ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">{{ $stock['ps4'] > 0 ? $stock['ps4'].' Tersedia' : 'Penuh/Habis' }}</span>
                                </div>
                                <div @click="unit = 'ps3'; openDropdown = false" class="px-4 py-3 hover:bg-blue-600 cursor-pointer transition-colors flex items-center gap-3" :class="unit === 'ps3' ? 'bg-blue-600/50 text-white' : 'text-slate-300'">
                                    <span class="font-bold">PlayStation 3 Retro</span>
                                    <span class="text-xs px-2 py-1 rounded-full ml-auto {{ $stock['ps3'] > 0 ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">{{ $stock['ps3'] > 0 ? $stock['ps3'].' Tersedia' : 'Penuh/Habis' }}</span>
                                </div>
                            </div>
                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="unit" :value="unit">
                        </div>
                        <!-- Harga Dinamis Muncul Langsung Saat Dipilih -->
                        <div class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 text-sm font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span x-text="'Harga: Rp ' + getRate().toLocaleString('id-ID') + (rental_type === 'bawa_pulang' ? ' / Hari' : ' / Jam')"></span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">TIPE SEWA</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="rental_type" x-model="rental_type" value="main_di_tempat" class="hidden peer">
                                <div class="p-3 border border-white/10 rounded-xl text-center font-bold text-slate-400 peer-checked:bg-blue-600/20 peer-checked:text-blue-400 peer-checked:border-blue-500 transition-all text-sm">
                                    Main di Tempat
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="rental_type" x-model="rental_type" value="bawa_pulang" class="hidden peer">
                                <div class="p-3 border border-white/10 rounded-xl text-center font-bold text-slate-400 peer-checked:bg-purple-600/20 peer-checked:text-purple-400 peer-checked:border-purple-500 transition-all text-sm">
                                    Bawa Pulang (Harian)
                                </div>
                            </label>
                        </div>
                        
                        <!-- Warning Box untuk Bawa Pulang -->
                        <div x-show="rental_type === 'bawa_pulang'" x-transition class="mt-4 p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/30">
                            <div class="flex gap-3">
                                <svg class="w-6 h-6 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <div>
                                    <h4 class="text-yellow-500 font-bold text-sm">Persyaratan Wajib (Bawa Pulang)</h4>
                                    <p class="text-yellow-400/80 text-xs mt-1">Penyewa wajib menyerahkan Asli e-KTP dan STNK Motor saat pengambilan konsol sebagai jaminan keamanan mesin.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">WAKTU MULAI</label>
                            <input type="datetime-local" x-ref="startTime" name="start_time" @change="hasTouchedTime = true" required style="color-scheme: dark;" class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">DURASI <span x-text="rental_type === 'bawa_pulang' ? '(HARI)' : '(JAM)'" translate="no"></span></label>
                            <div class="relative flex items-center">
                                <button type="button" @click="if(duration > 1) duration--" class="absolute left-2 w-8 h-8 flex items-center justify-center bg-slate-800 hover:bg-slate-700 rounded-md text-slate-300 transition-colors border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                </button>
                                <input type="number" name="duration" required x-model.number="duration" min="1" max="24" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-12 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-bold text-center text-lg shadow-inner" style="-moz-appearance: textfield;">
                                <button type="button" @click="if(duration < 24) duration++" class="absolute right-2 w-8 h-8 flex items-center justify-center bg-slate-800 hover:bg-slate-700 rounded-md text-slate-300 transition-colors border border-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </button>
                            </div>
                            <style>
                                input[type="number"]::-webkit-inner-spin-button, 
                                input[type="number"]::-webkit-outer-spin-button { 
                                    -webkit-appearance: none; 
                                    margin: 0; 
                                }
                            </style>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metode Pembayaran & Promo -->
            <div class="space-y-4 mb-8">
                <h3 class="text-sm font-bold font-display uppercase tracking-widest text-slate-400 border-b border-white/10 pb-2">Metode & Promo Pembayaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" x-model="payment_method" value="otomatis" class="hidden peer">
                        <div class="p-4 border border-white/10 rounded-xl text-center font-bold text-slate-400 peer-checked:bg-blue-600/20 peer-checked:text-blue-400 peer-checked:border-blue-500 transition-all">
                            Bayar Online (Otomatis)
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" x-model="payment_method" value="cash" class="hidden peer">
                        <div class="p-4 border border-white/10 rounded-xl text-center font-bold text-slate-400 peer-checked:bg-green-500/20 peer-checked:text-green-400 peer-checked:border-green-500 transition-all">
                            Bayar di Tempat
                        </div>
                    </label>
                </div>
                
                <div x-show="payment_method === 'otomatis'" x-transition class="mb-6 bg-slate-900/80 border border-blue-500/30 rounded-2xl p-6 text-center shadow-[0_0_30px_rgba(59,130,246,0.15)] mx-auto relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-400 via-indigo-500 to-blue-400"></div>
                    <h4 class="text-white font-black text-lg mb-2 font-display tracking-wide mt-2 flex justify-center items-center gap-2">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Sistem Pembayaran Canggih
                    </h4>
                    <p class="text-sm text-slate-300">Anda dapat memilih QRIS, Virtual Account (BCA, Mandiri, dll), atau E-Wallet di halaman selanjutnya setelah menekan tombol "Pesan". Status akan otomatis LUNAS.</p>
                </div>
                
                @if(isset($promos) && count($promos) > 0)
                <div class="mb-4 bg-slate-900/80 border border-yellow-500/30 rounded-xl p-4 shadow-inner">
                    <h4 class="text-yellow-400 font-bold mb-3 font-display flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Promo Tersedia Hari Ini (Klik untuk Pakai)
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($promos as $promo)
                        @if($promo->is_active)
                        <button type="button" @click="promo_code = '{{ $promo->code }}'" class="text-xs bg-yellow-500/10 hover:bg-yellow-500/30 text-yellow-300 border border-yellow-500/40 px-3 py-2 rounded-lg font-bold transition-colors cursor-pointer text-left">
                            <span class="block text-[10px] text-yellow-400/70 mb-0.5">{{ $promo->description ?? 'Diskon Spesial' }}</span>
                            {{ $promo->code }} <span class="text-white">(-Rp{{ number_format($promo->discount_amount, 0, ',', '.') }})</span>
                        </button>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div>
                    <input type="text" x-model="promo_code" name="promo_code" placeholder="Punya Kode Promo? (Opsional)" class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-all font-medium text-center tracking-widest text-yellow-300 uppercase">
                    
                    <div x-show="isPromoValid()" x-transition class="mt-3 flex items-center justify-center gap-2 bg-green-500/20 border border-green-500/30 text-green-400 py-2 rounded-lg text-sm font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Kode Promo Tersedia! (Potongan Rp <span x-text="getDiscount().toLocaleString('id-ID')"></span>)</span>
                    </div>
                    
                    <div x-show="promo_error !== '' && !isPromoValid()" x-transition class="mt-3 flex items-center justify-center gap-2 bg-red-500/20 border border-red-500/30 text-red-400 py-2 px-4 rounded-lg text-xs font-bold text-center leading-relaxed">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span x-text="promo_error"></span>
                    </div>
                </div>
            </div>

            <!-- Total Pembayaran -->
            <div class="bg-gradient-to-r from-blue-900/20 to-slate-900/50 border border-blue-500/30 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between mt-8 mb-8 backdrop-blur-md">
                <div class="w-full md:w-auto mb-4 md:mb-0">
                    <h4 class="text-blue-300 font-bold uppercase tracking-widest text-sm font-display mb-3 border-b border-white/10 pb-2">Rincian Pembayaran</h4>
                    
                    <div class="space-y-1 mb-4 text-sm font-medium">
                        <div class="flex justify-between gap-8 text-slate-400">
                            <span>Tarif Konsol <span x-text="rental_type === 'bawa_pulang' ? '(Harian)' : '(Per Jam)'" translate="no" class="notranslate"></span></span>
                            <span>Rp <span x-text="getRate().toLocaleString('id-ID')"></span></span>
                        </div>
                        <div class="flex justify-between gap-8 text-slate-300">
                            <span>Subtotal (<span x-text="duration"></span> <span x-text="rental_type === 'bawa_pulang' ? 'Hari' : 'Jam'" translate="no" class="notranslate"></span>)</span>
                            <span>Rp <span x-text="(getRate() * duration).toLocaleString('id-ID')"></span></span>
                        </div>
                        <div class="flex justify-between gap-8 text-green-400" x-show="getDiscount() > 0">
                            <span>Klaim Promo</span>
                            <span>- Rp <span x-text="getDiscount().toLocaleString('id-ID')"></span></span>
                        </div>
                    </div>

                    <p class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400 mt-1 font-display border-t border-white/10 pt-2">
                        Rp <span x-text="calculateTotal().toLocaleString('id-ID')"></span>
                    </p>
                </div>
                <div class="text-right mt-4 md:mt-0 text-sm md:text-right w-full md:w-auto">
                    <button type="submit" class="w-full md:w-auto neon-button font-display font-bold py-4 px-10 text-lg uppercase tracking-wider flex items-center justify-center gap-2">
                        Konfirmasi Pesanan
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
