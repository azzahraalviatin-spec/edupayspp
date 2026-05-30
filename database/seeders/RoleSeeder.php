<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 3 role
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'petugas']);
        Role::create(['name' => 'siswa']);

        // Buat akun admin pertama
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@spp.com',
            'password' => Hash::make('password123'),
        ]);

        // Assign role admin
        $admin->assignRole('admin');
    }
}