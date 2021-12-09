<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crop;

class CashPlantingFertilizerCost extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'fertilizer_type','date_of_purchase','quantity_bought','amount_paid','crop_id'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }    
}
