<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - GAMEZONE</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {
            fontFamily: {
              display: ['Poppins', 'sans-serif'],
              body: ['Inter', 'sans-serif'],
            }
          }
        }
      }
    </script>
</head>
<body class="bg-[#030712] text-slate-300 font-body antialiased min-h-screen flex items-center justify-center relative">
    
    <!-- Background Blur Orbs -->
    <div class="fixed top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px] z-0 pointer-events-none"></div>
    <div class="fixed bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px] z-0 pointer-events-none"></div>

    <div class="w-full max-w-md p-8 relative z-10 pt-10 my-8">
        <!-- Logo -->
        <a href="/" class="flex items-center justify-center gap-3 mb-10 group opacity-80 hover:opacity-100 transition">
            <div class="relative w-12 h-12 flex items-center justify-center bg-gradient-to-br from-blue-600 to-indigo-800 rounded-xl shadow-[0_0_20px_rgba(59,130,246,0.6)] transform rotate-45">
                <div class="-rotate-45">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <span class="font-display font-black text-3xl tracking-wider text-white uppercase ml-2">GAME<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">ZONE</span></span>
        </a>

        <!-- Register Card -->
        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/10 rounded-[2rem] p-8 shadow-2xl relative overflow-hidden">
            <h2 class="text-2xl font-display font-bold text-white mb-2 text-center">Buat Akun Dulu</h2>
            <p class="text-slate-400 text-sm text-center mb-8">Bergabunglah untuk sewa konsol impianmu.</p>

            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500/50 text-red-300 font-medium text-xs rounded-xl p-4 mb-6 relative">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="/register" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-xs font-bold tracking-widest text-slate-400 mb-2 uppercase">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-slate-950 border border-white/10 rounded-xl px-4 py-3.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold tracking-widest text-slate-400 mb-2 uppercase">Nomor WhatsApp</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}" required class="w-full bg-slate-950 border border-white/10 rounded-xl px-4 py-3.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold tracking-widest text-slate-400 mb-2 uppercase">Email Aktif</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-slate-950 border border-white/10 rounded-xl px-4 py-3.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold tracking-widest text-slate-400 mb-2 uppercase">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full bg-slate-950 border border-white/10 rounded-xl px-4 py-3.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold tracking-widest text-slate-400 mb-2 uppercase">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" required class="w-full bg-slate-950 border border-white/10 rounded-xl px-4 py-3.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium text-sm">
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 font-display font-bold py-4 text-white rounded-xl shadow-[0_0_20px_rgba(59,130,246,0.3)] transition-all active:scale-95 uppercase tracking-widest border border-white/10 mt-2">
                    Daftar Sekarang
                </button>
            </form>

            <p class="text-[10px] text-slate-500 text-center mt-4">Dengan mendaftar, Anda menyetujui Syarat dan Ketentuan layanan kami.</p>

            <div class="relative flex items-center py-6">
                <div class="flex-grow border-t border-white/10"></div>
                <span class="flex-shrink-0 mx-4 text-slate-500 text-xs font-bold tracking-widest uppercase">ATAU</span>
                <div class="flex-grow border-t border-white/10"></div>
            </div>

            <a href="/auth/google" class="w-full bg-white text-slate-900 hover:bg-slate-200 font-body font-semibold py-3.5 px-4 rounded-xl flex items-center justify-center gap-3 transition-all active:scale-95 shadow-[0_0_20px_rgba(255,255,255,0.2)]">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Lanjutkan dengan Google
            </a>
            <div class="mt-8 text-center space-y-4">
                <p class="text-sm text-slate-400">Sudah punya akun? <a href="/login" class="text-blue-400 font-bold hover:text-blue-300">Masuk</a></p>
                <a href="/" class="text-xs font-semibold text-slate-500 hover:text-white transition block">← Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>
</body>
</html>
