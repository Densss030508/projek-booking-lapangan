<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [];

        $roles = ['admin', 'owner', 'kasir'];

        foreach ($roles as $role) {
            for ($i = 1; $i <= 3; $i++) {
                $users[] = [
                    'username' => $role . $i,
                    'nama' => ucfirst($role) . ' ' . $i,
                    'email' => $role . $i . '@gmail.com',
                    'password' => Hash::make('password'),
                    'role' => $role,
                    'status' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        User::insert($users);
    }
}
