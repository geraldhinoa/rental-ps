<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GAMEZONE - Rental Console Premium</title>
    
    <!-- Gamer Fonts Upgrade -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Alpine.js & Tailwind CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
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
    </style>
</head>
<body class="text-slate-100 font-body antialiased min-h-screen flex flex-col relative overflow-x-hidden selection:bg-ps-neon selection:text-white">
    
    <!-- Animated Orbs -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none mix-blend-screen">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-blue-600/30 rounded-full blur-[128px] animate-blob"></div>
        <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-cyan-500/20 rounded-full blur-[128px] animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-1/4 left-1/3 w-[30rem] h-[30rem] bg-indigo-600/20 rounded-full blur-[128px] animate-blob animation-delay-4000"></div>
    </div>

    <!-- Ultra Premium Navbar -->
    <nav class="fixed w-full z-50 glass-card border-b border-white/5 transition-all duration-300 backdrop-blur-xl" x-data="{ scrolled: false, mobileMenuOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
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
                
                <!-- Desktop Menu -->
                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-2">
                    <a href="#katalog" class="px-4 py-2 rounded-xl text-lg font-bold text-slate-100 hover:text-blue-300 hover:bg-blue-500/10 hover:shadow-[inset_0_0_15px_rgba(59,130,246,0.2)] transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 active:scale-95">Katalog Mesin</a>
                    <a href="#faq" class="px-4 py-2 rounded-xl text-lg font-bold text-slate-100 hover:text-blue-300 hover:bg-blue-500/10 hover:shadow-[inset_0_0_15px_rgba(59,130,246,0.2)] transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 active:scale-95">FAQ</a>
                    <div class="w-px h-6 bg-white/10 mx-1"></div>
                    
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->role === 'admin'): ?>
                            <a href="/admin/dashboard" class="px-4 py-2 rounded-xl text-sm font-bold text-purple-400 border border-purple-500/50 hover:bg-purple-600 hover:text-white hover:shadow-[0_0_20px_rgba(168,85,247,0.5)] transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 active:scale-95 uppercase tracking-widest">Dasbor Admin</a>
                        <?php else: ?>
                            <a href="/user/dashboard" class="px-4 py-2 rounded-xl text-sm font-bold text-green-400 border border-green-500/50 hover:bg-green-600 hover:text-white hover:shadow-[0_0_20px_rgba(34,197,94,0.5)] transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 active:scale-95 uppercase tracking-widest">Dasbor Saya</a>
                        <?php endif; ?>
                        <a href="/logout" class="px-4 py-2 rounded-xl text-sm font-bold text-red-400 hover:text-red-300 hover:bg-red-500/10 hover:shadow-[inset_0_0_15px_rgba(239,68,68,0.2)] transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 active:scale-95 uppercase tracking-widest">Keluar</a>
                    <?php else: ?>
                        <a href="/login" class="px-3 py-2.5 rounded-xl text-sm font-bold text-slate-300 hover:text-white hover:bg-white/10 transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 active:scale-95 uppercase tracking-widest">Login Pelanggan</a>
                        <div class="w-px h-4 bg-white/10 mx-1 hidden lg:block"></div>
                        <a href="/admin/login" class="px-3 py-2.5 rounded-xl text-xs font-bold text-slate-500 hover:text-purple-400 hover:bg-purple-500/10 transition-all duration-300 hover:-translate-y-0.5 active:translate-y-0 active:scale-95 uppercase tracking-widest">Login Admin</a>
                    <?php endif; ?>
                    
                    <a href="/booking" class="ml-2 premium-btn text-white text-lg font-bold py-2.5 px-7 rounded-xl border border-blue-400/30 shadow-[0_0_15px_rgba(59,130,246,0.4)] hover:shadow-[0_0_25px_rgba(59,130,246,0.7)] transition-all duration-300 hover:-translate-y-1 active:translate-y-0 active:scale-95 uppercase font-display tracking-widest">SEWA SEKARANG</a>
                </div>
                
                <!-- Mobile Menu Button -->
                <div class="lg:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-100 hover:text-white focus:outline-none p-2 rounded-lg hover:bg-white/5 transition-colors">
                        <svg x-show="!mobileMenuOpen" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileMenuOpen" style="display:none;" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Menu Dropdown -->
            <div x-show="mobileMenuOpen" style="display:none;" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="lg:hidden py-4 border-t border-white/10 flex flex-col space-y-2 pb-6">
                <a href="#katalog" @click="mobileMenuOpen = false" class="block px-4 py-3 text-slate-100 font-bold hover:bg-white/5 rounded-xl transition-all active:scale-95 font-display tracking-wide">Katalog Mesin</a>
                <a href="#faq" @click="mobileMenuOpen = false" class="block px-4 py-3 text-slate-100 font-bold hover:bg-white/5 rounded-xl transition-all active:scale-95 font-display tracking-wide">FAQ</a>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->role === 'admin'): ?>
                        <a href="/admin/dashboard" class="block px-4 py-3 text-purple-400 font-bold hover:bg-white/5 rounded-xl transition-all active:scale-95 font-display tracking-wide">Dasbor Admin</a>
                    <?php else: ?>
                        <a href="/user/dashboard" class="block px-4 py-3 text-green-400 font-bold hover:bg-white/5 rounded-xl transition-all active:scale-95 font-display tracking-wide">Dasbor Saya</a>
                    <?php endif; ?>
                    <a href="/logout" class="block px-4 py-3 text-red-400 font-bold hover:bg-white/5 rounded-xl transition-all active:scale-95 font-display tracking-wide">Keluar</a>
                <?php else: ?>
                    <a href="/login" class="block px-4 py-3 text-slate-300 font-bold hover:bg-white/5 rounded-xl transition-all active:scale-95 font-display tracking-wide">Login Pelanggan</a>
                    <a href="/admin/login" class="block px-4 py-3 text-slate-500 font-bold hover:bg-white/5 rounded-xl transition-all active:scale-95 font-display tracking-wide">Login Admin</a>
                <?php endif; ?>
                <div class="pt-2 px-4">
                    <a href="/booking" class="block w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-black py-4 rounded-xl text-center shadow-[0_0_20px_rgba(59,130,246,0.3)] font-display tracking-widest uppercase transition-transform active:scale-95">SEWA SEKARANG</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-32 pb-20 w-full max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Hero Section -->
        <div class="relative py-16 flex flex-col items-center justify-center text-center z-10">
            <h1 data-aos="fade-up" data-aos-duration="1000" class="text-5xl md:text-7xl lg:text-[5.5rem] font-black text-white mb-6 font-display tracking-tight leading-tight uppercase drop-shadow-2xl">
                KUASAI ARENA <br/>
                <span class="text-gradient text-[1.1em] pr-2">GAMEZONE</span>
            </h1>
            
            <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100" class="text-xl md:text-2xl text-blue-100/70 max-w-2xl mb-12 font-medium leading-relaxed">
                Persenjatai diri Anda dengan unit konsol kondisi prima. PS5, PS4, dan PS3 siap untuk menemani marathon gaming Anda.
            </p>
            
            <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200" class="flex flex-col sm:flex-row gap-5 items-center justify-center font-display">
                <a href="/booking" class="premium-btn text-white text-xl tracking-wider py-4 px-12 rounded-xl border border-blue-400/20 shadow-[-10px_0_30px_rgba(59,130,246,0.5)] flex items-center gap-3 transition-transform active:scale-95">
                    SEWA SEKARANG
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>

        <!-- Catalog Section -->
        <div id="katalog" class="mt-16 relative z-10">
            <div data-aos="fade-up" data-aos-duration="1000" class="text-center mb-12">
                <h2 class="text-cyan-400 font-bold tracking-widest uppercase text-lg mb-1 font-display">KOLEKSI KAMI</h2>
                <h3 class="text-5xl font-display font-black text-white uppercase drop-shadow-lg flex items-center justify-center gap-2">Pilih<span class="text-slate-600"> Konsol</span></h3>
            </div>

            <!-- 4 Column Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                <!-- Premium PS5 Card -->
                <div data-aos="fade-up" data-aos-duration="1000" class="glass-card glass-card-hover rounded-3xl p-2 group relative overflow-hidden animate-glow-border">
                    <div class="ps-pattern"></div>
                    <div class="bg-ps-surface/90 rounded-[1.5rem] p-6 h-full flex flex-col relative z-10 border border-white/5">
                        <div class="absolute -right-16 -top-16 w-32 h-32 bg-blue-500/20 rounded-full blur-[30px] group-hover:bg-blue-500/50 transition duration-500"></div>
                        
                        <div class="flex justify-between items-start mb-6 gap-2">
                            <div class="min-w-0">
                                <h3 class="text-xs font-bold text-blue-400 font-display uppercase tracking-widest truncate">Generasi Terbaru</h3>
                                <h4 class="text-3xl font-black text-white font-display mt-1">PS 5</h4>
                            </div>
                            <?php if(isset($stock['ps5']) && $stock['ps5'] > 0): ?>
                                <span class="px-3 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-lg border border-green-500/30 whitespace-nowrap"><?php echo e($stock['ps5']); ?> Unit Tersedia</span>
                            <?php else: ?>
                                <?php if(isset($nextAvailable['ps5']) && $nextAvailable['ps5']): ?>
                                    <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 text-xs font-bold rounded-lg border border-yellow-500/30 whitespace-nowrap"
                                          x-data="{ 
                                              end: <?php echo e(\Carbon\Carbon::parse($nextAvailable['ps5'])->timestamp * 1000); ?>,
                                              now: new Date().getTime(),
                                              distance: 0,
                                              text: 'Menghitung...',
                                              init() {
                                                  this.update();
                                                  setInterval(() => this.update(), 1000);
                                              },
                                              update() {
                                                  this.now = new Date().getTime();
                                                  this.distance = this.end - this.now;
                                                  if (this.distance < 0) {
                                                      this.text = 'Segera Tersedia';
                                                      return;
                                                  }
                                                  let h = Math.floor((this.distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                  let m = Math.floor((this.distance % (1000 * 60 * 60)) / (1000 * 60));
                                                  let s = Math.floor((this.distance % (1000 * 60)) / 1000);
                                                  this.text = 'Tersedia dlm ' + h.toString().padStart(2, '0') + ':' + m.toString().padStart(2, '0') + ':' + s.toString().padStart(2, '0');
                                              }
                                          }" x-text="text">
                                    </span>
                                <?php else: ?>
                                    <span class="px-3 py-1 bg-red-500/20 text-red-400 text-xs font-bold rounded-lg border border-red-500/30 animate-pulse whitespace-nowrap">Sedang Penuh</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="relative mb-6 rounded-2xl overflow-hidden aspect-[4/3] bg-gradient-to-tr from-slate-900 to-blue-900/30">
                            <img src="https://images.unsplash.com/photo-1606813907291-d86efa9b94db?auto=format&fit=crop&w=600&q=80" alt="PS5" class="w-full h-full object-cover mix-blend-screen group-hover:scale-110 transition-transform duration-700">
                        </div>
                        
                        <div class="flex-grow pb-4">
                            <ul class="text-[1.1rem] space-y-2 text-slate-100 font-medium">
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-blue-500"></div> Grafik Super Nyata</li>
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-blue-500"></div> Stik Getar Halus</li>
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-blue-500"></div> Loading Super Cepat</li>
                            </ul>
                        </div>
                        
                        <div class="pt-4 border-t border-white/10 flex justify-between items-end">
                            <div>
                                <span class="text-sm text-slate-300 font-bold tracking-widest font-display mb-1 block">TARIF/JAM</span>
                                <span class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-cyan-300 font-display"><?php echo e(isset($categories['ps5']) ? ($categories['ps5']->price_per_hour / 1000) . 'K' : '10K'); ?></span>
                            </div>
                            <a href="/booking?category=ps5" class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center shadow-[0_0_15px_rgba(59,130,246,0.5)] group-hover:bg-cyan-500 transition-all active:scale-90">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Premium PS4 Card -->
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100" class="glass-card glass-card-hover rounded-3xl p-2 group relative overflow-hidden">
                    <div class="ps-pattern"></div>
                    <div class="bg-ps-surface/90 rounded-[1.5rem] p-6 h-full flex flex-col relative z-10 border border-white/5">
                        <div class="absolute -right-16 -top-16 w-32 h-32 bg-purple-500/20 rounded-full blur-[30px] group-hover:bg-purple-500/50 transition duration-500"></div>
                        
                        <div class="flex justify-between items-start mb-6 gap-2">
                            <div class="min-w-0">
                                <h3 class="text-xs font-bold text-purple-400 font-display uppercase tracking-widest truncate">Klasik Modern</h3>
                                <h4 class="text-3xl font-black text-white font-display mt-1">PS 4</h4>
                            </div>
                            <?php if(isset($stock['ps4']) && $stock['ps4'] > 0): ?>
                                <span class="px-3 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-lg border border-green-500/30 whitespace-nowrap"><?php echo e($stock['ps4']); ?> Unit Tersedia</span>
                            <?php else: ?>
                                <?php if(isset($nextAvailable['ps4']) && $nextAvailable['ps4']): ?>
                                    <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 text-xs font-bold rounded-lg border border-yellow-500/30 whitespace-nowrap"
                                          x-data="{ 
                                              end: <?php echo e(\Carbon\Carbon::parse($nextAvailable['ps4'])->timestamp * 1000); ?>,
                                              now: new Date().getTime(),
                                              distance: 0,
                                              text: 'Menghitung...',
                                              init() {
                                                  this.update();
                                                  setInterval(() => this.update(), 1000);
                                              },
                                              update() {
                                                  this.now = new Date().getTime();
                                                  this.distance = this.end - this.now;
                                                  if (this.distance < 0) {
                                                      this.text = 'Segera Tersedia';
                                                      return;
                                                  }
                                                  let h = Math.floor((this.distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                  let m = Math.floor((this.distance % (1000 * 60 * 60)) / (1000 * 60));
                                                  let s = Math.floor((this.distance % (1000 * 60)) / 1000);
                                                  this.text = 'Tersedia dlm ' + h.toString().padStart(2, '0') + ':' + m.toString().padStart(2, '0') + ':' + s.toString().padStart(2, '0');
                                              }
                                          }" x-text="text">
                                    </span>
                                <?php else: ?>
                                    <span class="px-3 py-1 bg-red-500/20 text-red-400 text-xs font-bold rounded-lg border border-red-500/30 animate-pulse whitespace-nowrap">Sedang Penuh</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="relative mb-6 rounded-2xl overflow-hidden aspect-[4/3] bg-white">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/7e/PS4-Console-wDS4.jpg" alt="PS4" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700 p-4">
                        </div>
                        
                        <div class="flex-grow pb-4">
                            <ul class="text-[1.1rem] space-y-2 text-slate-100 font-medium">
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-purple-500"></div> Grafik Resolusi Tinggi</li>
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-purple-500"></div> Stik Asli Bawaan</li>
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-purple-500"></div> Pilihan Game Terlengkap</li>
                            </ul>
                        </div>
                        
                        <div class="pt-4 border-t border-white/10 flex justify-between items-end">
                            <div>
                                <span class="text-sm text-slate-300 font-bold tracking-widest font-display mb-1 block">TARIF/JAM</span>
                                <span class="text-4xl font-black text-white font-display"><?php echo e(isset($categories['ps4']) ? ($categories['ps4']->price_per_hour / 1000) . 'K' : '6K'); ?></span>
                            </div>
                            <a href="/booking?category=ps4" class="w-12 h-12 rounded-xl bg-purple-600 flex items-center justify-center group-hover:shadow-[0_0_15px_rgba(168,85,247,0.5)] transition-all hover:bg-purple-500 active:scale-90">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Premium PS3 Card -->
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200" class="glass-card glass-card-hover rounded-3xl p-2 group relative overflow-hidden">
                    <div class="ps-pattern"></div>
                    <div class="bg-ps-surface/90 rounded-[1.5rem] p-6 h-full flex flex-col relative z-10 border border-white/5">
                        <div class="absolute -right-16 -top-16 w-32 h-32 bg-red-500/10 rounded-full blur-[30px] group-hover:bg-red-500/30 transition duration-500"></div>
                        
                        <div class="flex justify-between items-start mb-6 gap-2">
                            <div class="min-w-0">
                                <h3 class="text-xs font-bold text-red-400 font-display uppercase tracking-widest truncate">Legenda Retro</h3>
                                <h4 class="text-3xl font-black text-white font-display mt-1">PS 3</h4>
                            </div>
                            <?php if(isset($stock['ps3']) && $stock['ps3'] > 0): ?>
                                <span class="px-3 py-1 bg-green-500/20 text-green-400 text-xs font-bold rounded-lg border border-green-500/30 whitespace-nowrap"><?php echo e($stock['ps3']); ?> Unit Tersedia</span>
                            <?php else: ?>
                                <?php if(isset($nextAvailable['ps3']) && $nextAvailable['ps3']): ?>
                                    <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 text-xs font-bold rounded-lg border border-yellow-500/30 whitespace-nowrap"
                                          x-data="{ 
                                              end: <?php echo e(\Carbon\Carbon::parse($nextAvailable['ps3'])->timestamp * 1000); ?>,
                                              now: new Date().getTime(),
                                              distance: 0,
                                              text: 'Menghitung...',
                                              init() {
                                                  this.update();
                                                  setInterval(() => this.update(), 1000);
                                              },
                                              update() {
                                                  this.now = new Date().getTime();
                                                  this.distance = this.end - this.now;
                                                  if (this.distance < 0) {
                                                      this.text = 'Segera Tersedia';
                                                      return;
                                                  }
                                                  let h = Math.floor((this.distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                  let m = Math.floor((this.distance % (1000 * 60 * 60)) / (1000 * 60));
                                                  let s = Math.floor((this.distance % (1000 * 60)) / 1000);
                                                  this.text = 'Tersedia dlm ' + h.toString().padStart(2, '0') + ':' + m.toString().padStart(2, '0') + ':' + s.toString().padStart(2, '0');
                                              }
                                          }" x-text="text">
                                    </span>
                                <?php else: ?>
                                    <span class="px-3 py-1 bg-red-500/20 text-red-400 text-xs font-bold rounded-lg border border-red-500/30 animate-pulse whitespace-nowrap">Sedang Penuh</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="relative mb-6 rounded-2xl overflow-hidden aspect-[4/3] bg-white">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/d/d3/Sony-PlayStation-3-2001A-wController-L.jpg" alt="PS3" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-700 p-4">
                        </div>
                        
                        <div class="flex-grow pb-4">
                            <ul class="text-[1.1rem] space-y-2 text-slate-100 font-medium">
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-red-500"></div> Game Nostalgia Seru</li>
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-red-500"></div> Bisa Main Bareng Teman</li>
                                <li class="flex gap-2"><div class="w-1.5 h-1.5 mt-2 rounded-full bg-red-500"></div> Harga Paling Murah</li>
                            </ul>
                        </div>
                        
                        <div class="pt-4 border-t border-white/10 flex justify-between items-end">
                            <div>
                                <span class="text-sm text-slate-300 font-bold tracking-widest font-display mb-1 block">TARIF/JAM</span>
                                <span class="text-4xl font-black text-white font-display"><?php echo e(isset($categories['ps3']) ? ($categories['ps3']->price_per_hour / 1000) . 'K' : '4K'); ?></span>
                            </div>
                            <a href="/booking?category=ps3" class="w-12 h-12 rounded-xl bg-red-600 flex items-center justify-center group-hover:shadow-[0_0_15px_rgba(239,68,68,0.5)] transition-all hover:bg-red-500 active:scale-90">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Epic Promo Cards -->
                <?php if(isset($promos)): ?>
                <?php $__currentLoopData = $promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300" class="glass-card rounded-3xl p-2 text-center relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 to-blue-900 border border-blue-400/30 rounded-[1.5rem] z-0"></div>
                    <div class="absolute top-0 right-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20 mix-blend-overlay"></div>
                    
                    <div class="h-full rounded-[1.5rem] p-6 flex flex-col justify-center items-center relative z-10 transition-transform group-hover:scale-105 duration-500">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-600 flex items-center justify-center mb-4 shadow-[0_0_30px_rgba(245,158,11,0.5)] animate-pulse-slow rotate-12">
                            <svg class="w-8 h-8 text-white -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        
                        <span class="px-3 py-1 bg-black/30 backdrop-blur-md text-yellow-300 text-sm font-bold rounded-lg mb-4 border border-yellow-400/30 font-display">KODE: <?php echo e($promo->code); ?></span>
                        
                        <h3 class="text-2xl font-display font-black text-white mb-2 leading-tight uppercase drop-shadow-md"><?php echo e($promo->description ?? 'PROMO SPESIAL'); ?></h3>
                        <p class="text-blue-200 mb-6 font-semibold leading-snug text-sm">Gunakan kode di atas di halaman pemesanan dan dapatkan potongan harga menggiurkan!</p>
                        
                        <div class="mb-6">
                            <span class="text-white/60 text-lg mr-2 font-display block mb-1">Diskon Keras:</span>
                            <span class="text-3xl font-black text-yellow-300 font-display drop-shadow-[0_0_15px_rgba(253,224,71,0.6)]"><?php echo e(number_format($promo->discount_amount, 0, ',', '.')); ?> IDR</span>
                        </div>
                        
                        <a href="/booking?promo=<?php echo e($promo->code); ?>" class="w-full bg-white text-blue-900 hover:bg-yellow-300 py-3 font-black rounded-xl flex items-center justify-center gap-2 transition-all active:scale-95 font-display tracking-widest shadow-xl text-sm">
                            KLAIM SEKARANG
                        </a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tournament Banner -->
        <div data-aos="fade-up" data-aos-duration="1000" class="mt-16 w-full relative z-10 glass-card p-8 md:p-12 rounded-3xl overflow-hidden border border-green-500/30">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1518605368461-1e1252223126?auto=format&fit=crop&w=1200&q=80" alt="Football Field Background" class="w-full h-full object-cover opacity-30 mix-blend-luminosity">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/90 to-green-900/60"></div>
                <!-- Subtle pattern -->
                <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%2322c55e\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
            </div>
            
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-12">
                <!-- Text Content Area -->
                <div class="flex-1 text-center lg:text-left">
                    <span class="px-4 py-1.5 bg-green-500/20 text-green-400 text-sm font-bold rounded-lg mb-6 inline-block border border-green-500/30 uppercase tracking-widest font-display shadow-[0_0_15px_rgba(34,197,94,0.3)]">
                        <span class="inline-block w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span> Special Event
                    </span>
                    <h3 class="text-4xl md:text-5xl lg:text-6xl font-display font-black text-white mb-3 uppercase leading-tight drop-shadow-[0_2px_10px_rgba(0,0,0,0.5)] flex flex-col">
                        <span>Turnamen Sepak Bola</span>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-300 drop-shadow-none">GemboxPatch 2026</span>
                    </h3>
                    <p class="text-slate-100 font-medium leading-relaxed max-w-2xl text-lg mb-8 mx-auto lg:mx-0">
                        Buktikan keahlian Anda di arena hijau virtual! Kami mengadakan turnamen e-Football dengan update patch terbaru GemboxPatch 2026. Hadiah jutaan rupiah & trophy eksklusif Gamezone menanti sang juara!
                    </p>
                    
                    <a href="https://wa.me/6285808750161?text=Halo%20GAMEZONE,%20saya%20tertarik%20daftar%20Turnamen%20GemboxPatch%202026!" target="_blank" class="inline-flex premium-btn bg-green-600 hover:bg-green-500 text-white font-black py-4 px-10 rounded-2xl text-xl items-center justify-center gap-3 transition-all active:scale-95 font-display tracking-wide shadow-[0_0_20px_rgba(34,197,94,0.4)] group">
                        DAFTAR SEKARANG
                        <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
                
                <!-- Promo Poster Area -->
                <div class="w-full lg:w-[45%] flex-shrink-0 relative group">
                    <!-- Glowing Aura Effect behind image -->
                    <div class="absolute -inset-1 blur-2xl bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-600 opacity-50 group-hover:opacity-100 transition duration-700 rounded-[2rem] group-hover:blur-3xl animate-pulse-slow"></div>
                    
                    <!-- Image Container -->
                    <div class="relative bg-slate-900 border-2 border-white/10 rounded-[1.5rem] overflow-hidden shadow-2xl transform transition-transform duration-500 group-hover:scale-[1.03] group-hover:-rotate-2 flex items-center justify-center">
                        
                        <!-- PENTING: Gambar akan dimuat di sini -->
                        <!-- Jangan lupa ubah nama foldernya jika tidak diletakkan di dalam folder images -->
                        <img src="/images/promo-gembox.jpg" alt="Poster Turnamen Gembox" class="w-full h-auto object-cover opacity-0 transition-opacity duration-300" onload="this.classList.remove('opacity-0')">
                        
                        <!-- Placeholder/Fallback jika gambar gagal dimuat (atau belum di-copy ke folder public/images) -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700/50 -z-10 p-8 text-center" 
                             onerror="this.style.display='flex'">
                            <span class="text-blue-500 mb-3 bg-blue-500/10 p-4 rounded-full">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <h4 class="text-white font-bold mb-1">Letakkan Foto Promo Anda</h4>
                            <p class="text-slate-300 text-sm">Simpan foto di: <br/><code class="text-yellow-400 bg-slate-800 px-2 py-1 rounded">public/images/promo-gembox.jpg</code></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testimonial Section -->
        <div id="testimoni" class="mt-24 mb-16 relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div data-aos="fade-up" data-aos-duration="1000" class="text-center mb-16">
                <h2 class="text-blue-400 font-bold tracking-widest uppercase text-sm mb-2 font-display">KEPERCAYAAN PELANGGAN</h2>
                <h3 class="text-3xl md:text-5xl font-display font-black text-white uppercase drop-shadow-lg">Apa kata <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">pelanggan kami</span></h3>
                <p class="text-slate-300 mt-4 font-medium max-w-2xl mx-auto text-lg hover:text-slate-100 transition-colors">Dengarkan pengalaman langsung dari para gamers yang telah mempercayakan hiburan mereka bersama GAMEZONE.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                <!-- Testimoni 1 -->
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100" class="glass-card p-8 rounded-2xl relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute left-0 top-6 bottom-6 w-1.5 rounded-r-full bg-gradient-to-b from-blue-400 to-cyan-500 opacity-80"></div>
                    <p class="text-slate-100 text-[1.05rem] leading-relaxed mb-8 relative pl-4 font-medium">
                        "Rental PS paling mantap! Adminnya asik banget diajak ngobrol dan pelayanannya sangat ramah. Konsolnya selalu bersih, terawat, dan stiknya nggak ada yang drift sama sekali. Pelayanannya benar-benar juara dan sangat memuaskan."
                    </p>
                    <div class="flex items-center gap-4 pl-4">
                        <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center font-bold text-white shadow-inner overflow-hidden border border-slate-700">
                            <img src="/images/adrian.jpg" alt="Adrian" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="text-white font-bold font-display tracking-wide">M Adrian Geraldhino</h4>
                            <p class="text-blue-400 text-xs font-bold tracking-widest uppercase mt-0.5">Pro Gamer</p>
                        </div>
                    </div>
                </div>

                <!-- Testimoni 2 -->
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200" class="glass-card p-8 rounded-2xl relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute left-0 top-6 bottom-6 w-1.5 rounded-r-full bg-gradient-to-b from-blue-400 to-cyan-500 opacity-80"></div>
                    <p class="text-slate-100 text-[1.05rem] leading-relaxed mb-8 relative pl-4 font-medium">
                        "Sering banget nyewa PS5 di Gamezone buat main bareng teman-teman. Proses sewanya cepat, transparan, dan nggak ribet sama sekali. Suka banget sama keramahan adminnya yang bikin betah, recommended banget pokoknya!"
                    </p>
                    <div class="flex items-center gap-4 pl-4">
                        <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center font-bold text-white shadow-inner overflow-hidden border border-slate-700">
                            <img src="/images/hafidhin.jpg" alt="Hafidhin" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="text-white font-bold font-display tracking-wide">M Hafidhin Adinata</h4>
                            <p class="text-blue-400 text-xs font-bold tracking-widest uppercase mt-0.5">Juragan Sound System</p>
                        </div>
                    </div>
                </div>

                <!-- Testimoni 3 -->
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300" class="glass-card p-8 rounded-2xl relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute left-0 top-6 bottom-6 w-1.5 rounded-r-full bg-gradient-to-b from-blue-400 to-cyan-500 opacity-80"></div>
                    <p class="text-slate-100 text-[1.05rem] leading-relaxed mb-8 relative pl-4 font-medium">
                        "Kualitas mesin PS-nya top cer! Sudah beberapa kali rental di sini dan nggak pernah ada kendala di tengah jalan. Harganya bersahabat banget. Ditambah lagi adminnya super ramah dan enak banget diajak diskusi soal game terbaru."
                    </p>
                    <div class="flex items-center gap-4 pl-4">
                        <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center font-bold text-white shadow-inner overflow-hidden border border-slate-700">
                            <img src="/images/ruli.jpg" alt="Ruli" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="text-white font-bold font-display tracking-wide">Muhamad Ruli</h4>
                            <p class="text-blue-400 text-xs font-bold tracking-widest uppercase mt-0.5">Pelanggan Setia Rental</p>
                        </div>
                    </div>
                </div>

                <!-- Testimoni 4 -->
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400" class="glass-card p-8 rounded-2xl relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                    <div class="absolute left-0 top-6 bottom-6 w-1.5 rounded-r-full bg-gradient-to-b from-blue-400 to-cyan-500 opacity-80"></div>
                    <p class="text-slate-100 text-[1.05rem] leading-relaxed mb-8 relative pl-4 font-medium">
                        "Pelayanan Bintang Lima! Mulai dari admin yang sangat responsif sampai kondisi unit PS yang prima, semuanya luar biasa. Kalau lagi ada masalah atau bingung cara setting, adminnya sabar banget bantuin. Mantap Gamezone!"
                    </p>
                    <div class="flex items-center gap-4 pl-4">
                        <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center font-bold text-white shadow-inner overflow-hidden border border-slate-700">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?fit=crop&w=150&q=80" alt="Risal" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="text-white font-bold font-display tracking-wide">Muhamad Risal</h4>
                            <p class="text-blue-400 text-xs font-bold tracking-widest uppercase mt-0.5">SPESIALIS ALASAN STIK</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div id="faq" class="mt-32 mb-16 relative z-10 max-w-4xl mx-auto px-4 md:px-8">
            <div data-aos="fade-up" data-aos-duration="1000" class="text-center mb-12">
                <h2 class="text-blue-400 font-bold tracking-widest uppercase text-sm mb-2 font-display">Butuh Bantuan?</h2>
                <h3 class="text-3xl md:text-5xl font-display font-black text-white uppercase drop-shadow-lg">Tanya <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Jawab</span></h3>
                <p class="text-slate-300 mt-4 font-medium max-w-xl mx-auto text-lg hover:text-slate-100 transition-colors">Informasi penting seputar penyewaan konsol di GAMEZONE yang sering ditanyakan pelanggan.</p>
            </div>

            <div class="space-y-4" x-data="{ activeAccordion: null }">
                
                <!-- FAQ 1 -->
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100" class="glass-panel border-2 border-white/10 rounded-[1.5rem] overflow-hidden transition-all duration-300" :class="activeAccordion === 1 ? 'border-blue-500/50 shadow-[0_0_30px_rgba(59,130,246,0.15)] bg-slate-900/90' : 'hover:border-white/20'">
                    <button @click="activeAccordion = activeAccordion === 1 ? null : 1" class="w-full px-6 py-5 md:py-6 flex items-center justify-between text-left focus:outline-none transition-transform active:scale-[0.98]">
                        <span class="font-display font-bold text-lg md:text-xl transition-colors" :class="activeAccordion === 1 ? 'text-white' : 'text-slate-100'">Apa syarat untuk menyewa konsol untuk dibawa pulang?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300 text-blue-400 flex-shrink-0 ml-4" :class="activeAccordion === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="activeAccordion === 1" x-collapse x-transition.duration.300ms>
                        <div class="px-6 pb-6 lg:pb-8 pt-0 text-slate-300 leading-relaxed font-medium md:text-lg border-t border-white/5 mt-2">
                            Untuk menjaga keamanan unit, penyewa yang memilih opsi "Bawa Pulang" diwajibkan untuk menyerahkan/menjaminkan minimal <strong class="text-blue-300">E-KTP asli dan STNK Motor</strong> atas nama penyewa pada saat pengambilan konsol di toko kami. Jaminan akan dikembalikan utuh saat konsol kembali.
                        </div>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200" class="glass-panel border-2 border-white/10 rounded-[1.5rem] overflow-hidden transition-all duration-300" :class="activeAccordion === 2 ? 'border-red-500/50 shadow-[0_0_30px_rgba(239,68,68,0.15)] bg-slate-900/90' : 'hover:border-white/20'">
                    <button @click="activeAccordion = activeAccordion === 2 ? null : 2" class="w-full px-6 py-5 md:py-6 flex items-center justify-between text-left focus:outline-none transition-transform active:scale-[0.98]">
                        <span class="font-display font-bold text-lg md:text-xl transition-colors" :class="activeAccordion === 2 ? 'text-red-400' : 'text-slate-100'">Apakah ada denda jika terlambat mengembalikan konsol?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300 text-red-500 flex-shrink-0 ml-4" :class="activeAccordion === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="activeAccordion === 2" x-collapse x-transition.duration.300ms>
                        <div class="px-6 pb-6 lg:pb-8 pt-0 text-slate-300 leading-relaxed font-medium md:text-lg border-t border-red-500/10 mt-2">
                            <strong class="text-red-400 bg-red-400/10 px-2 py-0.5 rounded">Ya, tentu ada.</strong> Toleransi keterlambatan adalah 30 menit. Lebih dari waktu tersebut, Anda akan dikenakan denda keterlambatan sebesar <strong class="text-red-300">Rp 5.000 sampai Rp 10.000 per jam</strong> (tergantung jenis mesin konsol). Keterlambatan melebihi 5 jam terhitung sebagai perpanjangan 1 hari penuh.
                        </div>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300" class="glass-panel border-2 border-white/10 rounded-[1.5rem] overflow-hidden transition-all duration-300" :class="activeAccordion === 3 ? 'border-blue-500/50 shadow-[0_0_30px_rgba(59,130,246,0.15)] bg-slate-900/90' : 'hover:border-white/20'">
                    <button @click="activeAccordion = activeAccordion === 3 ? null : 3" class="w-full px-6 py-5 md:py-6 flex items-center justify-between text-left focus:outline-none transition-transform active:scale-[0.98]">
                        <span class="font-display font-bold text-lg md:text-xl transition-colors" :class="activeAccordion === 3 ? 'text-white' : 'text-slate-100'">Metode pembayaran apa saja yang diterima?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300 text-blue-400 flex-shrink-0 ml-4" :class="activeAccordion === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="activeAccordion === 3" x-collapse x-transition.duration.300ms>
                        <div class="px-6 pb-6 lg:pb-8 pt-0 text-slate-300 leading-relaxed font-medium md:text-lg border-t border-white/5 mt-2">
                            Kami berusaha memudahkan pelanggan. Anda dapat membayar menggunakan <span class="text-green-400 font-medium">Cash (Tunai)</span> secara langsung di lokasi (Kasir), atau secara digital (Online) menggunakan <span class="text-purple-400 font-medium">Kartu Kredit/Debit</span> (Visa/Mastercard) langsung di website ini.
                        </div>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400" class="glass-panel border-2 border-white/10 rounded-[1.5rem] overflow-hidden transition-all duration-300" :class="activeAccordion === 4 ? 'border-blue-500/50 shadow-[0_0_30px_rgba(59,130,246,0.15)] bg-slate-900/90' : 'hover:border-white/20'">
                    <button @click="activeAccordion = activeAccordion === 4 ? null : 4" class="w-full px-6 py-5 md:py-6 flex items-center justify-between text-left focus:outline-none transition-transform active:scale-[0.98]">
                        <span class="font-display font-bold text-lg md:text-xl transition-colors" :class="activeAccordion === 4 ? 'text-white' : 'text-slate-100'">Apakah saya bisa me-request game spesifik di dalam konsol?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300 text-blue-400 flex-shrink-0 ml-4" :class="activeAccordion === 4 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="activeAccordion === 4" x-collapse x-transition.duration.300ms>
                        <div class="px-6 pb-6 lg:pb-8 pt-0 text-slate-300 leading-relaxed font-medium md:text-lg border-t border-white/5 mt-2">
                            Pasti Bisa! Semua unit konsol kami sudah dipenuhi dengan ratusan katalog game terpopuler seperti eFootball 2026, EA Sports FC 26, GTA V, God of War, dan lainnya. Khusus untuk <strong class="text-white">PS4 dan PS5</strong>, Anda bisa konfirmasi ke admin via WhatsApp untuk request instalasi/download game tertentu khusus.
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Footer with Map -->
        <footer class="mt-24 border-t border-white/10 bg-ps-surface/50 backdrop-blur-xl rounded-t-[3rem] px-8 py-12 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900/20 to-transparent z-0"></div>
            <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-12">
                <div data-aos="fade-right" data-aos-duration="1000">
                    <h3 class="text-3xl font-display font-black text-white mb-6 uppercase tracking-wider">LOKASI RENTAL</h3>
                    <p class="text-slate-100 mb-6 font-medium">Kunjungi markas kami untuk mengecek langsung kesiapan konsol sebelum menyewa. Parkir luas, ruang tunggu AC!</p>
                    <div class="flex items-center gap-3 text-slate-300 mb-2">
                        <svg class="w-6 h-6 text-ps-neon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Watu Kandang, Penanggal, Kec. Candipuro, Kabupaten Lumajang, Jawa Timur</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-300">
                        <svg class="w-6 h-6 text-ps-neon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Buka Setiap Hari (24 Jam)</span>
                    </div>
                </div>
                <div data-aos="fade-left" data-aos-duration="1000" class="h-64 rounded-2xl overflow-hidden border border-white/10 shadow-[0_0_30px_rgba(59,130,246,0.15)] filter brightness-90 relative">
                    <!-- Menggunakan Plus Code V25M+QRH untuk titik seakurat mungkin -->
                    <iframe class="absolute inset-0 w-full h-full" src="https://maps.google.com/maps?q=V25M%2BQRH,%20Watu%20Kandang,%20Penanggal,%20Candipuro,%20Lumajang,%20Jawa%20Timur&t=&z=18&ie=UTF8&iwloc=&output=embed" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="text-center mt-12 pt-8 border-t border-white/10 text-slate-500 font-medium tracking-widest font-display">
                &copy; <?php echo e(date('Y')); ?> GAMEZONE INC. ALL RIGHTS RESERVED.
            </div>
        </footer>

    </main>

    <!-- Floating WA Button -->
    <a href="https://wa.me/6285808750161?text=Halo%20GAMEZONE,%20saya%20tertarik%20untuk%20rental%20console!" target="_blank" class="fixed bottom-8 right-8 w-16 h-16 bg-green-500 rounded-full flex items-center justify-center shadow-[0_0_25px_rgba(34,197,94,0.6)] hover:bg-green-400 hover:scale-110 transition-all duration-300 z-50 group">
        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        <span class="absolute right-20 bg-slate-900 text-white px-4 py-2 rounded-xl text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap shadow-xl font-display border border-slate-700">Chat Admin Rental</span>
    </a>

    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
<?php /**PATH C:\rental ps\resources\views/welcome.blade.php ENDPATH**/ ?>