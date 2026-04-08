<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'slug'     => Str::slug('Admin'),
            'email'    => 'adminVreator@gmail.com',
            'password' => Hash::make('admin1234'),
            'role' => 'admin',
            'whatsapp' => '089564738253'
        ]);
    }
}
