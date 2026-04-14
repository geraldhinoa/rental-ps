@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-8 relative">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-display font-black text-white mb-3 uppercase tracking-wider">Formulir <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Pemesanan</span></h1>
        <p class="text-slate-400 font-medium">Pesan mesin konsol idaman Anda dengan mudah, cepat, dan tanpa ribet.</p>
    </div>

    <div class="glass-panel p-8 md:p-10 rounded-[2rem] relative overflow-hidden border border-white/10"
         x-data="{ 
            showReceipt: false,
            unit: 'ps5', 
            rental_type: 'main_di_tempat',
            duration: 1, 
            payment_method: 'qris',
            promo_code: '{{ request('promo') }}',
            promo_error: '',
            promos: @js($promos ?? []),
            customerName: '',
            customerPhone: '',
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
            getUnitName() {
                if(this.unit === 'ps5') return 'PlayStation 5';
                if(this.unit === 'ps4') return 'PlayStation 4 Pro';
                return 'PlayStation 3 Retro';
            },
            getPaymentName() {
                if(this.payment_method === 'qris') return 'QRIS (E-Wallet)';
                if(this.payment_method === 'transfer') return 'Transfer Bank';
                return 'Bayar di Tempat';
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
            },
            generateReceiptId() {
                return 'GZ-' + Math.floor(1000 + Math.random() * 9000) + '-' + new Date().getFullYear();
            }
        }" x-init="init()">
        
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-blue-600/20 rounded-full blur-[60px] pointer-events-none"></div>

        <form action="/booking" method="POST" id="bookingForm" class="relative z-10">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-6">
                    <h3 class="text-xl font-bold font-display uppercase tracking-widest text-white border-b border-white/10 pb-3">Data Diri</h3>
                    
                    <div>
                        <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">NAMA LENGKAP</label>
                        <input type="text" name="name" x-model="customerName" required class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium" placeholder="Masukkan nama Anda">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">NOMOR WHATSAPP</label>
                        <input type="text" name="phone" x-model="customerPhone" required class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium" placeholder="08...">
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-xl font-bold font-display uppercase tracking-widest text-white border-b border-white/10 pb-3">Detail Sewa</h3>

                    <div>
                        <label class="block text-sm font-bold tracking-wide text-slate-400 mb-2">PILIH KONSOL</label>
                        <select name="unit" x-model="unit" class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all appearance-none font-bold">
                            <option value="ps5">PlayStation 5</option>
                            <option value="ps4">PlayStation 4 Pro</option>
                            <option value="ps3">PlayStation 3 Retro</option>
                        </select>
                        <div class="mt-3 inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 text-sm font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08-.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
                        
                        <div x-show="rental_type === 'bawa_pulang'" x-transition class="mt-4 p-4 rounded-xl bg-yellow-500/10 border border-yellow-500/30">
                            <div class="flex gap-3">
                                <svg class="w-6 h-6 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <div>
                                    <h4 class="text-yellow-500 font-bold text-sm">Persyaratan Wajib (Bawa Pulang)</h4>
                                    <p class="text-yellow-400/80 text-xs mt-1">Penyewa wajib menyerahkan Asli e-KTP dan STNK Motor saat pengambilan konsol.</p>
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

            <div class="space-y-4 mb-8">
                <h3 class="text-sm font-bold font-display uppercase tracking-widest text-slate-400 border-b border-white/10 pb-2">Metode & Promo Pembayaran</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" x-model="payment_method" value="qris" class="hidden peer">
                        <div class="p-4 border border-white/10 rounded-xl text-center font-bold text-slate-400 peer-checked:bg-blue-600/20 peer-checked:text-blue-400 peer-checked:border-blue-500 transition-all shadow-sm">
                            QRIS (E-Wallet)
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" x-model="payment_method" value="transfer" class="hidden peer">
                        <div class="p-4 border border-white/10 rounded-xl text-center font-bold text-slate-400 peer-checked:bg-blue-600/20 peer-checked:text-blue-400 peer-checked:border-blue-500 transition-all shadow-sm">
                            Transfer Bank
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" x-model="payment_method" value="cash" class="hidden peer">
                        <div class="p-4 border border-white/10 rounded-xl text-center font-bold text-slate-400 peer-checked:bg-green-500/20 peer-checked:text-green-400 peer-checked:border-green-500 transition-all shadow-sm">
                            Bayar di Tempat
                        </div>
                    </label>
                </div>

                <div x-show="payment_method === 'qris'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="bg-blue-900/10 border border-blue-500/30 rounded-[1.5rem] p-6 text-center shadow-lg relative overflow-hidden mb-6" style="display: none;">
                    
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
                    <p class="text-slate-300 mb-4 font-medium text-sm z-10 relative">Scan QR Code di bawah menggunakan <span class="font-bold text-white">Gopay, OVO, DANA, ShopeePay</span> atau M-Banking Anda.</p>
                    
                    <div class="inline-block p-3 bg-white rounded-2xl shadow-[0_0_20px_rgba(255,255,255,0.1)] mb-4 relative z-10">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=PembayaranRentalGAMEZONE" alt="QRIS Gamezone" class="w-48 h-48 object-cover rounded-xl">
                    </div>
                </div>

                <div x-show="payment_method === 'transfer'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     class="space-y-4 mb-6" style="display: none;">
                    
                    <div class="bg-slate-900/60 border border-white/10 hover:border-blue-500/50 transition-colors rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between group gap-4">
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <div class="w-16 h-10 bg-white rounded-lg flex items-center justify-center p-1 shrink-0">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA" class="w-full h-auto">
                            </div>
                            <div class="text-left">
                                <p class="text-white font-black tracking-wider text-lg font-display">1234 5678 90</p>
                                <p class="text-slate-400 text-xs font-medium uppercase">A.N Gamezone Rental</p>
                            </div>
                        </div>
                        <button type="button" onclick="navigator.clipboard.writeText('1234567890'); alert('Nomor Rekening BCA Tersalin!');" class="w-full sm:w-auto px-6 py-2 bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white rounded-xl text-sm font-bold transition-colors border border-blue-500/30">
                            Salin
                        </button>
                    </div>

                    <div class="bg-slate-900/60 border border-white/10 hover:border-yellow-500/50 transition-colors rounded-2xl p-4 flex flex-col sm:flex-row items-center justify-between group gap-4">
                        <div class="flex items-center gap-4 w-full sm:w-auto">
                            <div class="w-16 h-10 bg-white rounded-lg flex items-center justify-center p-1 shrink-0">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri" class="w-full h-auto">
                            </div>
                            <div class="text-left">
                                <p class="text-white font-black tracking-wider text-lg font-display">0987 6543 21</p>
                                <p class="text-slate-400 text-xs font-medium uppercase">A.N Gamezone Rental</p>
                            </div>
                        </div>
                        <button type="button" onclick="navigator.clipboard.writeText('0987654321'); alert('Nomor Rekening Mandiri Tersalin!');" class="w-full sm:w-auto px-6 py-2 bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white rounded-xl text-sm font-bold transition-colors border border-blue-500/30">
                            Salin
                        </button>
                    </div>
                </div>
                
                <div class="pt-4">
                    <input type="text" x-model="promo_code" name="promo_code" placeholder="Punya Kode Promo? (Opsional)" class="w-full bg-slate-900/60 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-yellow-500 focus:ring-1 focus:ring-yellow-500 transition-all font-medium text-center tracking-widest text-yellow-300 uppercase">
                    
                    <div x-show="isPromoValid()" x-transition class="mt-3 flex items-center justify-center gap-2 bg-green-500/20 border border-green-500/30 text-green-400 py-2 rounded-lg text-sm font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Kode Promo Tersedia! (Potongan Rp <span x-text="getDiscount().toLocaleString('id-ID')"></span>)</span>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-blue-900/20 to-slate-900/50 border border-blue-500/30 rounded-2xl p-6 flex flex-col md:flex-row items-center justify-between mt-8 mb-8 backdrop-blur-md">
                <div class="w-full md:w-auto mb-4 md:mb-0">
                    <h4 class="text-blue-300 font-bold uppercase tracking-widest text-sm font-display mb-3 border-b border-white/10 pb-2">Rincian Total</h4>
                    <p class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400 mt-1 font-display">
                        Rp <span x-text="calculateTotal().toLocaleString('id-ID')"></span>
                    </p>
                </div>
                <div class="text-right mt-4 md:mt-0 w-full md:w-auto">
                    <button type="button" @click="if(document.getElementById('bookingForm').checkValidity()) { showReceipt = true } else { document.getElementById('bookingForm').reportValidity() }" class="w-full md:w-auto neon-button font-display font-bold py-4 px-10 text-lg uppercase tracking-wider flex items-center justify-center gap-2 border border-blue-500 rounded-xl bg-blue-600/20 hover:bg-blue-600 text-white transition-all shadow-[0_0_20px_rgba(59,130,246,0.3)]">
                        Buat Pesanan & Struk
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

        </form>

        <div x-show="showReceipt" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 backdrop-blur-none"
             x-transition:enter-end="opacity-100 backdrop-blur-sm"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 backdrop-blur-sm"
             x-transition:leave-end="opacity-0 backdrop-blur-none"
             class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 p-4" style="display: none;">
            
            <div @click.away="showReceipt = false" class="bg-white rounded-xl w-full max-w-sm shadow-2xl overflow-hidden flex flex-col relative"
                 x-transition:enter="transition ease-out duration-300 delay-100"
                 x-transition:enter-start="opacity-0 transform translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 transform translate-y-0 scale-100">
                
                <div class="absolute top-0 left-0 right-0 h-3 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMCIgaGVpZ2h0PSIxMCI+PHBhdGggZD0iTTAgMTBMNSAwTDEwIDEwWSIgZmlsbD0iIzBmMTcyYSIvPjwvc3ZnPg==')]"></div>

                <div class="p-8 pt-10 text-slate-800" id="printArea">
                    <div class="text-center mb-6">
                        <h2 class="font-black text-2xl font-display uppercase tracking-widest text-slate-900">GAMEZONE</h2>
                        <p class="text-xs text-slate-500 font-medium">Rental Console Premium</p>
                        <p class="text-xs text-slate-500">Jl. Watu Kandang, Lumajang</p>
                    </div>

                    <div class="border-b-2 border-dashed border-slate-300 mb-4"></div>

                    <div class="space-y-2 text-sm font-medium mb-4">
                        <div class="flex justify-between">
                            <span class="text-slate-500">No. Pesanan:</span>
                            <span class="font-bold font-display" x-text="generateReceiptId()"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Pelanggan:</span>
                            <span class="font-bold capitalize" x-text="customerName || '-'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Metode:</span>
                            <span class="font-bold" x-text="getPaymentName()"></span>
                        </div>
                    </div>

                    <div class="border-b-2 border-dashed border-slate-300 mb-4"></div>

                    <div class="space-y-3 mb-4">
                        <div>
                            <p class="font-bold text-slate-800" x-text="getUnitName()"></p>
                            <p class="text-xs text-slate-500" x-text="'Tipe: ' + (rental_type === 'bawa_pulang' ? 'Bawa Pulang' : 'Main di Tempat')"></p>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500" x-text="duration + (rental_type === 'bawa_pulang' ? ' Hari' : ' Jam') + ' x Rp ' + getRate().toLocaleString('id-ID')"></span>
                            <span class="font-bold" x-text="'Rp ' + (getRate() * duration).toLocaleString('id-ID')"></span>
                        </div>

                        <div x-show="getDiscount() > 0" class="flex justify-between text-sm text-green-600">
                            <span>Diskon Promo</span>
                            <span class="font-bold" x-text="'- Rp ' + getDiscount().toLocaleString('id-ID')"></span>
                        </div>
                    </div>

                    <div class="border-b-2 border-slate-800 mb-4"></div>

                    <div class="flex justify-between items-end mb-8">
                        <span class="font-bold text-slate-800 uppercase tracking-wider">Total</span>
                        <span class="font-black text-2xl font-display text-slate-900" x-text="'Rp ' + calculateTotal().toLocaleString('id-ID')"></span>
                    </div>

                    <div class="text-center">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=GAMEZONE-LUMAJANG" alt="Barcode" class="mx-auto mb-2 opacity-80 w-20 h-20">
                        <p class="text-xs text-slate-400 font-medium">Terima kasih telah menyewa di Gamezone!</p>
                        <p class="text-[10px] text-slate-400 mt-1">Simpan struk ini sebagai bukti pesanan Anda.</p>
                    </div>
                </div>

                <div class="bg-slate-100 p-4 flex gap-3">
                    <button type="button" @click="window.print()" class="flex-1 bg-white border border-slate-300 text-slate-700 font-bold py-3 rounded-lg text-sm hover:bg-slate-50 transition-colors">
                        🖨️ Cetak / PDF
                    </button>
                    <button type="button" @click="document.getElementById('bookingForm').submit()" class="flex-1 bg-blue-600 text-white font-bold py-3 rounded-lg text-sm hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/30">
                        Selesai & Bayar
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
/* Style tambahan agar pop-up struk bisa dicetak rapi */
@media print {
    body * {
        visibility: hidden;
    }
    #printArea, #printArea * {
        visibility: visible;
    }
    #printArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 20px;
    }
    .glass-panel {
        display: none !important;
    }
}
</style>
@endsection