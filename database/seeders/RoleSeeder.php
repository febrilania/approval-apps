<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Administrator',
            'User',
            'Sarpras',
            'Perencanaan',
            'Pengadaan Barang',
            'Wakil Rektor 2',
        ];
        foreach ($roles as $role_name) {
            DB::table('roles')->insert([
                'role_name' => $role_name,
            ]);
        }
    }
}
