<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::Create(
            [
                'email' => 'admin@admin.sk',
                'name' => 'admin',
                'password' => '123456',
                'is_admin' => true,
            ]
        );
    }
}
