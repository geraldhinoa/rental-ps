@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-display font-black text-white mb-3 uppercase tracking-wider">Formulir <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Pemesanan</span></h1>
        <p class="text-slate-400 font-medium">Pesan mesin konsol idaman Anda dengan mudah, cepat, dan tanpa ribet.</p>
    </div>

    <div class="glass-panel p-8 md:p-10 rounded-[2rem] relative overflow-hidden border border-white/10">
        <!-- Decorative blob -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-blue-600/20 rounded-full blur-[60px]"></div>

        <form action="/booking" method="POST" class="relative z-10" x-data="{ 
            unit: 'ps5', 
            rental_type: 'main_di_tempat',
            duration: 1, 
            payment_method: 'qris',
            promo_code: '{{ request('promo') }}',
            promo_error: '',
            promos: @js($promos ?? []),
            init() {
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <!-- Data Pemesan -->
                <div class="space-y-6">
                    <h3 class="text-xl font-bold font-display uppercase tracking-widest text-white border-b border-white/10 pb-3">Data Diri</h3>
                    
                    <div>
                        <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">NAMA LENGKAP</label>
                        <input type="text" name="name" required class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium" placeholder="Masukkan nama Anda">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">NOMOR WHATSAPP</label>
                        <input type="text" name="phone" required class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium" placeholder="08...">
                    </div>
                </div>

                <!-- Info Booking -->
                <div class="space-y-6">
                    <h3 class="text-xl font-bold font-display uppercase tracking-widest text-white border-b border-white/10 pb-3">Detail Sewa</h3>

                    <div>
                        <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">PILIH KONSOL</label>
                        <select name="unit" x-model="unit" class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all appearance-none font-bold">
                            <option value="ps5">PlayStation 5</option>
                            <option value="ps4">PlayStation 4 Pro</option>
                            <option value="ps3">PlayStation 3 Retro</option>
                        </select>
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

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">WAKTU MULAI</label>
                            <input type="datetime-local" x-ref="startTime" name="start_time" required class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-3 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">DURASI <span x-text="rental_type === 'bawa_pulang' ? '(HARI)' : '(JAM)'" translate="no"></span></label>
                            <input type="number" name="duration" required x-model.number="duration" min="1" max="24" class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-bold text-center">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metode Pembayaran & Promo -->
            <div class="space-y-4 mb-8">
                <h3 class="text-sm font-bold font-display uppercase tracking-widest text-slate-400 border-b border-white/10 pb-2">Metode & Promo Pembayaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" x-model="payment_method" value="qris" class="hidden peer">
                        <div class="p-4 border border-white/10 rounded-xl text-center font-bold text-slate-400 peer-checked:bg-blue-600/20 peer-checked:text-blue-400 peer-checked:border-blue-500 transition-all">
                            QRIS (E-Wallet)
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" x-model="payment_method" value="transfer" class="hidden peer">
                        <div class="p-4 border border-white/10 rounded-xl text-center font-bold text-slate-400 peer-checked:bg-blue-600/20 peer-checked:text-blue-400 peer-checked:border-blue-500 transition-all">
                            Transfer Bank
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" x-model="payment_method" value="cash" class="hidden peer">
                        <div class="p-4 border border-white/10 rounded-xl text-center font-bold text-slate-400 peer-checked:bg-green-500/20 peer-checked:text-green-400 peer-checked:border-green-500 transition-all">
                            Bayar di Tempat
                        </div>
                    </label>
                </div>
                
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
