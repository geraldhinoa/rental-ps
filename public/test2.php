<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$b = App\Models\Booking::latest()->first();
echo 'RAW DB: ' . $b->end_time . "\n";
echo 'FORMATTED: ' . \Carbon\Carbon::parse($b->end_time)->format('Y-m-d H:i:s') . "\n";
echo 'FINAL TS: ' . (\Carbon\Carbon::parse(\Carbon\Carbon::parse($b->end_time)->format('Y-m-d H:i:s'), 'Asia/Jakarta')->timestamp * 1000) . "\n";
echo 'NOW TS JS WILL USE (approximate): ' . (time() * 1000) . "\n";
