<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buat Sandi Baru - GAMEZONE</title>
    
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

    <div class="w-full max-w-md p-8 relative z-10 pt-10">
        <!-- Logo -->
        <a href="/" class="flex items-center justify-center gap-3 mb-10 group opacity-80 hover:opacity-100 transition">
            <div class="relative w-12 h-12 flex items-center justify-center bg-gradient-to-br from-blue-600 to-indigo-800 rounded-xl shadow-[0_0_20px_rgba(59,130,246,0.6)] transform rotate-45">
                <div class="-rotate-45">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <span class="font-display font-black text-3xl tracking-wider text-white uppercase ml-2">GAME<span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">ZONE</span></span>
        </a>

        <!-- Card -->
        <div class="bg-slate-900/40 backdrop-blur-xl border border-white/10 rounded-[2rem] p-8 shadow-2xl relative overflow-hidden">
            <h2 class="text-2xl font-display font-bold text-white mb-2 text-center">Buat Kata Sandi Baru</h2>
            <p class="text-slate-400 text-sm text-center mb-8">Silakan buat kata sandi baru untuk akun Anda.</p>

            @if($errors->any())
                <div class="bg-slate-800/80 border border-red-500/50 text-red-400 font-medium text-sm rounded-xl p-4 mb-6 relative text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div>
                    <label class="block text-xs font-bold tracking-widest text-slate-400 mb-2 uppercase">Email Aktif</label>
                    <input type="email" name="email" value="{{ request()->email }}" required readonly class="w-full bg-slate-900 border border-white/5 rounded-xl px-4 py-3.5 text-slate-400 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium text-sm cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-xs font-bold tracking-widest text-slate-400 mb-2 uppercase">Kata Sandi Baru</label>
                    <input type="password" name="password" required class="w-full bg-slate-950 border border-white/10 rounded-xl px-4 py-3.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium text-sm">
                </div>
                
                <div>
                    <label class="block text-xs font-bold tracking-widest text-slate-400 mb-2 uppercase">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" required class="w-full bg-slate-950 border border-white/10 rounded-xl px-4 py-3.5 text-white focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all font-medium text-sm">
                </div>
                
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 font-display font-bold py-4 text-white rounded-xl shadow-[0_0_20px_rgba(59,130,246,0.3)] transition-all active:scale-95 uppercase tracking-widest border border-white/10">
                    Simpan Kata Sandi
                </button>
            </form>
        </div>
    </div>
</body>
</html>
