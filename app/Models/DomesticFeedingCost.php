<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class DomesticFeedingCost extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'animal_id','feed_type','quantity_bought','amount_paid'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }    
}
