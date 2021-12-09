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
            'name' => 'Isaac Muchogu',
            'email' => 'muchogu@gmail.com',
            'password' => Hash::make('123456'),
        ]);
   
        User::create([
            'name' => 'Peter Mokosu',
            'email' => 'mokosu@gmail.com',
            'password' => Hash::make('123456'),
        ]);        
    }
}
