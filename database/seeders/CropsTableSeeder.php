<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Crop;

class CropsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Crop::create([
            'owner_id' => '1',
            'name' => 'Maize',
            'type' => 'subsistence',
            'description' => 'long season'
        ]);
        Crop::create([
            'owner_id' => '1',
            'name' => 'Beans',
            'type' => 'subsistence',
            'description' => 'short season'
        ]);
        Crop::create([
            'owner_id' => '1',
            'name' => 'Millet',
            'type' => 'subsistence',
            'description' => 'short season'
        ]);
        Crop::create([
            'owner_id' => '1',
            'name' => 'Potatoes',
            'type' => 'subsistence',
            'description' => 'shortseason'
        ]);
        Crop::create([
            'owner_id' => '1',
            'name' => 'Tea',
            'type' => 'cashcrop',
            'description' => 'for cash'
        ]);
        Crop::create([
            'owner_id' => '1',
            'name' => 'Coffee',
            'type' => 'cashcrop',
            'description' => 'for cash'
        ]);
        Crop::create([
            'owner_id' => '1',
            'name' => 'Potatoes',
            'type' => 'subcashcrop',
            'description' => 'short season'
        ]);                                                
    }
}
