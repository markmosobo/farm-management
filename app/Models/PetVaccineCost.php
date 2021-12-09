<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class PetVaccineCost extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'animal_id','vaccine_type','quantity_bought','amount_paid',
        'date_of_purchase'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }     
}
