<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Poultry;

class PoultryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Poultry::create([
            'owner_id' => '1',
            'name' => 'Hens',
            'type' => 'kienyeji',
        ]);

        Poultry::create([
            'owner_id' => '1',
            'name' => 'Hens',
            'type' => 'improved kienyeji',
        ]);
        
        Poultry::create([
            'owner_id' => '1',
            'name' => 'Hens',
            'type' => 'grade',
        ]);
        Poultry::create([
            'owner_id' => '1',
            'name' => 'Turkey',
            'type' => 'exotic',
        ]);
        
        Poultry::create([
            'owner_id' => '1',
            'name' => 'Peacocks',
            'type' => 'hybrid',
        ]);
        
        Poultry::create([
            'owner_id' => '1',
            'name' => 'Ducks',
            'type' => 'exotic',
        ]);
        
        Poultry::create([
            'owner_id' => '1',
            'name' => 'Pigeons',
            'type' => 'exotic',
        ]);        
    }
}
