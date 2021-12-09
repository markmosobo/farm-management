<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class CowMilkSale extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'date_of_sale','no_sold','amount_got','animal_id'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }    
}
