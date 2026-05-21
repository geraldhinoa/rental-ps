<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-3xl font-display font-bold text-white mb-2">Manajemen <span class="text-blue-500">Pesanan</span></h1>
    <p class="text-slate-400">Kelola dan konfirmasi semua permintaan sewa konsol di sini.</p>
</div>

<!-- Simulasi Konten -->
<div class="glass-panel rounded-2xl border border-white/5 p-8 text-center text-slate-500">
    <?php if($bookings->isEmpty()): ?>
        <div class="flex flex-col items-center justify-center py-12">
            <svg class="w-16 h-16 text-slate-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            <h3 class="text-xl font-bold text-white mb-2">Belum ada pesanan aktif</h3>
            <p class="max-w-md mx-auto">Saat Anda mulai menerima pesanan dari halaman Booking, tabel antrean akan muncul di sini secara otomatis.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto text-left" x-data="{ showEditModal: false, editForm: { id: '', inventory_id: '', status: '' }, filter: 'all' }">
            <div class="flex gap-2 mb-6">
                <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-blue-600 text-white' : 'bg-slate-800 text-slate-400 border border-slate-700'" class="px-4 py-2 rounded-lg font-bold text-sm transition-all">Semua Pesanan</button>
                <button @click="filter = 'lunas'" :class="filter === 'lunas' ? 'bg-green-600 text-white shadow-[0_0_15px_rgba(34,197,94,0.3)]' : 'bg-slate-800 text-slate-400 border border-slate-700'" class="px-4 py-2 rounded-lg font-bold text-sm transition-all">Sudah Lunas</button>
                <button @click="filter = 'belum'" :class="filter === 'belum' ? 'bg-red-600 text-white shadow-[0_0_15px_rgba(239,68,68,0.3)]' : 'bg-slate-800 text-slate-400 border border-slate-700'" class="px-4 py-2 rounded-lg font-bold text-sm transition-all">Belum Lunas</button>
            </div>
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-700 text-slate-400">
                        <th class="py-4 px-4 font-medium">ID Transaksi</th>
                        <th class="py-4 px-4 font-medium">Pelanggan</th>
                        <th class="py-4 px-4 font-medium">Mesin</th>
                        <th class="py-4 px-4 font-medium">Waktu/Durasi</th>
                        <th class="py-4 px-4 font-medium">Status Sewa</th>
                        <th class="py-4 px-4 font-medium">Pembayaran</th>
                        <th class="py-4 px-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr x-show="filter === 'all' || (filter === 'lunas' && '<?php echo e($booking->payment->payment_status ?? 'pending'); ?>' === 'success') || (filter === 'belum' && '<?php echo e($booking->payment->payment_status ?? 'pending'); ?>' !== 'success')" class="border-b border-slate-800/50 hover:bg-slate-800/30 transition">
                        <td class="py-4 px-4 text-white font-bold">#TRX-0<?php echo e($booking->id * 100); ?></td>
                        <td class="py-4 px-4 text-slate-300"><?php echo e($booking->user->name ?? 'Gelap'); ?></td>
                        <td class="py-4 px-4 text-blue-400"><?php echo e($booking->inventory->name ?? '-'); ?></td>
                        <td class="py-4 px-4 text-slate-400">
                            <?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('H:i')); ?>

                            <?php if($booking->status == 'active'): ?>
                                <div class="mt-1" x-data="{
                                    end: new Date('<?php echo e(\Carbon\Carbon::parse($booking->end_time)->toISOString()); ?>').getTime(),
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
                                    <div :class="(end - now) < 0 ? 'bg-red-500/20 text-red-400 border-red-500/50' : 'bg-blue-500/20 text-blue-400 border-blue-500/50'" class="px-2 py-1 rounded text-xs font-mono font-bold border inline-block mt-1">
                                        <span x-text="timeLeft()"></span>
                                    </div>
                                    <span x-show="(end - now) < 0" class="text-[10px] text-red-500 block uppercase font-bold mt-1 animate-pulse">!! Waktu Habis !!</span>
                                </div>
                            <?php else: ?>
                                <span class="text-xs text-slate-500 block">(Sampai <?php echo e(\Carbon\Carbon::parse($booking->end_time)->format('H:i')); ?>)</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-4">
                            <?php if($booking->status == 'pending'): ?>
                                <span class="bg-yellow-500/20 text-yellow-400 px-3 py-1 rounded-full text-xs font-bold border border-yellow-500/30 flex w-max items-center gap-2"><span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span> Menunggu</span>
                            <?php elseif($booking->status == 'active'): ?>
                                <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-xs font-bold border border-blue-500/30 flex w-max items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-400"></span> Main</span>
                            <?php else: ?>
                                <span class="bg-slate-500/20 text-slate-400 px-3 py-1 rounded-full text-xs font-bold border border-slate-500/30 flex w-max items-center gap-2">Selesai</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-4 font-bold">
                            <?php if(($booking->payment->payment_status ?? '') === 'success'): ?>
                                <span class="text-green-400 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> LUNAS</span>
                            <?php else: ?>
                                <span class="text-red-400 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> BELUM</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-4 text-right flex justify-end gap-2">
                            <?php if($booking->status == 'pending'): ?>
                                <form action="<?php echo e(route('admin.bookings.process', $booking->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" onclick="return confirm('Mulai mainkan pesanan ini?')" class="bg-blue-600/20 hover:bg-blue-600 border border-blue-500 transition-colors text-white px-3 py-1.5 rounded-lg text-sm font-bold">Proses</button>
                                </form>
                            <?php elseif($booking->status == 'active'): ?>
                                <form action="<?php echo e(route('admin.bookings.finish', $booking->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" onclick="return confirm('Selesaikan pesanan ini dan kembalikan stok mesin?')" class="bg-green-600/20 hover:bg-green-600 border border-green-500 transition-colors text-white px-3 py-1.5 rounded-lg text-sm font-bold">Selesai</button>
                                </form>
                            <?php endif; ?>
                            
                            <button @click="showEditModal = true; editForm.id = '<?php echo e($booking->id); ?>'; editForm.inventory_id = '<?php echo e($booking->inventory_id); ?>'; editForm.status = '<?php echo e($booking->status); ?>'" class="bg-slate-700/50 hover:bg-slate-700 border border-slate-600 transition-colors text-white px-3 py-1.5 rounded-lg text-sm font-bold">Edit</button>
                            
                            <form action="<?php echo e(route('admin.bookings.destroy', $booking->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')" class="bg-red-600/20 hover:bg-red-600 border border-red-500 transition-colors text-white px-3 py-1.5 rounded-lg text-sm font-bold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <!-- Edit Modal -->
            <div x-show="showEditModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
                <div @click.away="showEditModal = false" class="bg-slate-900 border border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl">
                    <h3 class="text-xl font-bold text-white mb-4">Edit Pesanan</h3>
                    <form :action="'/admin/bookings/' + editForm.id" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-slate-400 mb-2">Status Pesanan</label>
                            <select name="status" x-model="editForm.status" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="pending">Menunggu Validasi</option>
                                <option value="active">Sedang Bermain</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="block text-sm font-bold text-slate-400 mb-2">Ubah Mesin</label>
                            <select name="inventory_id" x-model="editForm.inventory_id" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-4 py-2.5 text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="">-- Tanpa Mesin --</option>
                                <?php $__currentLoopData = $inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($inv->id); ?>"><?php echo e($inv->name); ?> (<?php echo e($inv->status); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" @click="showEditModal = false" class="px-4 py-2 rounded-lg font-bold text-slate-400 hover:text-white transition-colors">Batal</button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold px-6 py-2 rounded-lg transition-colors shadow-lg shadow-blue-500/20">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\rental ps\resources\views/backend/bookings.blade.php ENDPATH**/ ?>