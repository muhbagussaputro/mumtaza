<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@mumtaza.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        // Guru users
        User::create([
            'name' => 'Ustadz Ahmad',
            'email' => 'ahmad@mumtaza.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'status_aktif' => true,
            'telepon' => '081234567890',
        ]);

        User::create([
            'name' => 'Ustadzah Fatimah',
            'email' => 'fatimah@mumtaza.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'status_aktif' => true,
            'telepon' => '081234567891',
        ]);

        // Sample students
        User::create([
            'name' => 'Muhammad Ali',
            'email' => 'ali@student.mumtaza.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'status_aktif' => true,
            'nis' => '2024001',
            'nisn' => '1234567890',
            'telepon' => '081234567892',
            'orang_tua_nama' => 'Bapak Ali Senior',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '2010-01-15',
            'alamat' => 'Jl. Pendidikan No. 1, Jakarta',
        ]);

        User::create([
            'name' => 'Siti Aisyah',
            'email' => 'aisyah@student.mumtaza.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'status_aktif' => true,
            'nis' => '2024002',
            'nisn' => '1234567891',
            'telepon' => '081234567893',
            'orang_tua_nama' => 'Ibu Aisyah Senior',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2010-03-20',
            'alamat' => 'Jl. Pendidikan No. 2, Bandung',
        ]);
    }
}
