<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Animal;

class AnimalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Animal::create([
            'owner_id' => '1',
            'name' => 'Cows',
            'type' => 'domestic',
            'description' => 'for milk'
        ]);

        Animal::create([
            'owner_id' => '1',
            'name' => 'Donkeys',
            'type' => 'domestic',
            'description' => 'for transport'
        ]);

        Animal::create([
            'owner_id' => '1',
            'name' => 'Bulls',
            'type' => 'domestic',
            'description' => 'for ploughing'
        ]);
        
        Animal::create([
            'owner_id' => '1',
            'name' => 'Cat',
            'type' => 'pet',
            'description' => 'for killing rats'
        ]);
        
        Animal::create([
            'owner_id' => '1',
            'name' => 'Dog',
            'type' => 'pet',
            'description' => 'for security'
        ]);        
        
        Animal::create([
            'owner_id' => '1',
            'name' => 'Rabbits',
            'type' => 'domestic',
            'description' => 'for sale'
        ]); 

        Animal::create([
            'owner_id' => '1',
            'name' => 'Goats',
            'type' => 'domestic',
            'description' => 'for sale'
        ]);

        Animal::create([
            'owner_id' => '1',
            'name' => 'Sheep',
            'type' => 'domestic',
            'description' => 'for sale'
        ]);

        Animal::create([
            'owner_id' => '1',
            'name' => 'Camels',
            'type' => 'domestic',
            'description' => 'for sale'
        ]);                               
    }
}
