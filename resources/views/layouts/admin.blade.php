<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
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
            <a href="/admin/dashboard" class="flex items-center gap-3 px-4 py-3 bg-blue-600/10 text-ps-neon rounded-lg font-medium border border-blue-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="/admin/bookings" class="flex items-center justify-between px-4 py-3 hover:bg-slate-800/50 rounded-lg font-medium transition text-slate-400 hover:text-slate-200 group">
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
            <a href="/admin/inventory" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-800/50 rounded-lg font-medium transition text-slate-400 hover:text-slate-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Inventaris Mesin
            </a>
            <a href="/admin/customers" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-800/50 rounded-lg font-medium transition text-slate-400 hover:text-slate-200">
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
                <div x-data="{ open: false }" class="relative">
                    <div @click="open = !open" class="h-8 w-8 rounded-full bg-slate-800 border border-slate-700 items-center justify-center flex hover:bg-slate-700 cursor-pointer transition">
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        
                        <!-- Notification indicator ping -->
                        @if(\App\Models\Booking::where('status', 'pending')->exists())
                        <span class="absolute top-0 right-0 flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        @endif
                    </div>
                    
                    <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 mt-2 w-72 bg-slate-800 border border-slate-700 rounded-xl shadow-xl z-50 overflow-hidden text-sm">
                        <div class="px-4 py-3 border-b border-slate-700 bg-slate-800/50">
                            <h3 class="font-bold text-white">Notifikasi</h3>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            @php $recentBookings = \App\Models\Booking::where('status', 'pending')->latest()->take(3)->get(); @endphp
                            @forelse($recentBookings as $b)
                            <a href="/admin/dashboard" class="block px-4 py-3 hover:bg-slate-700/50 border-b border-slate-700/50 transition">
                                <p class="text-white font-medium mb-1">Pesanan Baru: {{ $b->user->name ?? 'Guest' }}</p>
                                <p class="text-slate-400 text-xs">Butuh konfirmasi! TRX-0{{ $b->id * 100 }}</p>
                            </a>
                            @empty
                            <div class="px-4 py-6 text-center text-slate-500">Belum ada notifikasi baru.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </div>
    </main>

    <!-- Real-time Polling Engine Simulator -->
    <script>
        // Simulate real-time dashboard updates every 20 seconds
        let countdown = 20;
        setInterval(() => {
            countdown--;
            if(countdown <= 0) {
                // Flash effect before reload
                document.body.style.opacity = '0.7';
                setTimeout(() => window.location.reload(), 300);
            }
        }, 1000);
    </script>
</body>
</html>
