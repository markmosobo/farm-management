<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crop;

class SubCashPlantingDetail extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'crop_id','date_of_planting','fertilizer_type','fertilizer_quantity',
        'seed_quantity','acreage_planted'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }    
}
