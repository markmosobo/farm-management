<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Crop;

class SubPlantingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_id','date_of_planting','acreage_planted','fertilizer_type',
        'fertilizer_quantity','seed_quantity'
    ];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
