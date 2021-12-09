<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class DomesticDrugCost extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'animal_id','drug_type','quantity_bought','amount_paid',
        'date_of_purchase'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }     
}
