<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Admin;
use App\Models\Produk;
use App\Models\Template;
use App\Models\Website;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = Admin::create([
            'nama_admin' => 'Admin Utama',
            'email' => 'admin@innova.web',
            'password' => Hash::make('password'),
        ]);

        $template = Template::create(['nama_template' => 'Editorial', 'jumlah_template' => 48]);
        $website = Website::create(['id_admin' => $admin->id_admin, 'id_template' => $template->id_template, 'nama_website' => 'Studio Senja', 'slug' => 'studio-senja', 'bio' => 'Studio fotografi dan visual storytelling.', 'status' => 'aktif']);
        Produk::create(['id_website' => $website->id_website, 'nama_produk' => 'Paket Prewedding', 'deskripsi_produk' => 'Sesi foto prewedding editorial.', 'harga' => 3500000, 'jumlah_produk' => 12]);
        ActivityLog::create(['id_admin' => $admin->id_admin, 'action' => 'Membuat website Studio Senja']);
    }
}
