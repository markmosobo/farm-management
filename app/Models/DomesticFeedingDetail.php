<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class DomesticFeedingDetail extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'animal_id','date_of_feeding','feed_type','feed_quantity',
        'no_of_animals'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
