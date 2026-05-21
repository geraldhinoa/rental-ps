<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-3xl font-display font-bold text-white mb-2">Halo, Admin! 👋</h1>
    <p class="text-slate-400">Berikut adalah update rental Anda secara real-time hari ini.</p>
</div>

<!-- Metrics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition"></div>
        <div class="flex items-start justify-between mb-2">
            <h3 class="text-slate-400 text-sm font-medium">Pendapatan Hari Ini</h3>
            <div class="p-2 bg-blue-500/20 rounded-lg text-blue-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <h2 class="text-3xl font-bold tracking-tight text-white mb-1">Rp <?php echo e(number_format($revenue, 0, ',', '.')); ?></h2>
        <p class="text-xs text-green-400 flex items-center gap-1">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            +15% dari kemarin
        </p>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-cyan-500/10 rounded-full blur-2xl group-hover:bg-cyan-500/20 transition"></div>
        <div class="flex items-start justify-between mb-2">
            <h3 class="text-slate-400 text-sm font-medium">Pesanan Aktif</h3>
            <div class="p-2 bg-cyan-500/20 rounded-lg text-cyan-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <h2 class="text-3xl font-bold tracking-tight text-white mb-1"><?php echo e($activeRentals); ?> <span class="text-lg text-slate-500 font-normal">Sewa</span></h2>
        <div class="flex gap-2 text-[10px] text-cyan-400 font-bold border-t border-white/5 pt-2 mt-1">
            <span><?php echo e($activePS5); ?> PS5</span> &bull; 
            <span><?php echo e($activePS4); ?> PS4</span> &bull; 
            <span><?php echo e($activePS3); ?> PS3</span>
        </div>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-500/10 rounded-full blur-2xl group-hover:bg-yellow-500/20 transition"></div>
        <div class="flex items-start justify-between mb-2">
            <h3 class="text-slate-400 text-sm font-medium">Menunggu Validasi</h3>
            <div class="p-2 bg-yellow-500/20 rounded-lg text-yellow-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <h2 class="text-3xl font-bold tracking-tight text-white mb-1"><?php echo e($pendingBookings); ?> <span class="text-lg text-slate-500 font-normal">Antrean</span></h2>
        <p class="text-xs text-yellow-400">Memerlukan Konfirmasi</p>
    </div>

    <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl group-hover:bg-purple-500/20 transition"></div>
        <div class="flex items-start justify-between mb-2">
            <h3 class="text-slate-400 text-sm font-medium">Ketersediaan Mesin</h3>
            <div class="p-2 bg-purple-500/20 rounded-lg text-purple-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>
            </div>
        </div>
        <h2 class="text-3xl font-bold tracking-tight text-white mb-1"><?php echo e($availableMachines); ?>/<?php echo e($totalMachines); ?></h2>
        <p class="text-xs text-slate-400">Mesin sedang menganggur</p>
    </div>
</div>

<!-- Revenue Chart -->
<div class="glass-panel p-6 rounded-2xl relative overflow-hidden mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-white">Tren Pendapatan (7 Hari Terakhir)</h3>
        <div class="p-2 bg-blue-500/20 rounded-lg text-blue-400">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
        </div>
    </div>
    <div class="relative h-72 w-full">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<!-- Data Table -->
<div class="glass-panel rounded-2xl overflow-hidden">
    <div class="p-6 border-b border-slate-800 flex items-center justify-between">
        <h3 class="text-lg font-bold text-white">Transaksi Terbaru</h3>
        <button class="bg-slate-800 text-sm text-slate-300 font-medium px-4 py-2 rounded-lg hover:bg-slate-700 transition">Lihat Semua</button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-900/50 text-slate-400 border-b border-slate-800">
                <tr>
                    <th class="px-6 py-4 font-medium">ID Transaksi</th>
                    <th class="px-6 py-4 font-medium">Pelanggan</th>
                    <th class="px-6 py-4 font-medium">Mesin</th>
                    <th class="px-6 py-4 font-medium">Waktu/Durasi</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/80">
                <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-slate-800/30 transition">
                    <td class="px-6 py-4 text-white font-medium">#TRX-0<?php echo e($trx->id * 100); ?></td>
                    <td class="px-6 py-4 text-slate-300"><?php echo e($trx->user->name ?? 'Guest'); ?></td>
                    <td class="px-6 py-4 text-ps-neon cursor-pointer hover:underline"><?php echo e($trx->inventory->name ?? 'PS Unit'); ?></td>
                    <td class="px-6 py-4 text-slate-400">
                        <?php echo e(\Carbon\Carbon::parse($trx->start_time)->format('H:i')); ?>

                        <?php if($trx->status == 'active'): ?>
                            <div class="mt-1" x-data="{
                                end: <?php echo e(\Carbon\Carbon::parse($trx->end_time)->timestamp * 1000); ?>,
                                now: new Date().getTime(),
                                timeLeft() {
                                    let diff = this.end - this.now;
                                    if(diff < 0) return '00:00:00';
                                    let h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                    let m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                                    let s = Math.floor((diff % (1000 * 60)) / 1000);
                                    return h.toString().padStart(2, '0') + ':' + m.toString().padStart(2, '0') + ':' + s.toString().padStart(2, '0');
                                }
                            }" x-init="setInterval(() => now = new Date().getTime(), 1000)">
                                <div :class="(end - now) < 0 ? 'bg-red-500/20 text-red-400 border-red-500/50' : 'bg-blue-500/20 text-blue-400 border-blue-500/50'" class="px-2 py-1 rounded text-xs font-mono font-bold border inline-block">
                                    <span x-text="timeLeft()"></span>
                                </div>
                                <span x-show="(end - now) < 0" class="text-[10px] text-red-500 block uppercase font-bold mt-1 animate-pulse">!! Waktu Habis !!</span>
                            </div>
                        <?php else: ?>
                            <span class="text-xs text-slate-500 block">(Sampai <?php echo e(\Carbon\Carbon::parse($trx->end_time)->format('H:i')); ?>)</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php if($trx->status === 'active'): ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-500/10 text-green-400 border border-green-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span> Aktif
                            </span>
                        <?php elseif($trx->status === 'pending'): ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500 border border-yellow-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Menunggu Validasi
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-500/10 text-slate-400 border border-slate-500/20">
                                Selesai
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <?php if($trx->status === 'pending'): ?>
                            <form action="<?php echo e(route('admin.bookings.process', $trx->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" onclick="return confirm('Mulai mainkan pesanan ini?')" class="text-blue-400 hover:text-blue-300 transition font-medium border border-blue-500/30 px-3 py-1 rounded-lg">Proses</button>
                            </form>
                        <?php elseif($trx->status === 'active'): ?>
                            <form action="<?php echo e(route('admin.bookings.finish', $trx->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" onclick="return confirm('Selesaikan pesanan ini dan kembalikan stok mesin?')" class="text-green-400 hover:text-green-300 transition font-medium border border-green-500/30 px-3 py-1 rounded-lg">Selesai</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                        Belum ada pesanan yang masuk ke toko Anda hari ini.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Create gradient
    let gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)'); // Blue-500 with opacity
    gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($chartLabels); ?>,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: <?php echo json_encode($chartData); ?>,
                borderColor: '#3b82f6', // blue-500
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#1e293b',
                pointBorderColor: '#3b82f6',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4 // Smooth curve
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleColor: '#94a3b8',
                    bodyColor: '#fff',
                    padding: 10,
                    borderColor: 'rgba(59, 130, 246, 0.3)',
                    borderWidth: 1,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#64748b'
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#64748b',
                        callback: function(value) {
                            if (value >= 1000000) {
                                return (value / 1000000) + 'M';
                            } else if (value >= 1000) {
                                return (value / 1000) + 'K';
                            }
                            return value;
                        }
                    }
                }
            }
        }
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\rental ps\resources\views/backend/dashboard.blade.php ENDPATH**/ ?>