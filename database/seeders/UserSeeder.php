<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──
        User::create([
            'name'      => 'Administrator',
            'username'  => 'admin',
            'email'     => 'admin@smkn4bdg.sch.id',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // ── Siswa ──
        $siswa = [
            ['name' => 'Budi Santoso',   'username' => 'budi',   'kelas' => 'XII RPL 1'],
            ['name' => 'Dewi Rahayu',    'username' => 'dewi',   'kelas' => 'XII DKV 2'],
            ['name' => 'Ahmad Fauzi',    'username' => 'ahmad',  'kelas' => 'XII TOI 1'],
            ['name' => 'Siti Nurhaliza', 'username' => 'siti',   'kelas' => 'XII TAV 2'],
            ['name' => 'Rizky Pratama',  'username' => 'rizky',  'kelas' => 'XII RPL 2'],
        ];

        foreach ($siswa as $s) {
            User::create([
                'name'      => $s['name'],
                'username'  => $s['username'],
                'email'     => $s['username'] . '@siswa.smkn4bdg.sch.id',
                'password'  => Hash::make('siswa123'),
                'role'      => 'user',
                'kelas'     => $s['kelas'],
                'is_active' => true,
            ]);
        }
    }
}
