<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        User::create([
            'uuid'              => uuid(),
            'first_name'        => 'Mr.',
            'last_name'         => 'Admin',
            'is_admin'          => 1,
            'email'             => 'admin@email.com',
            'email_verified_at' => now(),
            'password'          => bcrypt('123456'),
            'address'           => 'Khulna, Bangladesh',
            'phone_number'      => '+880175009149',
        ]);

        User::create([
            'uuid'              => uuid(),
            'first_name'        => 'Rabiul',
            'last_name'         => 'Islam',
            'is_admin'          => 0,
            'email'             => 'user@email.com',
            'email_verified_at' => now(),
            'password'          => bcrypt('123456'),
            'address'           => 'Khulna, Bangladesh',
            'phone_number'      => '+880175009149',
        ]);
    }
}
