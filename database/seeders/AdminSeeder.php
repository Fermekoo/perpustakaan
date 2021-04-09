<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Admin Pustaka',
            'email'     => 'dandifermeko@gmail.com',
            'password'  => Hash::make('12345678', []),
            'user_type' => 'Admin'
        ]);
    }
}
