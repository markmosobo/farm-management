<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class PetVaccinatingDetail extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'animal_id','date_of_vaccinating','no_of_animals',
        'vaccine_type','vaccine_quantity'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }    
}
