<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel PlayStation Rental') }}</title>
    
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
      body {
        background-color: #030712;
        background-image: 
          radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.15) 0px, transparent 50%),
          radial-gradient(at 100% 100%, rgba(139, 92, 246, 0.15) 0px, transparent 50%);
        background-attachment: fixed;
      }
      .glass-card, .glass-panel {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
      }
      .neon-button {
        background: linear-gradient(45deg, #1d4ed8, #4338ca);
        box-shadow: 0 0 15px rgba(59,130,246,0.6);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 9999px;
      }
    </style>
</head>
<body class="bg-slate-950 text-slate-300 min-h-screen flex flex-col relative overflow-x-hidden">
    <!-- Abstract Ambient Background -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-600/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-600/20 rounded-full blur-[120px]"></div>
    </div>

    <!-- Glassmorphism Navbar -->
    <nav class="fixed w-full z-50 glass-panel border-b-0 border-slate-800" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative w-10 h-10 flex items-center justify-center bg-gradient-to-br from-blue-600 to-indigo-800 rounded-xl shadow-[0_0_15px_rgba(59,130,246,0.6)] group-hover:scale-105 transition duration-300 transform rotate-45">
                        <div class="-rotate-45">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <a href="/" class="font-display font-black text-2xl tracking-wider text-white uppercase ml-1">
                        GAME<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">ZONE</span>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden lg:block">
                    <div class="ml-10 flex items-center space-x-6 translate-y-1">
                        <a href="/#katalog" class="hover:text-blue-400 px-3 py-2 rounded-md text-sm font-bold tracking-wide transition-colors">Katalog Mesin</a>
                        <a href="/booking" class="hover:text-blue-400 px-3 py-2 rounded-md text-sm font-bold tracking-wide transition-colors text-white">Pesan Sekarang</a>
                        <div class="w-px h-5 bg-white/10 mx-2"></div>
                        <a href="/login" class="px-4 py-2 text-sm font-bold text-white hover:text-blue-400 transition-colors">Admin</a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex lg:hidden">
                    <button @click="open = !open" class="text-slate-400 hover:text-white focus:outline-none p-2">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="open ? 'hidden' : 'inline-flex'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path :class="!open ? 'hidden' : 'inline-flex'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="open" x-collapse class="lg:hidden glass-panel border-t border-slate-800">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 text-center">
                <a href="/#katalog" class="block px-3 py-3 rounded-md text-base font-bold text-slate-300 hover:bg-white/5">Katalog Mesin</a>
                <a href="/booking" class="block px-3 py-3 rounded-md text-base font-bold text-blue-400 hover:bg-white/5">Pesan Sekarang</a>
                <a href="/login" class="block px-3 py-3 rounded-md text-base font-bold text-slate-300 hover:bg-white/5">Akses Admin</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-28 pb-12 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-800/80 bg-slate-900/50 backdrop-blur text-sm text-center py-6 mt-auto">
        <p class="text-slate-500 font-display tracking-widest">&copy; {{ date('Y') }} GAMEZONE INC. ALL RIGHTS RESERVED.</p>
    </footer>
    
    <!-- Floating WA Button -->
    <a href="https://wa.me/6281234567890?text=Halo%20GAMEZONE,%20saya%20tertarik%20untuk%20rental%20console!" target="_blank" class="fixed bottom-8 right-8 w-16 h-16 bg-green-500 rounded-full flex items-center justify-center shadow-[0_0_25px_rgba(34,197,94,0.6)] hover:bg-green-400 hover:scale-110 transition-all duration-300 z-50 group">
        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        <span class="absolute right-20 bg-slate-900 text-white px-4 py-2 rounded-xl text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-xl font-display border border-slate-700">Chat Admin Rental</span>
    </a>
</body>
</html>
