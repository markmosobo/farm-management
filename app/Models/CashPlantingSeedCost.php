<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crop;

class CashPlantingSeedCost extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'crop_id','seed_type','quantity_bought','amount_paid','date_of_purchase'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }    
}
