<?php
namespace Database\Seeders;

use App\Models\{KasBulanan, Setting, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KasSeeder extends Seeder
{
    public function run(): void
    {
        User::forceCreate(['name' => 'Admin', 'username' => 'admin', 'email' => 'admin@kas.test', 'password' => Hash::make('password'), 'role' => 'admin']);
        foreach (['budi', 'siti', 'andi'] as $u) {
            User::forceCreate(['name' => ucfirst($u), 'username' => $u, 'email' => "$u@kas.test", 'password' => Hash::make('password'), 'role' => 'user']);
        }
        KasBulanan::create(['bulan' => now()->month, 'tahun' => now()->year, 'nominal_kas' => 10000]);
        Setting::put('payment_mode', 'static');
    }
}
