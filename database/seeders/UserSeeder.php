<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Puksi',
                'username' => 'puksi',
                'password' => Hash::make('puksi123'),
                'profile_picture' => null,
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Susilawati',
                'username' => 'susilawati',
                'password' => Hash::make('susilawati123'),
                'profile_picture' => null,
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'M. Shofi Mubarok',
                'username' => 'shofi',
                'password' => Hash::make('shofi123'),
                'profile_picture' => null,
                'role_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maria Ulfah',
                'username' => 'maria',
                'password' => Hash::make('maria123'),
                'profile_picture' => null,
                'role_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kurniawan',
                'username' => 'kurniawan',
                'password' => Hash::make('kurniawan123'),
                'profile_picture' => null,
                'role_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User1',
                'username' => 'user1',
                'password' => Hash::make('user1123'),
                'profile_picture' => null,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
