<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\PricingPackage;
use App\Models\Promo;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Admin
        $this->call(AdminSeeder::class);

        // 2. Kategori
        $catPS5 = Category::firstOrCreate(['name' => 'PlayStation 5']);
        $catPS4 = Category::firstOrCreate(['name' => 'PlayStation 4']);
        $catPS3 = Category::firstOrCreate(['name' => 'PlayStation 3']);

        // 3. Inventaris Dummy
        Inventory::firstOrCreate(['name' => 'PS5 - Unit 01'], ['category_id' => $catPS5->id, 'status' => 'available']);

        Inventory::firstOrCreate(['name' => 'PS4 Pro - Unit 01'], ['category_id' => $catPS4->id, 'status' => 'available']);
        Inventory::firstOrCreate(['name' => 'PS4 Pro - Unit 02'], ['category_id' => $catPS4->id, 'status' => 'available']);

        for($i=1; $i<=4; $i++) {
            Inventory::firstOrCreate(['name' => 'PS3 Retro - Unit 0'.$i], ['category_id' => $catPS3->id, 'status' => 'available']);
        }

        // 4. Pricing Package Dummy
        PricingPackage::firstOrCreate(['package_name' => 'Reguler PS5', 'category_id' => $catPS5->id], ['duration_hours' => 1, 'price' => 10000]);
        PricingPackage::firstOrCreate(['package_name' => 'Reguler PS4', 'category_id' => $catPS4->id], ['duration_hours' => 1, 'price' => 6000]);
        PricingPackage::firstOrCreate(['package_name' => 'Reguler PS3', 'category_id' => $catPS3->id], ['duration_hours' => 1, 'price' => 4000]);

        // 5. Tabel Promo (Awal Kosong, tapi buat satu contoh)
        Promo::firstOrCreate(['code' => 'MARATHON35K'], [
            'description' => 'Paket Malam Marathon',
            'discount_amount' => 45000, 
            'is_active' => true
        ]);
        Promo::firstOrCreate(['code' => 'GAMERNEW'], [
            'description' => 'Potongan Spesial Pengguna Baru',
            'discount_amount' => 5000, 
            'is_active' => false
        ]);
    }
}
