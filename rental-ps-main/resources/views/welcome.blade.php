<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GAMEZONE - Rental Console Premium</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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
            },
            animation: {
              'blob': 'blob 7s infinite',
              'float': 'float 6s ease-in-out infinite',
              'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
              'glow-border': 'glow 3s ease-in-out infinite alternate',
            },
            keyframes: {
              blob: {
                '0%': { transform: 'translate(0px, 0px) scale(1)' },
                '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                '100%': { transform: 'translate(0px, 0px) scale(1)' },
              },
              float: {
                '0%, 100%': { transform: 'translateY(0)' },
                '50%': { transform: 'translateY(-20px)' },
              },
              glow: {
                '0%': { borderColor: 'rgba(59, 130, 246, 0.2)', boxShadow: '0 0 10px rgba(59, 130, 246, 0.1)' },
                '100%': { borderColor: 'rgba(59, 130, 246, 0.6)', boxShadow: '0 0 25px rgba(59, 130, 246, 0.4)' },
              }
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
      
      .glass-card {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
      }
      
      .glass-card-hover {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      }
      
      .glass-card-hover:hover {
        background: rgba(30, 41, 59, 0.6);
        border: 1px solid rgba(59, 130, 246, 0.4);
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px -10px rgba(59, 130, 246, 0.3);
      }

      .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-image: linear-gradient(90deg, #60a5fa, #c084fc, #38bdf8);
      }
      
      .premium-btn {
        position: relative;
        overflow: hidden;
        background: linear-gradient(45deg, #1d4ed8, #4338ca);
        transition: all 0.3s ease;
      }
      .premium-btn::before {
        content: '';
        position: absolute;
        top: 0; left: -100%; width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: all 0.5s ease;
      }
      .premium-btn:hover::before {
        left: 100%;
      }
      .premium-btn:hover {
        box-shadow: 0 0 30px rgba(59, 130, 246, 0.8);
        transform: translateY(-2px);
      }
      
      .ps-pattern {
        position: absolute;
        inset: 0;
        opacity: 0.03;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 100 100'%3E%3Cpath d='M20 20h20v20H20zM60 20a10 10 0 110 20 10 10 0 010-20M20 60l10-15 10 15H20M60 50l10 10-10 10-10-10 10-10' fill='%23ffffff' fill-rule='evenodd'/%3E%3C/svg%3E");
        z-index: 0;
        pointer-events: none;
      }

      /* Menyembunyikan scrollbar untuk slider katalog game */
      .hide-scrollbar::-webkit-scrollbar {
        display: none;
      }
      .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
      }
    </style>
</head>
<body class="text-slate-300 font-body antialiased min-h-screen flex flex-col relative overflow-x-hidden selection:bg-ps-neon selection:text-white">
    
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none mix-blend-screen">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-600/30 rounded-full blur-[128px] animate-blob"></div>
        <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-cyan-500/20 rounded-full blur-[128px] animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-1/4 left-1/3 w-[30rem] h-[30rem] bg-indigo-600/20 rounded-full blur-[128px] animate-blob animation-delay-4000"></div>
    </div>

    <nav class="fixed w-full z-50 glass-card border-b border-white/5 transition-all duration-300 backdrop-blur-xl" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="max-w-[90rem] mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative w-12 h-12 flex items-center justify-center bg-gradient-to-br from-blue-600 to-indigo-800 rounded-xl shadow-[0_0_20px_rgba(59,130,246,0.6)] group-hover:scale-105 transition duration-300 transform rotate-45">
                        <div class="-rotate-45">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <span class="font-display font-black text-3xl tracking-wider text-white uppercase ml-2">
                        GAME<span class="text-gradient">ZONE</span>
                    </span>
                </div>
                
                <div class="hidden md:flex items-center space-x-1">
                    <a href="#katalog" class="px-4 py-2 rounded-lg text-sm md:text-base lg:text-lg font-bold text-slate-300 hover:text-white hover:bg-white/5 transition-all">Katalog Mesin</a>
                    <a href="#games" class="px-4 py-2 rounded-lg text-sm md:text-base lg:text-lg font-bold text-slate-300 hover:text-white hover:bg-white/5 transition-all">Daftar Game</a>
                    <a href="/admin/dashboard" class="px-4 py-2 rounded-lg text-sm md:text-base lg:text-lg font-bold text-slate-300 hover:text-white hover:bg-white/5 transition-all">Dasbor Admin</a>
                    <div class="w-px h-6 bg-white/10 mx-2"></div>
                    <a href="/booking" class="ml-3 premium-btn text-white text-sm md:text-base lg:text-lg font-bold py-2.5 px-6 rounded-lg border border-white/10 shadow-lg tracking-wide uppercase font-display whitespace-nowrap">Sewa Sekarang</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-32 pb-20 w-full max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="relative py-16 flex flex-col items-center justify-center text-center z-10">
            <h1 class="text-6xl md:text-7xl lg:text-[5.5rem] font-black text-white mb-6 font-display tracking-tight leading-none uppercase drop-shadow-2xl">
                KUASAI ARENA <br/>
                <span class="text-gradient text-[1.1em] pr-2">GAMEZONE</span>
            </h1>
            
            <p class="text-xl md:text-2xl text-blue-100/70 max-w-2xl mb-12 font-medium leading-relaxed">
                Persenjatai diri Anda dengan unit konsol kondisi prima. PS5, PS4, dan PS3 siap untuk menemani marathon gaming Anda.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-5 items-center justify-center font-display">
                <a href="/booking" class="premium-btn text-white text-xl tracking-wider py-4 px-12 rounded-xl border border-blue-400/20 shadow-[-10px_0_30px_rgba(59,130,246,0.5)] flex items-center gap-3">
                    SEWA SEKARANG
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>

        <div id="katalog" class="mt-16 relative z-10">
            <div class="flex flex-col md:flex-row items-end justify-between mb-12">
                <div>
                    <h2 class="text-cyan-400 font-bold tracking-widest uppercase text-lg mb-1 font-display">Koleksi Kami</h2>
                    <h3 class="text-5xl font-display font-black text-white uppercase drop-shadow-lg">Pilih<span class="text-slate-600"> Konsol</span></h3>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <a href="/booking" class="block glass-card glass-card-hover rounded-3xl p-2 group relative overflow-hidden animate-glow-border cursor-pointer">
                    <div class="ps-pattern"></div>
                    <div class="bg-ps-surface/90 rounded-[1.5rem] p-6 h-full flex flex-col relative z-10 border border-white/5">
                        <div class="absolute -right-16 -top-16 w-32 h-32 bg-blue-500/20 rounded-full blur-[30px] group-hover:bg-blue-500/50 transition duration-500"></div>
                        
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-sm font-bold text-blue-400 font-display uppercase tracking-widest">Generasi Terbaru</h3>
                                <h4 class="text-3xl font-black text-white font-display">PS 5</h4>
                            </div>
                            @if($ps5_available ?? true)
                                <span class="px-3 py-1 bg-green-500/20 text-green-400 text-sm font-bold rounded-lg border border-green-500/30 shadow-[0_0_10px_rgba(34,197,94,0.2)]">Tersedia</span>
                            @else
                                <span class="px-3 py-1 bg-red-500/20 text-red-400 text-sm font-bold rounded-lg border border-red-500/30 shadow-[0_0_10px_rgba(239,68,68,0.2)] animate-pulse">Sedang Disewa</span>
                            @endif
                        </div>
                        
                        <div class="relative mb-6 rounded-2xl overflow-hidden aspect-[4/3] bg-gradient-to-tr from-slate-900 to-blue-900/30">
                            <img src="https://images.unsplash.com/photo-1606813907291-d86efa9b94db?auto=format&fit=crop&w=600&q=80" alt="PS5" class="w-full h-full object-cover mix-blend-screen group-hover:scale-110 transition-transform duration-700">
                        </div>
                        
                        <div class="flex-grow pb-4">
                            <ul class="text-[1.1rem] space-y-2 text-slate-300 font-medium">
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-blue-500"></div> Grafis Nyata (Ray-Tracing)</li>
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-blue-500"></div> Getaran Mantap (DualSense)</li>
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-blue-500"></div> Loading Super Cepat</li>
                            </ul>
                        </div>
                        
                        <div class="pt-4 border-t border-white/10 flex justify-between items-end">
                            <div>
                                <span class="text-sm text-slate-400 font-bold tracking-widest font-display mb-1 block">TARIF / JAM</span>
                                <span class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-cyan-300 font-display">10K</span>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center shadow-[0_0_15px_rgba(59,130,246,0.5)] group-hover:bg-cyan-500 transition-colors">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="/booking" class="block glass-card glass-card-hover rounded-3xl p-2 group relative overflow-hidden cursor-pointer">
                    <div class="ps-pattern"></div>
                    <div class="bg-ps-surface/90 rounded-[1.5rem] p-6 h-full flex flex-col relative z-10 border border-white/5">
                        <div class="absolute -right-16 -top-16 w-32 h-32 bg-purple-500/20 rounded-full blur-[30px] group-hover:bg-purple-500/50 transition duration-500"></div>
                        
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-sm font-bold text-purple-400 font-display uppercase tracking-widest">Pilihan Terpopuler</h3>
                                <h4 class="text-3xl font-black text-white font-display">PS 4</h4>
                            </div>
                            @if($ps4_available ?? true)
                                <span class="px-3 py-1 bg-green-500/20 text-green-400 text-sm font-bold rounded-lg border border-green-500/30 shadow-[0_0_10px_rgba(34,197,94,0.2)]">Tersedia</span>
                            @else
                                <span class="px-3 py-1 bg-red-500/20 text-red-400 text-sm font-bold rounded-lg border border-red-500/30 shadow-[0_0_10px_rgba(239,68,68,0.2)] animate-pulse">Sedang Disewa</span>
                            @endif
                        </div>
                        
                        <div class="relative mb-6 rounded-2xl overflow-hidden aspect-[4/3] bg-gradient-to-tr from-slate-900 to-purple-900/30">
                            <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=600&q=80" alt="PS4" class="w-full h-full object-cover mix-blend-screen group-hover:scale-110 transition-transform duration-700">
                        </div>
                        
                        <div class="flex-grow pb-4">
                            <ul class="text-[1.1rem] space-y-2 text-slate-300 font-medium">
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-purple-500"></div> Visual Tajam (HDR 10)</li>
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-purple-500"></div> Stik DualShock 4</li>
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-purple-500"></div> Pilihan Game Melimpah</li>
                            </ul>
                        </div>
                        
                        <div class="pt-4 border-t border-white/10 flex justify-between items-end">
                            <div>
                                <span class="text-sm text-slate-400 font-bold tracking-widest font-display mb-1 block">TARIF / JAM</span>
                                <span class="text-4xl font-black text-white font-display">6K</span>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-purple-600 flex items-center justify-center group-hover:shadow-[0_0_15px_rgba(168,85,247,0.5)] transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="/booking" class="block glass-card glass-card-hover rounded-3xl p-2 group relative overflow-hidden cursor-pointer">
                    <div class="ps-pattern"></div>
                    <div class="bg-ps-surface/90 rounded-[1.5rem] p-6 h-full flex flex-col relative z-10 border border-white/5">
                        <div class="absolute -right-16 -top-16 w-32 h-32 bg-red-500/10 rounded-full blur-[30px] group-hover:bg-red-500/30 transition duration-500"></div>
                        
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-sm font-bold text-red-400 font-display uppercase tracking-widest">Mesin Nostalgia</h3>
                                <h4 class="text-3xl font-black text-white font-display">PS 3</h4>
                            </div>
                            @if($ps3_available ?? true)
                                <span class="px-3 py-1 bg-green-500/20 text-green-400 text-sm font-bold rounded-lg border border-green-500/30 shadow-[0_0_10px_rgba(34,197,94,0.2)]">Tersedia</span>
                            @else
                                <span class="px-3 py-1 bg-red-500/20 text-red-400 text-sm font-bold rounded-lg border border-red-500/30 shadow-[0_0_10px_rgba(239,68,68,0.2)] animate-pulse">Sedang Disewa</span>
                            @endif
                        </div>
                        
                        <div class="relative mb-6 rounded-2xl overflow-hidden aspect-[4/3] bg-gradient-to-tr from-slate-900 to-red-900/30">
                            <img src="https://images.unsplash.com/photo-1552820728-8b83bb6b773f?auto=format&fit=crop&w=600&q=80" alt="PS3" class="w-full h-full object-cover mix-blend-screen group-hover:scale-110 transition-transform duration-700">
                        </div>
                        
                        <div class="flex-grow pb-4">
                            <ul class="text-[1.1rem] space-y-2 text-slate-300 font-medium">
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-red-500"></div> Cocok Buat Nostalgia</li>
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-red-500"></div> Seru Main Bareng Teman</li>
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-red-500"></div> Harga Paling Bersahabat</li>
                            </ul>
                        </div>
                        
                        <div class="pt-4 border-t border-white/10 flex justify-between items-end">
                            <div>
                                <span class="text-sm text-slate-400 font-bold tracking-widest font-display mb-1 block">TARIF / JAM</span>
                                <span class="text-4xl font-black text-white font-display">4K</span>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-red-600 flex items-center justify-center group-hover:shadow-[0_0_15px_rgba(239,68,68,0.5)] transition-shadow">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </div>
                    </div>
                </a>

                <div class="glass-card rounded-3xl p-2 text-center relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 to-blue-900 border border-blue-400/30 rounded-[1.5rem] z-0"></div>
                    <div class="absolute top-0 right-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20 mix-blend-overlay"></div>
                    
                    <div class="h-full rounded-[1.5rem] p-6 flex flex-col justify-center items-center relative z-10 transition-transform group-hover:scale-105 duration-500">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-600 flex items-center justify-center mb-4 shadow-[0_0_30px_rgba(245,158,11,0.5)] animate-pulse-slow rotate-12">
                            <svg class="w-8 h-8 text-white -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                        </div>
                        
                        <span class="px-3 py-1 bg-black/30 backdrop-blur-md text-yellow-300 text-sm font-bold rounded-lg mb-4 border border-yellow-400/30 font-display flex items-center gap-2">
                           <span class="w-2 h-2 rounded-full bg-red-500 animate-ping"></span> PROMO SPESIAL
                        </span>
                        
                        <h3 class="text-[1.7rem] font-display font-black text-white mb-2 leading-none uppercase drop-shadow-md">TIDAK SETIAP HARI!</h3>
                        <p class="text-blue-200 mb-6 text-sm font-semibold leading-snug">Nikmati harga miring khusus dari kami yang diadakan rutin <strong class="text-yellow-300 text-base">2X SETIAP BULAN!</strong> Cek jadwalnya yuk.</p>
                        
                        <div class="mb-4 mt-auto">
                            <span class="text-white/60 text-xs font-display block mb-1">Pantau Terus Info Tanggal Sale:</span>
                        </div>
                        
                        <a href="https://wa.me/6285808750161?text=Halo%20Admin,%20kapan%20jadwal%20promo%20rental%202x%20sebulan%20itu?" target="_blank" class="w-full bg-white text-blue-900 hover:bg-yellow-300 py-3 font-black rounded-xl flex items-center justify-center gap-2 transition-colors font-display tracking-widest shadow-xl text-sm">
                            TANYA JADWAL PROMO
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="games" class="mt-32 relative z-10">
            <div class="flex flex-col md:flex-row items-end justify-between mb-8">
                <div>
                    <h2 class="text-cyan-400 font-bold tracking-widest uppercase text-lg mb-1 font-display">TOP TITLES</h2>
                    <h3 class="text-4xl md:text-5xl font-display font-black text-white uppercase drop-shadow-lg">Game <span class="text-slate-600">Populer</span></h3>
                </div>
                <p class="text-slate-400 max-w-md text-right hidden md:block">Ratusan pilihan game menanti Anda. Mulai dari simulasi olahraga, petualangan aksi, hingga pertarungan mematikan.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 lg:gap-6">
                
                <div class="group relative rounded-2xl overflow-hidden aspect-[3/4] border border-white/10 hover:border-blue-500/50 transition-colors shadow-lg">
                    <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=400&q=80" alt="eFootball" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-ps-bg via-ps-bg/50 to-transparent flex flex-col justify-end p-4">
                        <span class="text-xs font-bold text-cyan-400 mb-1">Sports / Soccer</span>
                        <h4 class="text-white font-bold font-display tracking-wide text-lg leading-tight">eFootball 2024</h4>
                    </div>
                </div>

                <div class="group relative rounded-2xl overflow-hidden aspect-[3/4] border border-white/10 hover:border-blue-500/50 transition-colors shadow-lg">
                    <img src="https://images.unsplash.com/photo-1493711662062-fa541abbe517?auto=format&fit=crop&w=400&q=80" alt="EA FC" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-ps-bg via-ps-bg/50 to-transparent flex flex-col justify-end p-4">
                        <span class="text-xs font-bold text-cyan-400 mb-1">Sports / Soccer</span>
                        <h4 class="text-white font-bold font-display tracking-wide text-lg leading-tight">EA Sports FC 24</h4>
                    </div>
                </div>

                <div class="group relative rounded-2xl overflow-hidden aspect-[3/4] border border-white/10 hover:border-blue-500/50 transition-colors shadow-lg">
                    <img src="https://images.unsplash.com/photo-1605901309584-818e25960b8f?auto=format&fit=crop&w=400&q=80" alt="GTA V" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-ps-bg via-ps-bg/50 to-transparent flex flex-col justify-end p-4">
                        <span class="text-xs font-bold text-purple-400 mb-1">Action / Open World</span>
                        <h4 class="text-white font-bold font-display tracking-wide text-lg leading-tight">Grand Theft Auto V</h4>
                    </div>
                </div>

                <div class="group relative rounded-2xl overflow-hidden aspect-[3/4] border border-white/10 hover:border-blue-500/50 transition-colors shadow-lg">
                    <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=400&q=80" alt="God of War" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-ps-bg via-ps-bg/50 to-transparent flex flex-col justify-end p-4">
                        <span class="text-xs font-bold text-red-400 mb-1">Action / Adventure</span>
                        <h4 class="text-white font-bold font-display tracking-wide text-lg leading-tight">God of War Ragnarök</h4>
                    </div>
                </div>

                <div class="group relative rounded-2xl overflow-hidden aspect-[3/4] border border-white/10 hover:border-blue-500/50 transition-colors shadow-lg">
                    <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=400&q=80" alt="Tekken" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-ps-bg via-ps-bg/50 to-transparent flex flex-col justify-end p-4">
                        <span class="text-xs font-bold text-yellow-400 mb-1">Fighting</span>
                        <h4 class="text-white font-bold font-display tracking-wide text-lg leading-tight">Tekken 8</h4>
                    </div>
                </div>

            </div>
            <div class="mt-8 text-center">
                <p class="text-sm text-slate-500 italic">* Dan masih banyak lagi game keren lainnya di rental kami!</p>
            </div>
        </div>

        <div class="mt-24 w-full relative z-10 glass-card rounded-[2.5rem] overflow-hidden border border-green-500/40 shadow-[0_0_50px_rgba(34,197,94,0.15)] group/banner">
            
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-gradient-to-br from-green-900/90 via-slate-900/95 to-slate-900 z-10"></div>
                <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-20"></div>
                
                <div class="absolute -top-24 -left-20 w-80 h-80 bg-green-500/20 rounded-full blur-[80px] z-20 group-hover/banner:bg-green-400/30 transition-colors duration-700"></div>
                <div class="absolute -bottom-24 -right-20 w-80 h-80 bg-cyan-500/10 rounded-full blur-[80px] z-20 group-hover/banner:bg-cyan-400/20 transition-colors duration-700"></div>
            </div>
            
            <div class="relative z-30 p-8 md:p-12 lg:p-16">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                    
                    <div class="lg:col-span-5 flex justify-center w-full relative">
                        <div class="relative group w-full max-w-sm lg:max-w-full">
                            <div class="absolute -inset-2 bg-gradient-to-r from-green-500 to-cyan-500 rounded-[1.5rem] blur-xl opacity-60 group-hover:opacity-100 group-hover:scale-105 transition duration-700"></div>
                            <img src="{{ asset('images/gembox.jpg') }}" alt="Event GemboxPatch 2026" class="relative w-full h-auto object-cover rounded-xl shadow-2xl border border-white/20 group-hover:-translate-y-3 transition-transform duration-500">
                        </div>
                    </div>

                    <div class="lg:col-span-7 flex flex-col items-center lg:items-start text-center lg:text-left">
                        
                        <span class="px-5 py-2 bg-gradient-to-r from-green-500/20 to-cyan-500/20 text-green-400 text-sm font-bold rounded-xl mb-6 inline-flex shadow-inner border border-green-500/40 uppercase tracking-[0.2em] font-display">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse mr-2 mt-1.5 shadow-[0_0_10px_rgba(74,222,128,1)]"></span> Special Event
                        </span>
                        
                        <h3 class="text-4xl md:text-5xl lg:text-[4rem] font-display font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-200 mb-2 uppercase drop-shadow-[0_5px_5px_rgba(0,0,0,0.5)] leading-[1.1]">
                            TURNAMEN<br/>SEPAK BOLA
                        </h3>
                        
                        <h4 class="text-2xl md:text-3xl lg:text-4xl font-display font-black text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-cyan-400 mb-6 uppercase tracking-wider inline-block">
                            GemboxPatch 2026
                        </h4>
                        
                        <p class="text-slate-300 font-medium leading-relaxed text-lg mb-10 max-w-2xl">
                            Buktikan magis jari tanganmu di arena hijau virtual! Kami menyelenggarakan pertarungan e-Football terbesar dengan mengusung patch terbaru <strong class="text-green-300 font-bold tracking-wide">GemboxPatch 2026</strong>. Hadiah <span class="text-white font-bold pb-1 border-b border-green-500/50">Jutaan Rupiah</span> & trophy eksklusif menanti sang kampiun!
                        </p>
                        
                        <a href="https://wa.me/6285808750161?text=Halo%20GAMEZONE,%20saya%20siap%20tempur%20di%20Turnamen%20GemboxPatch%202026!" target="_blank" class="w-full sm:w-auto relative group/btn overflow-hidden rounded-2xl shadow-[0_0_40px_rgba(59,130,246,0.5)] mt-4">
                            <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-cyan-400 to-indigo-600 rounded-2xl blur-md opacity-60 group-hover/btn:opacity-100 group-hover/btn:blur-xl transition-all duration-500"></div>
                            
                            <div class="relative bg-gradient-to-br from-blue-600 to-blue-900 border border-blue-400/50 group-hover/btn:border-cyan-300/80 text-white font-black py-4 px-10 rounded-2xl text-xl flex items-center justify-center gap-3 transition-colors font-display tracking-widest uppercase">
                                DAFTAR SEKARANG
                                <svg class="w-6 h-6 transform group-hover/btn:translate-x-2 transition-transform text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-32 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-cyan-400 font-bold tracking-widest uppercase text-lg mb-1 font-display">HALL OF FAME</h2>
                <h3 class="text-4xl md:text-5xl font-display font-black text-white uppercase drop-shadow-lg">Apa Kata <span class="text-slate-600">Mereka?</span></h3>
                <p class="text-slate-400 mt-4 max-w-2xl mx-auto">Kepuasan pelanggan adalah piala utama kami. Intip pengalaman seru mereka saat menyewa di Gamezone.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="glass-card rounded-3xl p-8 relative hover:-translate-y-2 transition-transform duration-300 border border-white/5">
                    <div class="flex text-yellow-400 mb-6 gap-1">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <p class="text-slate-300 italic mb-8 leading-relaxed">"Gila sih, PS5 nya mulus banget kayak baru buka dari kardus. Stiknya ori semua no drift-drift club! Adminnya juga fast respon parah kalau ditanya-tanya."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold text-xl">B</div>
                        <div>
                            <h5 class="text-white font-bold font-display text-lg">Bima Pangestu</h5>
                            <span class="text-blue-400 text-sm font-medium">Rental Bawa Pulang</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-3xl p-8 relative hover:-translate-y-2 transition-transform duration-300 border border-white/5">
                    <div class="flex text-yellow-400 mb-6 gap-1">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <p class="text-slate-300 italic mb-8 leading-relaxed">"Tempat rental paling pewe di Lumajang! Parkir luas, ruang tunggu adem, dan yang paling penting game di PS4 nya super lengkap. Fix bakal langganan terus sih."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-xl">D</div>
                        <div>
                            <h5 class="text-white font-bold font-display text-lg">Dimas Wahyu</h5>
                            <span class="text-purple-400 text-sm font-medium">Main di Tempat</span>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-3xl p-8 relative hover:-translate-y-2 transition-transform duration-300 border border-white/5">
                    <div class="flex text-yellow-400 mb-6 gap-1">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <svg class="w-5 h-5 text-slate-600 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    </div>
                    <p class="text-slate-300 italic mb-8 leading-relaxed">"Sering banget berburu diskon rental 2x sebulan di sini. Lumayan banget buat patungan rental PS3 bawa pulang rame-rekan sekelas buat nge-PES pas weekend."</p>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-cyan-500 to-blue-500 flex items-center justify-center text-white font-bold text-xl">R</div>
                        <div>
                            <h5 class="text-white font-bold font-display text-lg">Reza Pratama</h5>
                            <span class="text-cyan-400 text-sm font-medium">Rental Bawa Pulang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-32 relative z-10 max-w-4xl mx-auto" x-data="{ activeAccordion: 1 }">
            <div class="text-center mb-12">
                <h2 class="text-cyan-400 font-bold tracking-widest uppercase text-lg mb-1 font-display">BANTUAN</h2>
                <h3 class="text-4xl md:text-5xl font-display font-black text-white uppercase drop-shadow-lg">FAQ <span class="text-slate-600">Rental</span></h3>
                <p class="text-slate-400 mt-4">Jawaban cepat untuk pertanyaan yang paling sering diajukan ke admin kami.</p>
            </div>

            <div class="space-y-4">
                <div class="glass-card rounded-2xl overflow-hidden border border-white/5">
                    <button @click="activeAccordion = activeAccordion === 1 ? null : 1" class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-white/5 transition-colors focus:outline-none">
                        <span class="text-lg font-bold text-white font-display">Apakah bisa nambah sewa stik (controller)?</span>
                        <svg :class="activeAccordion === 1 ? 'rotate-180 text-blue-400' : 'text-slate-500'" class="w-6 h-6 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeAccordion === 1" x-collapse class="px-6 pb-6 text-slate-400 leading-relaxed">
                        Tentu saja bisa! Paket standar rental bawa pulang sudah termasuk 2 buah stik. Jika Anda butuh tambahan stik untuk main beramai-ramai, Anda cukup membayar biaya tambahan sebesar <strong>Rp 10.000 / stik / hari</strong>.
                    </div>
                </div>

                <div class="glass-card rounded-2xl overflow-hidden border border-white/5">
                    <button @click="activeAccordion = activeAccordion === 2 ? null : 2" class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-white/5 transition-colors focus:outline-none">
                        <span class="text-lg font-bold text-white font-display">Bagaimana syarat untuk rental bawa pulang?</span>
                        <svg :class="activeAccordion === 2 ? 'rotate-180 text-blue-400' : 'text-slate-500'" class="w-6 h-6 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeAccordion === 2" x-collapse class="px-6 pb-6 text-slate-400 leading-relaxed" style="display: none;">
                        Syaratnya sangat mudah demi keamanan bersama. Penyewa cukup meninggalkan <strong>KTP Asli dan STNK Motor Asli (atau BPKB)</strong> yang masih berlaku sebagai jaminan selama masa sewa berlangsung. Dokumen akan langsung kami kembalikan utuh saat mesin PS dikembalikan.
                    </div>
                </div>

                <div class="glass-card rounded-2xl overflow-hidden border border-white/5">
                    <button @click="activeAccordion = activeAccordion === 3 ? null : 3" class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-white/5 transition-colors focus:outline-none">
                        <span class="text-lg font-bold text-white font-display">Apakah konsol PS-nya diantar ke rumah?</span>
                        <svg :class="activeAccordion === 3 ? 'rotate-180 text-blue-400' : 'text-slate-500'" class="w-6 h-6 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeAccordion === 3" x-collapse class="px-6 pb-6 text-slate-400 leading-relaxed" style="display: none;">
                        Untuk saat ini, <strong>sistem kami adalah ambil dan antar mandiri di markas kami</strong> (Watu Kandang, Lumajang). Hal ini agar Anda bisa sekalian mengecek fisik dan kelengkapan mesin secara transparan sebelum dibawa pulang.
                    </div>
                </div>

                <div class="glass-card rounded-2xl overflow-hidden border border-white/5">
                    <button @click="activeAccordion = activeAccordion === 4 ? null : 4" class="w-full px-6 py-5 text-left flex justify-between items-center hover:bg-white/5 transition-colors focus:outline-none">
                        <span class="text-lg font-bold text-white font-display">Bagaimana jika terlambat mengembalikan mesin?</span>
                        <svg :class="activeAccordion === 4 ? 'rotate-180 text-blue-400' : 'text-slate-500'" class="w-6 h-6 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeAccordion === 4" x-collapse class="px-6 pb-6 text-slate-400 leading-relaxed" style="display: none;">
                        Kami memberikan toleransi keterlambatan maksimal 1 jam. Jika lewat dari itu tanpa konfirmasi perpanjangan, maka akan dikenakan denda keterlambatan sebesar <strong>Rp 5.000 / jam</strong> (untuk PS3/PS4) dan <strong>Rp 10.000 / jam</strong> (untuk PS5). Jika ingin memperpanjang masa sewa, pastikan chat admin sebelum waktu habis ya!
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-32 border-t border-white/10 bg-ps-surface/50 backdrop-blur-xl rounded-t-[3rem] px-8 py-12 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900/20 to-transparent z-0"></div>
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-3xl font-display font-black text-white mb-6 uppercase tracking-wider">LOKASI RENTAL</h3>
                    <p class="text-slate-300 mb-6 font-medium">Kunjungi markas kami untuk mengecek langsung kesiapan konsol sebelum menyewa. Parkir luas, ruang tunggu AC!</p>
                    <div class="flex items-center gap-3 text-slate-400 mb-2">
                        <svg class="w-6 h-6 text-ps-neon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Watu Kandang, Penanggal, Kec. Candipuro, Kabupaten Lumajang, Jawa Timur</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-400">
                        <svg class="w-6 h-6 text-ps-neon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Buka Setiap Hari (24 Jam)</span>
                    </div>
                </div>
                <div class="h-64 rounded-2xl overflow-hidden border border-white/10 shadow-[0_0_30px_rgba(59,130,246,0.15)] filter brightness-90 relative">
                    <iframe class="absolute inset-0 w-full h-full" src="https://maps.google.com/maps?q=V25M%2BQRH,%20Watu%20Kandang,%20Penanggal,%20Candipuro,%20Lumajang,%20Jawa%20Timur&t=&z=18&ie=UTF8&iwloc=&output=embed" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="text-center mt-12 pt-8 border-t border-white/10 text-slate-500 font-medium tracking-widest font-display">
                © {{ date('Y') }} GAMEZONE INC. ALL RIGHTS RESERVED.
            </div>
        </footer>

    </main>

    <a href="https://wa.me/6285808750161?text=Halo%20GAMEZONE,%20saya%20tertarik%20untuk%20rental%20console!" target="_blank" class="fixed bottom-8 right-8 w-16 h-16 bg-green-500 rounded-full flex items-center justify-center shadow-[0_0_25px_rgba(34,197,94,0.6)] hover:bg-green-400 hover:scale-110 transition-all duration-300 z-50 group">
        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        <span class="absolute right-20 bg-slate-900 text-white px-4 py-2 rounded-xl text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-xl font-display border border-slate-700">Chat Admin Rental</span>
    </a>
</body>
</html>