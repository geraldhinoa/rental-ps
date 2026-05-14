<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - PS Rental</title>
    
    <!-- Gamer Fonts Upgrade -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine.js & Tailwind CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    
    
    <script>
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {
            fontFamily: {
              display: ['Poppins', 'sans-serif'],
              body: ['Inter', 'sans-serif'],
            },
            colors: {
              'ps-bg': '#030712', 
              'ps-surface': '#0f172a',
              'ps-neon': '#3b82f6',
              'ps-flare': '#8b5cf6',
              'ps-accent': '#06b6d4',
            }
          }
        }
      }
    </script>
    <style>
      .glass-panel {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.05);
      }
    </style>
</head>
<body class="bg-[#020617] text-slate-300 font-body flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 glass-panel border-r-0 border-slate-800 flex flex-col z-20 shrink-0">
        <div class="h-20 flex items-center justify-center border-b border-slate-800">
            <span class="font-display font-bold text-xl text-white">Admin<span class="text-ps-neon">Panel</span></span>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium border transition-all {{ request()->is('admin/dashboard') ? 'bg-blue-600/10 text-ps-neon border-blue-500/20' : 'border-transparent text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="/admin/bookings" class="flex items-center justify-between px-4 py-3 rounded-lg font-medium transition-all group border {{ request()->is('admin/bookings*') ? 'bg-blue-600/10 text-ps-neon border-blue-500/20' : 'border-transparent text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Kelola Pesanan
                </div>
                <!-- Real-time Badge -->
                <span class="flex h-3 w-3 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                </span>
            </a>
            <a href="/admin/inventory" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium border transition-all {{ request()->is('admin/inventory*') ? 'bg-blue-600/10 text-ps-neon border-blue-500/20' : 'border-transparent text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Inventaris Mesin
            </a>
            <a href="/admin/promos" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium border transition-all {{ request()->is('admin/promos*') ? 'bg-blue-600/10 text-ps-neon border-blue-500/20' : 'border-transparent text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                Kelola Promo
            </a>
            <a href="/admin/customers" class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium border transition-all {{ request()->is('admin/customers*') ? 'bg-blue-600/10 text-ps-neon border-blue-500/20' : 'border-transparent text-slate-400 hover:text-slate-200 hover:bg-slate-800/50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m5 0v-5m0 0v-5m0 5H7m5-5H7"/></svg>
                Pelanggan
            </a>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <div class="flex items-center gap-3 px-4 py-2">
                <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center font-bold text-white">A</div>
                <div class="text-sm">
                    <p class="text-white font-medium capitalize">{{ Auth::check() ? Auth::user()->name : 'Administrator' }}</p>
                    <a href="/logout" class="text-slate-500 text-xs hover:text-red-400 transition">Keluar</a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Topbar -->
        <header class="h-20 glass-panel border-l-0 border-t-0 border-r-0 border-slate-800 flex items-center justify-between px-8 z-10">
            <h2 class="text-lg font-semibold text-white">Ringkasan Hari Ini</h2>
            <div class="flex items-center gap-4">
                <p class="text-sm text-slate-400">{{ date('d M Y') }}</p>
                <div x-data="notificationSystem()" class="relative">
                    <audio x-ref="notificationSound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>
                    
                    <div @click="open = !open; unread = 0" class="h-8 w-8 rounded-full bg-slate-800 border border-slate-700 items-center justify-center flex hover:bg-slate-700 cursor-pointer transition relative">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        
                        <!-- Notification indicator ping -->
                        <span x-show="count > 0 || unread > 0" x-transition style="display: none;" class="absolute -top-1 -right-1 flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-[#020617]"></span>
                        </span>
                    </div>
                    
                    <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 mt-2 w-72 bg-slate-800 border border-slate-700 rounded-xl shadow-xl z-50 overflow-hidden text-sm">
                        <div class="px-4 py-3 border-b border-slate-700 bg-slate-800/50 flex justify-between items-center">
                            <h3 class="font-bold text-white">Notifikasi</h3>
                            <span class="text-[10px] bg-red-500 text-white px-2 py-0.5 rounded font-bold" x-show="count > 0" x-text="count + ' Baru'"></span>
                        </div>
                        <div class="max-h-[300px] overflow-y-auto">
                            <template x-for="b in bookings" :key="b.id">
                                <a href="/admin/bookings" class="block px-4 py-3 hover:bg-slate-700/50 border-b border-slate-700/50 transition">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-white font-bold text-sm truncate max-w-[120px]" x-text="b.name"></span>
                                        <span class="bg-indigo-500/20 text-indigo-300 text-[10px] px-2 py-0.5 rounded font-bold border border-indigo-500/30 uppercase tracking-wider whitespace-nowrap" x-text="b.type"></span>
                                    </div>
                                    <p class="text-slate-400 text-xs">Butuh konfirmasi! <span x-text="b.trx"></span></p>
                                    <p class="text-slate-500 text-[10px] mt-1" x-text="b.time"></p>
                                </a>
                            </template>
                            <div x-show="bookings.length === 0" class="px-4 py-6 text-center text-slate-500">Belum ada pesanan pending.</div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8" id="admin-scroll-area">
            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('notificationSystem', () => ({
                open: false,
                count: 0,
                unread: 0,
                bookings: [],
                init() {
                    // Fetch initial data
                    this.fetchData(false);
                    // Poll every 10 seconds
                    setInterval(() => {
                        this.fetchData(true);
                    }, 10000); 
                },
                fetchData(playAlert) {
                    fetch('/admin/api/notifications')
                        .then(res => res.json())
                        .then(data => {
                            if(data.count > this.count && playAlert) {
                                // New booking arrived!
                                this.unread += (data.count - this.count);
                                // Play sound
                                try {
                                    this.$refs.notificationSound.play();
                                } catch(e) {}
                                
                                // Show browser notification
                                if (Notification.permission === 'granted') {
                                    new Notification('GAMEZONE: Pesanan Baru!', {
                                        body: 'Ada pesanan masuk baru yang butuh konfirmasi. Segera cek!',
                                    });
                                } else if (Notification.permission !== 'denied') {
                                    Notification.requestPermission();
                                }
                            }
                            this.count = data.count;
                            this.bookings = data.bookings;
                        });
                }
            }));
        });
    </script>
    
    
    <script>
        document.addEventListener("DOMContentLoaded", function() { 
            var scrollArea = document.getElementById('admin-scroll-area');
            if (scrollArea) {
                // Pulihkan posisi scroll jika ada di localStorage
                var scrollpos = localStorage.getItem('adminScrollPos');
                if (scrollpos) {
                    scrollArea.scrollTop = scrollpos;
                }

                // Simpan posisi scroll sebelum halaman di-reload/ditinggalkan
                window.addEventListener('beforeunload', function() {
                    localStorage.setItem('adminScrollPos', scrollArea.scrollTop);
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
