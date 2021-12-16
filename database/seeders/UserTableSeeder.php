<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'User One',
            'email' => 'userone@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'farmer'
        ]);
   
        User::create([
            'name' => 'User Two',
            'email' => 'usertwo@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'user'
        ]);        
    }
}
