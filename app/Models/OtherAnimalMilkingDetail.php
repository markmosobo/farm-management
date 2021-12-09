<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Animal;

class OtherAnimalMilkingDetail extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'animal_id','animal_code','milk_quantity','date_of_milking',
        'milker_name'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }    
}
