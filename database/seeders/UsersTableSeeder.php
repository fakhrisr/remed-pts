<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'administrator',
            'email' => 'admins@gmail.com',
            'password' => Hash::make('admins'),
            'role' => 'admin',
        ]);
    }
}
