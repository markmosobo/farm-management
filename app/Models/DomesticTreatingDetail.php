<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class DomesticTreatingDetail extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'animal_id','date_of_treating','no_of_animals',
        'drug_type','drug_quantity'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }     
}
